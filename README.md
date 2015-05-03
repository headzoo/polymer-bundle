# Polyphonic Symfony

Symfony framework bundle and Twig extension for using and developing Polymer web components.

[![Build Status](https://img.shields.io/travis/headzoo/polyphonic-symfony/master.svg?style=flat-square)](https://travis-ci.org/headzoo/polyphonic-symfony)
[![MIT License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/headzoo/polyphonic-symfony/master/LICENSE.md)

![Polyphonic Symfony](http://i.imgur.com/DukYX3u.png)


**This bundle is no where near production ready. It's not even dev ready. Use at your own risk.**

The purpose of this bundle is making it easier to use and build Polymer web components within a Symfony project.
Polyphonic handles the problems that come up when trying to build and use web components within Twig templates.

### Example Element
A simple example of using the `{% polymer element %}` Twig tag to create a custom `<hello-world><hello-world>` element.
This element displays "Hello, World!" by default, but the message can be changed by setting the `name` attribute.
Note that there's no need to add `<link rel="import" href="polymer/polymer.html">` as the import statement is added
automatically. The template is saved in the bundle Resources directory at
`Resources/public/elements/hello-world/hello-world.html.twig`.

```html
{% polymer element "hello-world" attributes="name" %}
    <template>
        <p>Hello, {{name}}!</p>
    </template>
    <script>
        Polymer({
            name: "World"
        });
    </script>
{% endpolymer %}
```

Using the element in your views:

```html
{% polymer import "@AcmeBundle:hello-world/hello-world.html.twig" %}

<!-- Displays "Hello, World!" -->
<hello-world></hello-world>

<!-- Displays "Hello, Pascal!" -->
<hello-world name="Pascal"></hello-world>
```

### Installing
Add `headzoo/polyphonic-symfony` to your composer.json requirements.

```javascript
"require": {
    "headzoo/polyphonic-symfony": "0.0.2"
}
```

Run `composer update` and then add the bundle your AppKernel.php.

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            ...
            new Headzoo\Bundle\PolymerBundle\PolymerBundle(),
        )
        
        return $bundles;
    }
}
```
