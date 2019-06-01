<?php
declare(strict_types=1);

namespace SfpTest\AngryRegex;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Sfp\AngryRegex\AngryRegularExpressionPatternRule;

class AngryRegularExpressionPatternRuleTest extends RuleTestCase
{
    protected function getRule() : Rule
    {
        return new AngryRegularExpressionPatternRule();
    }

    /** @test */
    public function testProcessNode()
    {
        $this->analyse(
            [
                __DIR__ . '/Asset/CustomValidator.php'
            ],
            [
                [
                    "Regex pattern is invalid: Unfavorable `^` or `$` /^[a-zA-Z0-9]+$/",
                    12
                ]
            ]
        );
    }
}
