<?php

declare(strict_types=1);

namespace SfpTest\AngryRegex;

use PHPUnit\Framework\TestCase;
use Sfp\AngryRegex\PregPatternTokenizer;

use function sprintf;

class PregPatternTokenizerTest extends TestCase
{
    /** @test */
    public function tokenizeShouldGetRegex()
    {
        $regex        = '[0-9a-z]+';
        $patternEntry = PregPatternTokenizer::tokenize(sprintf('/%s/mi', $regex));
        $this->assertSame($regex, $patternEntry->getRegex());
    }
}
