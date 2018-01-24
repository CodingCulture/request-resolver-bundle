<?php

namespace spec\CodingCulture\RequestResolverBundle\Helper;

use CodingCulture\RequestResolverBundle\Helper\TypeJuggleHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypeJuggleHelperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TypeJuggleHelper::class);
    }

    function it_handles_a_boolean()
    {
        $this::juggle('true')->shouldReturn(true);
        $this::juggle('false')->shouldReturn(false);
        $this::juggle(true)->shouldReturn(true);
        $this::juggle(false)->shouldReturn(false);
    }

    function it_handles_an_int()
    {
        $this::juggle(1)->shouldReturn(1);
        $this::juggle(0)->shouldReturn(0);
        $this::juggle('13')->shouldReturn((int) 13);
        $this::juggle(13)->shouldReturn((int) 13);
        $this::juggle((float) 1.0)->shouldReturn((int) 1);
    }

    function it_handles_a_float()
    {
        $this::juggle('1.0')->shouldReturn((float) 1.0);
        $this::juggle(23.34)->shouldReturn((float) 23.34);
        $this::juggle('23.34')->shouldReturn((float) 23.34);
    }

    function it_handles_a_string()
    {
        $this::juggle('y')->shouldReturn('y');
        $this::juggle('string')->shouldReturn('string');
        $this::juggle('n')->shouldReturn('n');
    }
}
