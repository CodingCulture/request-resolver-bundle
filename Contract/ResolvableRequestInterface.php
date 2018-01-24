<?php

namespace CodingCulture\RequestResolverBundle\Contract;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface ResolvableRequestInterface
 * @package App\CodingCulture\RequestResolverBundle\Contract
 */
interface ResolvableRequestInterface
{
    /**
     * Should configure the passed OptionsResolver to match the expectations in structure and type of the
     * request.
     *
     * @param OptionsResolver $resolver
     *
     * @return OptionsResolver
     */
    public function defineOptions(OptionsResolver $resolver): OptionsResolver;

    /**
     * Should store the validated request options for use.
     *
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options): void;

    /**
     * Should define the Content-Type header the request should have.
     *
     * @return string
     */
    public function getContentType(): string;
}
