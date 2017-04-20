<?php

namespace spec\Pdf\Color;

use Pdf\Color\LabColor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LabColorSpec extends ObjectBehavior
{
    function it_creates_lab_colors()
    {
        $this->beConstructedWith(100, -50, 50);
        $this->__toString()->shouldReturn('{ lab 100 -50 50 }');
    }
}
