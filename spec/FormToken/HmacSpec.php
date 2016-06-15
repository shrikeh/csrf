<?php

namespace spec\Shrikeh\Csrf\FormToken;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Shrikeh\Csrf\FormToken\Hmac;
use Shrikeh\Csrf\FormToken\Hmac\KeySecret;

class HmacSpec extends ObjectBehavior
{
    function let(KeySecret $ks)
    {
        $key = openssl_random_pseudo_bytes(32);
        $secret = openssl_random_pseudo_bytes(32);
        $ks->key()->willReturn($key);
        $ks->secret()->willReturn($secret);
    }

    function it_returns_a_hash($ks)
    {
        $algo = Hmac::DEFAULT_ALGO;
        $this->beConstructedThroughWithSecret($ks);
        $this->token()->shouldBeAValidHash($algo, $ks);
    }

    function it_returns_a_token_when_used_as_a_string($ks)
    {
        $key = openssl_random_pseudo_bytes(32);
        $secret = openssl_random_pseudo_bytes(32);
        $algo = Hmac::DEFAULT_ALGO;
        $this->beConstructedThroughWithSecret($ks);
        $this->__toString()->shouldBeAValidHash($algo, $ks);
    }

    function it_uses_a_configurable_hash($ks)
    {
        $algo = Hmac::RIPEMD320;
        $this->beConstructedThroughWithAlgorithm($ks, $algo);
        $this->__toString()->shouldBeAValidHash($algo, $ks);
    }

    // function it_throws_an_exception_if_using_an_insecure_hash()
    // {
    //   $key = openssl_random_pseudo_bytes(32);
    //   $secret = openssl_random_pseudo_bytes(32);
    //   $algo = 'sha1';
    //   $this->beConstructedWith($key, $secret, $algo);
    //   $this->__toString()->shouldBeAValidHash($algo, $key, $secret);
    // }

    public function getMatchers()
    {
        return array(
            'beAValidHash' => function($token, $algo, $ks) {
                $hmac = hash_hmac($algo, $ks->key(), $ks->secret());
                return hash_equals($hmac, $token);
            },
        );
    }
}
