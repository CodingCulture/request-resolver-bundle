<?php

namespace CodingCulture\RequestResolverBundle\Request;

use CodingCulture\RequestResolverBundle\Contract\ResolvableRequestInterface;
use CodingCulture\RequestResolverBundle\Resolver\RequestResolver;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GetResourceByIdRequest
 * @package CodingCulture\RequestResolverBundle\Request
 *
 * This is a quite generic request, but also highlights the usage and requirements of this request resolver bundle.
 * Once you have implemented all required methods from the ResolvableRequestInterface, you can then add the shorthand methods
 * for fetching properties of the request, shown as ResolvableRequestInterface::getId.
 *
 * Using an ResolvableRequestInterface::getOptions() method should be considered faux pas, in that the aim of this bundle is to structure the request.
 * If you want to do more in depth assertions -- like checking the database for a record matching the id -- you should look
 * at implementing it on the service level. Request objects are meant purely for structure and type.
 *
 * ResolvableRequestInterface::setOptions() should always wire up the private $options.
 *
 * ResolvableRequestInterface::getContentType() should return which Content-Type is expected of the request.
 */
class GetResourceByIdRequest implements ResolvableRequestInterface
{
    /**
     * @var array
     */
    private $options = [];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->options['id'];
    }
    
    /**
     * @param OptionsResolver $resolver
     *
     * @return OptionsResolver
     */
    public function defineOptions(OptionsResolver $resolver): OptionsResolver
    {
        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', ['int', 'string'])
        ;

        return $resolver;
    }

    /**
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return RequestResolver::CONTENT_TYPE_ALLOW_ALL;
    }
}
