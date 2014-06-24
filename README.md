# fabiang/cludearg

Normalizer library for command line arguments for in- or exclude paths and files

[![Build Status](https://travis-ci.org/fabiang/cludearg.svg)](https://travis-ci.org/fabiang/cludearg) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fabiang/cludearg/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fabiang/cludearg/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/fabiang/cludearg/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fabiang/cludearg/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/26a4f51e-3531-4d96-8396-c39da3c18a21/mini.png)](https://insight.sensiolabs.com/projects/26a4f51e-3531-4d96-8396-c39da3c18a21) [![Dependency Status](https://gemnasium.com/fabiang/cludearg.svg)](https://gemnasium.com/fabiang/cludearg) [![Latest Stable Version](https://poser.pugx.org/fabiang/cludearg/v/stable.svg)](https://packagist.org/packages/fabiang/cludearg) [![License](https://poser.pugx.org/fabiang/cludearg/license.svg)](https://packagist.org/packages/fabiang/cludearg)

When running code checks against your code (manually or automatically via continues integration) you'll
have to define paths/files that should (includes) and paths/files that shouldn't (excludes) be checked by the
various applications.

The problem is that all those tools define the command-line arguments in a different way.
This library instead accepts only a standardized format and can return the application-format for a given application
name and version.

## SUPPORTED APPLICATIONS

- php/lint (php -l)
- squizlabs/php_codesniffer
- phpmd/phpmd
- phpdocumentor/phpdocumentor
- pdepend/pdepend
- sebastian/phpcpd

## INSTALLATION

New to Composer? Read the [introduction](https://getcomposer.org/doc/00-intro.md#introduction).
Add the following to your composer file:

```json
{
    "require": {
        "fabiang/cludearg": "1.0.x-dev as 1.0.0"
    }
}
```

## USAGE

You'll only need one method:
```
Fabiang\Cludearg\Cludearg::getArgument(
    string $application,
    string $version,
    array $include,
    array $exclude,
    string $path
)
```

Example:
```php
use Fabiang\Cludearg\Cludearg;

$cludearg = new Cludearg();

$arguments = $cludearg->getArgument(
    'squizlabs/php_codesniffer',
    '1.0.1',
    array('bin/foo.php', 'src'), // files and folders to be included
    array('vendor', 'tests'), // files and folders to be excluded
    '/myproject' // path where the project can be found
);
```

All paths for in- and exclude must be relative to the given path.
The constructor of `Cludearg` can optionally take an `Definition` object,
which allows you to add your own definition of arguments.

## SYSTEM REQUIREMENTS

- PHP >=5.3
- seld/jsonlint >= 1.1

## LICENSE

BSD-2-Clause. See the [LICENSE](LICENSE.md).

## CONTRIBUTING

Contributing is easy, just make sure the tests are running:

```
./vendor/bin/phpunit -c tests
```

If you change the default definition file check if the json schema validates:

```
./vendor/bin/validate-json definition.json schema/cludearg.json
```

Also Jsonlint may help you to find errors in the definition file:

```
./vendor/bin/jsonlint definition.json
```
