<?php

namespace CodingCulture\RequestResolverBundle\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpKernel\Exception\HttpException;
use CodingCulture\RequestResolverBundle\Factory\OptionsFactory;
use CodingCulture\RequestResolverBundle\Helper\TypeJuggleHelper;
use CodingCulture\RequestResolverBundle\Contract\HeaderableRequestInterface;
use CodingCulture\RequestResolverBundle\Contract\ResolvableRequestInterface;
use CodingCulture\RequestResolverBundle\Contract\ValidatableRequestInterface;

/**
 * Class RequestResolver
 * @package App\CodingCulture\RequestResolverBundle\Resolver
 */
class RequestResolver
{
    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_FORM_DATA = 'multipart/form-data';
    const CONTENT_TYPE_ALLOW_ALL = 'all';

    /**
     * @var Request
     */
    private $request;

    /**
     * RequestResolver constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Resolves a ResolvableRequestInterface
     *
     * @param ResolvableRequestInterface $resolvable
     *
     * @return ResolvableRequestInterface
     *
     * @throws \InvalidArgumentException|HttpException|\Exception
     */
    public function resolve(ResolvableRequestInterface $resolvable): ResolvableRequestInterface
    {
        $resolver = $resolvable->defineOptions(new OptionsResolver());

        $resolver->setDefault('_format', 'json');

        $this->validateHeaders($resolvable, $this->request);

        $options = $this->createOptionsForRequest($this->request);

        array_walk($options, function (&$value) {
            $value = TypeJuggleHelper::juggle($value);
        });

        $options = $resolver->resolve($options);

        $resolvable->setOptions($options);

        if ($resolvable instanceof HeaderableRequestInterface) {
            $requestHeaders = $this->request->headers->all();
            
            $headerResolver = $resolvable->defineHeaderOptions(new OptionsResolver());
            $headerResolver->setDefined(array_keys($requestHeaders));
            $resolvedHeaders = $headerResolver->resolve($requestHeaders);

            $resolvable->setHeaders($resolvedHeaders);
        }

        if ($resolvable instanceof ValidatableRequestInterface) {
            $resolvable->validate();
        }

        return $resolvable;
    }

    /**
     * Validates headers according to request object content type
     *
     * @param ResolvableRequestInterface $resolvable
     * @param Request $request
     *
     * @return void
     *
     * @throws \Exception
     */
    private function validateHeaders(ResolvableRequestInterface $resolvable, Request $request): void
    {
        $isJSONRequestRequired = $resolvable->getContentType() === self::CONTENT_TYPE_JSON;
        $isRequestJSON = $request->headers->get('Content-Type') === self::CONTENT_TYPE_JSON;

        if ($isJSONRequestRequired && !$isRequestJSON) {
            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                sprintf(
                    'The request made must be of Content-Type: application/json, but is %s',
                    $request->headers->get('Content-Type')
                )
            );
        }
    }

    /**
     * Creates the options to be resolved according to the request object content type
     *
     * @param Request $request
     *
     * @return array
     */
    private function createOptionsForRequest(Request $request): array
    {
        $isJSONRequestRequired = $request->headers->get('Content-Type') === self::CONTENT_TYPE_JSON && !$request->isMethod('GET');

        if ($isJSONRequestRequired) {
            $options = OptionsFactory::createFromJSON($request);

            return $options;
        }

        return OptionsFactory::createFromFormData($request);
    }
}
