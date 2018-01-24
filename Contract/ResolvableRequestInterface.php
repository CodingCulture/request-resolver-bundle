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
    public function defineOptions(OptionsResolver $resolver): OptionsResolver;

    public function setOptions(array $options): void;

    public function getContentType(): string;
}