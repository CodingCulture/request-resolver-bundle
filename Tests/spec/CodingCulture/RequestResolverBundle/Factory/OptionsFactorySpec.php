<?php

namespace spec\CodingCulture\RequestResolverBundle\Factory;

use CodingCulture\RequestResolverBundle\Factory\OptionsFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

class OptionsFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OptionsFactory::class);
    }

    function it_can_create_form_data_options_with_important_order()
    {
        $request = new Request();

        $request->query->set('id', 1);
        $request->attributes->set('_route_params', ['id' => 14]);
        $request->request->set('id', 50);

        $this::createFromFormData($request)->shouldReturn(['id' => 14]);
    }

    function it_can_create_json_options_with_important_order()
    {
        $request = new Request(
            ['id' => 50],
            [],
            ['_route_params' => ['id' => 15]],
            [],
            [],
            [],
            json_encode(['id' => 20, 'other_param' => 5])
        );

        $this::createFromJSON($request)->shouldReturn(['id' => 15, 'other_param' => 5]);
    }
}
