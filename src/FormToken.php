<?php

namespace Shrikeh\Csrf;

interface FormToken
{
    public function __toString();

    public function token();
}
