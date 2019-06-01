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
        $this->regex = $regex;
        $this->modifier;
    }

    public function getRegex() : string
    {
        return $this->regex;
    }
}