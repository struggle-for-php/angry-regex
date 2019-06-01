<?php

declare(strict_types=1);

namespace SfpTest\AngryRegex\Asset;

abstract class AbstractBaseValidator
{
    protected const ALLOW_ALPHA = '/^[a-zA-Z]+$/';

    abstract public function validateAlpha(string $input) : bool;
}
