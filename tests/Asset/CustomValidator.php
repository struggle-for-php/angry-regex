<?php
declare(strict_types=1);

namespace SfpTest\AngryRegex\Asset;

class CustomValidator extends BaseValidator
{
    protected const ALLOW_ALPHA = '/^[a-zA-Z0-9]+$/';

    public function validateAlpha(string $input) : bool
    {
        return preg_match(static::ALLOW_ALPHA, $input) > 0;
    }
}