<?php

namespace spec\Pdf\Color;

use Pdf\Color\CmykColor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CmykColorSpec extends ObjectBehavior
{
    function it_creates_cmyk_colors()
    {
        $this->beConstructedWith(30, 21, 10, 44);
        $this->toArray()->shouldReturn(['cmyk', 0.3, 0.21, 0.1, 0.44]);
    }

    function it_can_be_converted_to_a_string()
    {
        $this->beConstructedWith(30, 21, 10, 44);
        $this->__toString()->shouldReturn('{cmyk 0.3 0.21 0.1 0.44}');
    }
}
