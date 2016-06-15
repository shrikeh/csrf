<?php

namespace spec\Shrikeh\Csrf;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use DateTimeInterface;
use DateTimeImmutable;

class PayloadSpec extends ObjectBehavior
{
    function it_timestamps_a_message()
    {
        $msg = openssl_random_pseudo_bytes(32);
        $this->beConstructedWith($msg);
        $this->created()->shouldBeInThePast();
    }

    public function getMatchers()
    {
        return array(
            'beInThePast' => function(DateTimeInterface $created) {
                $now = new DateTimeImmutable();
                return ($created <= $now);
            }
        );
    }

}
