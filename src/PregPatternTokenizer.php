<?php

declare(strict_types=1);

namespace Sfp\AngryRegex;

use function strrpos;
use function substr;

final class PregPatternTokenizer
{
    private function __construct()
    {
    }

    public static function tokenize(string $pattern)
    {
        $delimiter       = substr($pattern, 0, 1);
        $delimiterEndPos = strrpos($pattern, $delimiter);
        $modifier        = substr($pattern, $delimiterEndPos);
        return new PregEntry($delimiter, substr($pattern, 1, $delimiterEndPos - 1), $modifier);
    }
}
