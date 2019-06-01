<?php

declare(strict_types=1);

namespace Sfp\AngryRegex;

use Nette\Utils\RegexpException;
use Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\StaticType;
use PHPStan\Type\TypeUtils;

use function in_array;
use function sprintf;
use function strtolower;
use function substr;

/**
 * a part of this code is borrowed from PHPStan's RegularExpressionPatternRule
 * https://github.com/phpstan/phpstan/blob/0.11.8/src/Rules/Regexp/RegularExpressionPatternRule.php
 * @license MIT
 */
final class AngryRegularExpressionPatternRule implements Rule
{
    public function getNodeType() : string
    {
        return FuncCall::class;
    }

    /**
     * @param FuncCall $node
     * @param Scope    $scope
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope) : array
    {
        $patterns = $this->extractPatterns($node, $scope);
        $errors   = [];
        foreach ($patterns as $pattern) {
            $errorMessage = $this->validatePattern($pattern);
            if ($errorMessage === null) {
                continue;
            }
            $errors[] = sprintf('Regex pattern is invalid: %s', $errorMessage);
        }
        return $errors;
    }

    /**
     * @param FuncCall $functionCall
     * @param Scope    $scope
     * @return string[]
     */
    private function extractPatterns(FuncCall $functionCall, Scope $scope) : array
    {
        if (! $functionCall->name instanceof Node\Name) {
            return [];
        }
        $functionName = strtolower((string) $functionCall->name);
        if (! Strings::startsWith($functionName, 'preg_')) {
            return [];
        }
        if (! isset($functionCall->args[0])) {
            return [];
        }
        $patternNode = $functionCall->args[0]->value;
        $patternType = $scope->getType($patternNode);

        $patternStrings = [];
        if ($patternNode instanceof Node\Expr\ClassConstFetch) {
            $patternStrings += $this->extractClassConst($patternNode, $scope);
        }

        $stringArgParameterPregFunctions = [
            'preg_match',
            'preg_match_all',
            'preg_split',
            'preg_grep',
            'preg_replace',
            'preg_replace_callback',
            'preg_filter',
        ];

        foreach (TypeUtils::getConstantStrings($patternType) as $constantStringType) {
            if (! in_array($functionName, $stringArgParameterPregFunctions, true)) {
                continue;
            }
            $patternStrings[] = $constantStringType->getValue();
        }

        $arrayArgParamterPregFunctions = [
            'preg_replace',
            'preg_replace_callback',
            'preg_filter',
        ];

        foreach (TypeUtils::getConstantArrays($patternType) as $constantArrayType) {
            if (in_array($functionName, $arrayArgParamterPregFunctions, true)) {
                foreach ($constantArrayType->getValueTypes() as $arrayKeyType) {
                    if (! $arrayKeyType instanceof ConstantStringType) {
                        continue;
                    }
                    $patternStrings[] = $arrayKeyType->getValue();
                }
            }
            if ($functionName !== 'preg_replace_callback_array') {
                continue;
            }
            foreach ($constantArrayType->getKeyTypes() as $arrayKeyType) {
                if (! $arrayKeyType instanceof ConstantStringType) {
                    continue;
                }
                $patternStrings[] = $arrayKeyType->getValue();
            }
        }
        return $patternStrings;
    }

    private function extractClassConst(Node\Expr\ClassConstFetch $classConst, Scope $scope) : array
    {
        $className = $scope->resolveName($classConst->class);

        $classType          = new StaticType($className);
        $constantReflection = $classType->getConstant($classConst->name->name);

        return (array) $constantReflection->getValue();
    }

    private function validatePattern(string $pattern) : ?string
    {
        try {
            Strings::match('', $pattern);
            $pregEntry = PregPatternTokenizer::tokenize($pattern);
            if ($this->regexHasUnfavorableMetaChar($pregEntry->getRegex())) {
                return sprintf('Unfavorable `^` or `$` %s', $pattern);
            }
        } catch (RegexpException $e) {
            return $e->getMessage();
        }
        return null;
    }

    private function regexHasUnfavorableMetaChar(string $regex) : bool
    {
        return substr($regex, 0, 1) === '^' ? substr($regex, -1, 1) === '$' : false;
    }
}
