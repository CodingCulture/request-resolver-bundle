<?php

namespace CodingCulture\RequestResolverBundle\Resolver;

use CodingCulture\RequestResolverBundle\Contract\ResolvableRequestInterface;
use CodingCulture\RequestResolverBundle\Factory\OptionsFactory;
use CodingCulture\RequestResolverBundle\Helper\TypeJuggleHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RequestResolver
 * @package App\CodingCulture\RequestResolverBundle\Resolver
 */
class RequestResolver
{
    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_FORM_DATA = '';
    const CONTENT_TYPE_ALLOW_ALL = 'all';

    /**
     * Resolves a ResolvableRequestInterface
     *
     * @param ResolvableRequestInterface $resolvable
     * @param Request                    $request
     *
     * @return ResolvableRequestInterface
     */
    public function resolve(ResolvableRequestInterface $resolvable, Request $request): ResolvableRequestInterface
    {
        $resolver = $resolvable->defineOptions(new OptionsResolver());

        $resolver->setDefault('_format', 'json');

        $this->validateHeaders($resolvable, $request);

        $options = $this->createOptionsForRequest($request);

        array_walk($options, function (&$value) {
            $value = TypeJuggleHelper::juggle($value);
        });

        $options = $resolver->resolve($options);

        $resolvable->setOptions($options);

        return $resolvable;
    }

    /**
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
            //todo throw new \Exception('');
        }
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function createOptionsForRequest(Request $request): array
    {
        $isJSONRequestRequired = $request->getContent() === self::CONTENT_TYPE_JSON;

        if ($isJSONRequestRequired) {
            $options = OptionsFactory::createFromJSON($request);

            return $options;
        }

        return OptionsFactory::createFromFormData($request);
    }
}