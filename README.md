# Policy

Using Laravel's authorization on the front-end.

A nice tool for SPAs and front-end heavy applications.

If you want to see behind the package, we suggest to read this post:
[Implementing Laravel’s Authorization on the Front-End](https://pineco.de/implementing-laravels-authorization-front-end/).

### Table of contents

1. [Getting Started](#getting-started)
2. [Publishing and setting up the JavaScript library](#publishing-and-setting-up-the-javascript-library)
   - [Setting up the Gate.js](#setting-up-the-gatejs)
   - [Initializing a gate instance](#initializing-a-gate-instance)
   - [Passing the user to the gate instance](#passing-the-user-to-the-gate-instance)
   - [Using it as a Vue service](#using-it-as-a-vue-service)
   - [The @currentUser blade directive](#the-currentuser-blade-directive)
3. [Using the policies and the Gate.js](#using-the-policies-and-the-gatejs)
   - [The available methods](#the-available-methods)
   - [Adding the UsesModelName trait to the models](#adding-the-usesmodelname-trait-to-the-models)
   - [Generating policies with artisan](#generating-policies-with-artisan)
   - [Writing the policy rules](#writing-the-policy-rules)
4. [Example](#example)
5. [Contribute](#contribute)

## Getting started

You can install the package with composer, running the `composer require thepinecode/policy` command.

Since the package supports autodiscovery, Laravel will register the service provider automatically behind the scenes.

In some cases you may disable autodiscovery for this package.
You can add the provider class to the `dont-discover` array to disable it.
Then you need to register it manually again.

## Publishing and setting up the JavaScript library

By default the package provides a `Gate.js` file, that will handle the policies.
Use the `php artisan vendor:publish` command and choose the `Pine\Policy\PolicyServiceProvider` provider.
After publishing you can find your fresh copy in the `resources/js/policies` folder.

### Setting up the Gate.js

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

> Note, you can pass any object as a *user*.
> If you pass a team or a group object, it works as well. Since you define the logic behind the `Gate`,
> you can pass anything you wish.

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

## Using the policies and the Gate.js

### The available methods

#### allow()

The `allow()` accepts two parameter. The first is the action to perform,
the second is the **model object** or the **model type**, like in Laravel.

```js
gate.allow('view', model);

gate.allow('create', 'comment');
```

#### deny()

The `deny()` has the same signature like `allow()` but it will negate its return value.

```js
gate.deny('view', model);

gate.deny('create', 'comment');
```

#### before()

Like in Laravel, in the `before()` method you can provide a custom logic to pass special conditions.
If the condition passes, the rest of the checks in the `allow()` or `deny()` won't run at all.
However if the condition fails, the policy rules will get place.
To use the `before()` method, you may extend the gate object and define your custom logic.

```js
Gate.prototype.before = function () {
    return this.user.is_admin;
}
```

> Please note, to use the `this` object correctly,
> **use the traditional function signature instead of the arrow (() => {}) functions**.

### Adding the `UsesModelName` trait to the models

Since, the policies will use real JSON shaped eloquent models, the models have to use the  `Pine\Policy\UsesModelName`
trait that generates the proper model name, that will be used for identification by the `Gate.js`.

```php
use Pine\Policy\UsesModelName;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UsesModelName;

    protected $appends = ['model_name'];
}
```

> Please note, to be able to use this attribute on the front-end, the model attribute has to be appended to the JSON form.
> You can read more about appending values to JSON in the
> [docs](https://laravel.com/docs/master/eloquent-serialization#appending-values-to-json).

### Generating policies with artisan

The package comes an artisan command by default, that helps you to generate your front-end policies easily.
To make a policy, run the `php artisan make:js-policy Model` command, where the `Model` is the model's name.

```sh
php artisan make:js-policy Comment
```

This command will create the `CommentPolicy.js` file next to the `Gate.js` in the `resources/js/policies` directory.

> Note, the command will append the `Policy` automatically in the file name.
> It means you may pass only the model name when running the command.

After you generated the policy files, run `npm` to compile all the policies.

***

#### Important!

**The policies are registered automatically**. It means, no need for importing them manually.
The gate instance will **automatically** populate the policies.
Every policy will be used where it matches with the model's `model_name` attribute.

Based on
[Laravel's default app.js](https://github.com/laravel/laravel/blob/master/resources/js/app.js#L19-L20)
the Gate instance
[registers the policies automatically](https://github.com/thepinecode/policy/blob/master/resources/js/Gate.js#L14-L18)
when calling `npm run dev`, `npm run prod` and so on.

***

### Writing the policy rules

Policies – like in Laravel – have the following methods by default:
`viewAny`, `view`, `create`, `update`, `restore`, `delete` and `forceDelete`.
Of course, they can be removed or new methods can be added to the policy.

```js
...

view(user, model)
{
    return user.id == model.user_id;
}

create(user)
{
    return user.is_admin;
}

...
```

## Example

```js
// app.js
Vue.prototype.$Gate = new Gate;

Vue.component('posts', {
    mounted() {
        axios.get('/api/posts')
            .then(response => this.posts = response.data);
    },
    data() {
        return {
            posts: [],
        };
    },
    template: `
        <ul><li v-for="post in posts" v-if="$Gate.allow('update', post)"></li></ul>
        <button v-if="$Gate.allow('create', 'post')">Create post</button>
    `
});

let app = new Vue({
    //
})
```

```html
<body>
    <posts></posts>

    @currentUser
    <scirpt src="{{ asset('js/app.js') }}"></script>
</body>
```


## Contribute

If you found a bug or you have an idea connecting the package, feel free to open an issue.
