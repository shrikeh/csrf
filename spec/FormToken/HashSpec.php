<?php

namespace spec\Shrikeh\Csrf\FormToken;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HashSpec extends ObjectBehavior
{
    function it_generates_a_valid_token()
    {
        $key = openssl_random_pseudo_bytes(32);
        $this->beConstructedThroughFromKey($key);
        $this->token()->shouldBeAValidHash($key);
    }

    function it_returns_a_token_when_used_as_a_string()
    {
        $key = openssl_random_pseudo_bytes(32);
        $this->beConstructedThroughFromKey($key);
        $this->__toString()->shouldBeAValidHash($key);
    }

    function it_is_configurable()
    {
        $key = openssl_random_pseudo_bytes(32);
        $algo = PASSWORD_BCRYPT;
        $options = array(
            'cost' => 12
        );
        $this->beConstructedThroughfromConfig($key, $algo, $options);
        $this->token()->shouldHaveMatchingOptions($options);
        $this->token()->shouldHaveMatchingAlgo($algo);
    }

    public function getMatchers()
    {
        return array(
            'beAValidHash' => function($token, $key) {
                $hash = base64_decode($token);
                return password_verify($key, $hash);
            },
            'haveMatchingOptions' => function($token, $options) {
                $hash = base64_decode($token);
                $hashInfo = password_get_info($hash);
                return $hashInfo['options'] === $options;
            },
            'haveMatchingAlgo' => function($token, $algo) {
                $hash = base64_decode($token);
                $hashInfo = password_get_info($hash);
                return $hashInfo['algo'] === $algo;
            }
        );
    }
}
