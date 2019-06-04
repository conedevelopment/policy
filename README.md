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

### Using the Gate.js

Then you can import the `Gate` class and assign it to the `window` object.

```js
import Gate from './policies/Gate';
window.Gate = Gate;
```

### Initializing a gate instance

From this point you can initialize the translation service anywhere from your application.

```js
let gate = new Gate;
```

### Passing the user to the gate instance

The `Gate` object requires a passed user to work properly. This can be a `string` or an `object`.
By default, it looks for the `window.user` object, however you may customize the key or the object itself.

```js
let gate = new Gate; // window.user

let gate = new Gate('admin'); // window.admin

let gate = new Gate({ ... }); // uses the custom object
```

### Using it as a Vue service

If you want to use it from Vue templates directly you can extend Vue with this easily.

```js
Vue.prototype.$Gate = new Gate;
```
```html
<template>
    <div v-if="$Gate.allow('view', model)">...</div>
</template>
```

```js
computed: {
    hasPermission: {
        return this.$Gate.allow('view', this.model);
    }
}
```

### The @currentUser blade directive

To make it quicker, the package comes with a `@currentUser` blade directive.
This does nothing more, but to print the currently authenticated user as `JSON` and assing it to the `window` object.

```html
@currentUser

<!-- Result -->
<script>window.user = { ... };</script>
```

You may override the default key for the user. You can do that by passing a string to the blade directive.

```html
@currentUser ('admin')

<!-- Result -->
<script>window.admin = { ... };</script>
```

> If there is no authenticated user, the value will be `null`.

