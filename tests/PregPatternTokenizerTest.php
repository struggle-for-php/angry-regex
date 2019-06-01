<?php

namespace SfpTest\AngryRegex;

use PHPUnit\Framework\TestCase;
use Sfp\AngryRegex\PregPatternTokenizer;

class PregPatternTokenizerTest extends TestCase
{
    /** @test */
    public function tokenizeShouldGetRegex()
    {
        $regex = '[0-9a-z]+';
        $patternEntry = PregPatternTokenizer::tokenize("/{$regex}/mi");
        $this->assertSame($regex, $patternEntry->getRegex());
    }
}
