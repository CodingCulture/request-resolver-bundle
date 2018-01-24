<?php

namespace spec\CodingCulture\RequestResolverBundle\Resolver;

use CodingCulture\RequestResolverBundle\Request\GetResourceByIdRequest;
use CodingCulture\RequestResolverBundle\Resolver\RequestResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestResolverSpec extends ObjectBehavior
{
    function it_is_initializable(RequestStack $requestStack)
    {
        $this->beConstructedWith($requestStack);

        $this->shouldHaveType(RequestResolver::class);
    }

    function it_should_resolve_a_request(RequestStack $requestStack)
    {
        $requestStack->getCurrentRequest()->willReturn(
            new Request(
                ['id' => 5],
                [],
                ['_route_params' => ['id' => 60]],
                [],
                []
            )
        );

        $this->beConstructedWith($requestStack);

        /** @var GetResourceByIdRequest $request */
        $request = $this->resolve(new GetResourceByIdRequest());

        $request->getId()->shouldReturn("60");
    }

    function it_should_throw_an_exception(RequestStack $requestStack)
    {
        $requestStack->getCurrentRequest()->willReturn(new Request());

        $this->beConstructedWith($requestStack);

        /** @var GetResourceByIdRequest $request */
        $request = $this
            ->shouldThrow('InvalidArgumentException')
            ->duringResolve(new GetResourceByIdRequest())
        ;
    }

    function it_should_throw_an_exception_when_headers_arent_respected(
        Request $request,
        ParameterBag $bag,
        RequestStack $requestStack,
        GetResourceByIdRequest $jsonRequest,
        OptionsResolver $optionsResolver
    ) {
        $bag->get('Content-Type', RequestResolver::CONTENT_TYPE_FORM_DATA);
        $request->headers = $bag;

        $requestStack->getCurrentRequest()->willReturn($request);

        $this->beConstructedWith($requestStack);

        $jsonRequest->defineOptions(Argument::type(OptionsResolver::class))->willReturn($optionsResolver);

        $jsonRequest->getContentType()->willReturn(RequestResolver::CONTENT_TYPE_JSON);

        $this->shouldThrow('Symfony\Component\HttpKernel\Exception\HttpException')->duringResolve($jsonRequest);
    }
}
