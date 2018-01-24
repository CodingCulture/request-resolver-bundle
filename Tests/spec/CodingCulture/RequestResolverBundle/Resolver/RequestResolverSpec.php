<?php

namespace spec\CodingCulture\RequestResolverBundle\Resolver;

use CodingCulture\RequestResolverBundle\Request\GetResourceByIdRequest;
use CodingCulture\RequestResolverBundle\Resolver\RequestResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\CodingCulture\RequestResolverBundle\Request\TestRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RequestResolver::class);
    }
}
