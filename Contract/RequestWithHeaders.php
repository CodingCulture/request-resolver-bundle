<?php

namespace CodingCulture\RequestResolverBundle\Contract;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface HeaderableRequestInterface
 * @package App\CodingCulture\RequestResolverBundle\Contract
 */
interface RequestWithHeadersInterface
{
    /**
     * Should configure the passed OptionsResolver to match the expectations in structure and type of the
     * request.
     *
     * @param OptionsResolver $resolver
     *
     * @return OptionsResolver
     */
    public function defineHeaderOptions(OptionsResolver $resolver): OptionsResolver;

    /**
     * Should store the validated request headers for use.
     *
     * @param array $headers
     *
     * @return void
     */
    public function setHeaders(array $headers): void;
}
