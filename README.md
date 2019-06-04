# Policy

Use Laravel's authorization with JavaScript.

A nice tool for SPAs and front-end heavy applications.

If you want to see behind the package, we suggest to read this post:
[Implementing Laravel’s Authorization on the Front-End](https://pineco.de/implementing-laravels-authorization-front-end/).

## Getting started

You can install the package with composer, running the `composer require thepinecode/policy` command.

### Laravel 5.5 and up

If you are using version 5.5 and up, there is nothing else to do.
Since the package supports autodiscovery, Laravel will register the service provider automatically behind the scenes.

#### Disable the autodiscovery for the package

In some cases you may disable autodiscovery for this package.
You can add the provider class to the `dont-discover` array to disable it.

Then you need to register it manually again.

### Laravel 5.4 and below

You have to register the service provider manually.
Go to the `config/app.php` file and add the `Pine\Policy\PolicyServiceProvider::class` to the providers array.

## Publishing and using the JavaScript library

By default the package provides a `Gate.js` file, that will handle the policies.
Use the `php artisan vendor:publish` command and choose the `Pine\Policy\PolicyServiceProvider` provider.
After publishing you can find your fresh copy in the `resources/js/policies` folder.
