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

    /**
     * Should validate the request. These validations should contain business logic that aren't possible with the
     * format validation that happens in defineOptions().
     *
     * We suggest using beiberlei/assert.
     *
     * The validation should throw exceptions or return void if all validation is successful.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function validate(): void;
}
