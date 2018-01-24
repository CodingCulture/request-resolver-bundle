<?php

namespace CodingCulture\RequestResolverBundle\Request;

use CodingCulture\RequestResolverBundle\Contract\ResolvableRequestInterface;
use CodingCulture\RequestResolverBundle\Resolver\RequestResolver;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GetResourceByIdRequest
 * @package CodingCulture\RequestResolverBundle\Request
 */
class GetResourceByIdRequest implements ResolvableRequestInterface
{
    /**
     * @var array
     */
    private $options = [];

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