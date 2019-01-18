<?php

namespace CodingCulture\RequestResolverBundle\Contract;

/**
 * Interface ValidatableRequestInterface
 * @package App\CodingCulture\RequestResolverBundle\Contract
 */
interface ValidatableRequestInterface
{
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