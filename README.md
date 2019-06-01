struggle-for-php/angry-regex
============================

PHPStan Rule to detect Unfavorable Regex.

and add more checking than PHPStan's Regex check.

## Based on Tokumaru's statement
 - `正規表現によるバリデーションでは ^ と $ ではなく \A と \z を使おう`
    - https://blog.tokumaru.org/2014/03/z.html
    
## Example
```sh
$ ../vendor/bin/phpstan analyse --level=1 src/
Note: Using configuration file /tmp/angry-regex/demo/phpstan.neon.
 2/2 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 ------ -------------------------------------------------------------
  Line   Demo.php
 ------ -------------------------------------------------------------
  17     Regex pattern is invalid: Unfavorable `^` or `$` /^[0-9]+$/
 ------ -------------------------------------------------------------


 [ERROR] Found 1 error
```


## Installation

```sh
composer require --dev struggle-for-php/angry-regex
```

## Configuration

In your `phpstan.neon` configuration, add following section:

```neon
includes:
	- vendor/struggle-for-php/angry-regex/rules.neon
```

## Also see.
　- Validator\Ip should not allow newlines in any case.
    - https://github.com/zendframework/zendframework/pull/6104
