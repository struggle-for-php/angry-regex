<?php declare(strict_types = 1);

namespace Sfp\AngryRegex;

final class PregPatternTokenizer
{
    private function __construct()
    {}

    public static function tokenize(string $pattern)
    {
        $delimiter = substr($pattern, 0, 1);
        $delimiter_end_pos = strrpos($pattern, $delimiter);
        $modifier = substr($pattern, $delimiter_end_pos);
        return new PregEntry($delimiter, substr($pattern, 1, $delimiter_end_pos - 1), $modifier);
    }
}