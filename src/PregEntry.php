<?php

declare(strict_types=1);

namespace Sfp\AngryRegex;

class PregEntry
{
    private $delimiter;
    private $regex;
    private $modifier;

    public function __construct(string $delimiter, string $regex, ?string $modifier = null)
    {
        $this->delimiter = $delimiter;
        $this->regex     = $regex;
        $this->modifier  = $modifier;
    }

    public function getDelimiter() : string
    {
        return $this->delimiter;
    }

    public function getRegex() : string
    {
        return $this->regex;
    }

    public function getModifier() : ?string
    {
        return $this->modifier;
    }
}
