<?php

namespace Shrikeh\Csrf;

use DateTimeImmutable;

class Payload
{
    private $message;

    private $created;

    public function __construct($msg)
    {
        $this->message = $msg;
        $this->created = new DateTimeImmutable();
    }

    public function created()
    {
        return $this->created;
    }
}
