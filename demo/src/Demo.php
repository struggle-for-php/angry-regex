<?php

namespace SfpDemo\AngryRegex;

class Demo extends Base
{
    private const ALLOW_PATTERN = '/^[a-zA-Z0-9]+$/';

//    public function validateAlpha(string $word)
//    {
//        $regex = '^[a-zA-Z]+$';
//        return preg_match("/{$regex}/", $word) > 0;
//    }

    public function validateAlphaNum(string $word)
    {
        return preg_match(static::BASE_RULE, $word) > 0;
    }
}