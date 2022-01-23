
# A beautiful error page for Symfony apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/symfony-ignition-bundle.svg?style=flat-square)](https://packagist.org/packages/spatie/symfony-ignition-bundle)
[![Tests](https://github.com/spatie/symfony-ignition-bundle/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/spatie/symfony-ignition-bundle/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/symfony-ignition-bundle.svg?style=flat-square)](https://packagist.org/packages/spatie/symfony-ignition-bundle)

Use [Ignition](https://github.com/spatie/ignition) to render beautiful exceptions in Symfony.

## Installation

You can install the package via composer:

```bash
composer require --dev spatie/symfony-ignition-bundle
```

Enable the bundle in `config/bundles.php`:
```diff
 return [
     // ...
+    Spatie\SymfonyIgnitionBundle\IgnitionBundle::class => ['all' => true],
 ];

```

## Configuration

Use `bin/console debug:config ignition` to see configuration options.

`config/packages/ignition.yaml`:
```
ignition:
    application_path: ''
    dark_mode: false
    should_display_exceptions: '%kernel.debug%'
```

## Example

```php
class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        throw new \Exception('Hello Ignition!');
    }
}
```

<img src="https://github.com/amacrobert/symfony-ignition-bundle/blob/main/doc/img/example.png" />

## Testing

```bash
composer test
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/symfony-ignition-bundle.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/symfony-ignition-bundle)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andrew MacRobert](https://github.com/amacrobert)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
