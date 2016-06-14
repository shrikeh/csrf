<?php

namespace spec\Shrikeh\Csrf\FormToken;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Shrikeh\Csrf\FormToken\Hmac;

class HmacSpec extends ObjectBehavior
{

    function it_returns_a_hash()
    {
        $key = openssl_random_pseudo_bytes(32);
        $secret = openssl_random_pseudo_bytes(32);
        $algo = Hmac::RIPEMD160;
        $this->beConstructedWith($key, $secret, $algo);
        $this->token()->shouldBeAValidHash($algo, $key, $secret);
    }

    function it_returns_a_token_when_used_as_a_string()
    {
      $key = openssl_random_pseudo_bytes(32);
      $secret = openssl_random_pseudo_bytes(32);
      $algo = Hmac::RIPEMD320;
      $this->beConstructedWith($key, $secret, $algo);
      $this->__toString()->shouldBeAValidHash($algo, $key, $secret);
    }

    function it_uses_a_configurable_hash()
    {
        $key = openssl_random_pseudo_bytes(32);
        $secret = openssl_random_pseudo_bytes(32);
        $algo = Hmac::RIPEMD320;
        $this->beConstructedWith($key, $secret, $algo);
        $this->__toString()->shouldBeAValidHash($algo, $key, $secret);
    }

    public function getMatchers()
    {
        return array(
            'beAValidHash' => function($token, $algo, $key, $secret) {
                $hmac = hash_hmac($algo, $key, $secret);
                return hash_equals($hmac, $token);
            },
        );
    }
}
