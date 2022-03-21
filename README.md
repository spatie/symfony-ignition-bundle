
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)


# A beautiful error page for Symfony apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/symfony-ignition-bundle.svg?style=flat-square)](https://packagist.org/packages/spatie/symfony-ignition-bundle)
[![Tests](https://github.com/spatie/symfony-ignition-bundle/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/spatie/symfony-ignition-bundle/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/symfony-ignition-bundle.svg?style=flat-square)](https://packagist.org/packages/spatie/symfony-ignition-bundle)

[Ignition](https://github.com/spatie/ignition) is a beautiful and customizable error page for
PHP applications

Using this bundle, you can replace Symfony's default exception pages with Ignition.

This is what how the Ignition looks like in the browser.

![Screenshot of ignition](https://spatie.github.io/ignition/ignition.png)

There's also a beautiful dark mode.

![Screenshot of ignition in dark mode](https://spatie.github.io/ignition/ignition-dark.png)

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/symfony-ignition-bundle.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/symfony-ignition-bundle)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require --dev spatie/symfony-ignition-bundle
```

Enable the bundle in `config/bundles.php`:
```diff
 return [
     // ...
+    Spatie\SymfonyIgnitionBundle\IgnitionBundle::class => ['dev' => true],
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

## Usage

When you now throw an exception anywhere in your app...

```php
class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        throw new Exception('Hello Ignition!');
    }
}
```

... you'll see a beautiful error page.

![screenshot](https://spatie.github.io/symfony-ignition-bundle/images/ignition.png)

To learn all the options that Ignition provides, including error reporting to [Flare](https://flareapp.io), head over to [the readme of spatie/ignition](https://github.com/spatie/ignition#usage).

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andrew MacRobert](https://github.com/amacrobert)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
