<?php

namespace spec\CodingCulture\RequestResolverBundle\Request;

use CodingCulture\RequestResolverBundle\Contract\ResolvableRequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestRequest implements ResolvableRequestInterface
{
    public function defineOptions(OptionsResolver $resolver): OptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver
            ->addAllowedTypes('id', ['string', 'int'])
            ->addAllowedValues('id', [1, 2, 3, 4, 5])
            ->setRequired('id')
        ;

        $resolver
            ->setDefault('other_param', null)
        ;

        return $resolver;
    }

    public function setOptions(array $options): void
    {
        // TODO: Implement setOptions() method.
    }

    public function getContentType(): string
    {
        // TODO: Implement getContentType() method.
    }
}
