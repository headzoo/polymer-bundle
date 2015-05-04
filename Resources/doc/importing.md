# Importing Components
Elements are typically imported using the `<link rel="import" href="...">` tag, but
you can also use the `{% polymer import %}` tag. The Twig tag generates `<link>` tags,
but is more beneficial than using a `<link>` tag directory. This document covers
those benefits.

## Syntax:
```html
{% polymer import <asset name> [<asset name>...] %}
```

#### Example 1:
```html
{% polymer import "@AcmeBundle:hello-world/hello-world.html.twig" %}
{% polymer import "paper-elements/paper-elements.html" %}
```

The asset directory name may be omitted when the file name (minus the `.html`) and
directory name are the same. The above statement could also be written like this. This
is the preferred format, and the format used through most of the documentation.

```html
{% polymer import "@AcmeBundle:hello-world.html.twig" %}
{% polymer import "paper-elements.html" %}
```

#### Example 2:
You can import multiple assets using a single `{% polymer import %}` tag.

```html
{% polymer import "@AcmeBundle:hello-world.html.twig" "@PolymerBundle:menu-toolbar.html.twig" %}
{% polymer import "core-ajax.html" "core-animation.html" %}
{% polymer import
	"@PolymerBundle:menu-item.html.twig"
	"core-image.html"
	"core-menu.html"
	"core-pages.html"
	"core-toolbar.html"
%}
```

## Core Components
Core Polymer components -- such as those installed using Bower -- are expected to
be saved in the directory `www/bower_components/`. This location may be changed
using the [polymer.paths.components](configuration.md#pathscomponents) setting.

#### Example:
```html
{% polymer import "paper-elements.html" %}
{% polymer import "core-ajax.html" "core-animation.html" %}
```

Generates these `<link>` tags:

```html
<link rel="import" href="/bower_components/paper-elements/paper-elements.html">
<link rel="import" href="/bower_components/core-ajax/core-ajax.html">
<link rel="import" href="/bower_components/core-animation/core-animation.html">
```

## Custom Components
You can write custom elements for your bundle and import them using the
`@BundleName:path-to-element.html` syntax. The location may be changed using the
[polymer.paths.elements](configuration.md#pathselements) setting. See the
documentation on [custom elements](custom.md) for more information on creating your own
elements.

The following examples use the fictitious bundle `AcmeBundle`, which is saved with
the other bundles in the Symfony `src/` directory. For example `src/Acme/Bundle/AcmeBundle`.
The asset name `@AcmeBundle:hello-world/hello-world.html.twig` is expected to be
found in the directory `AcmeBundle/Resources/public/elements/hello-world/hello-world.html`.

#### Example:
```html
{% polymer import "@AcmeBundle:hello-world/hello-world.html.twig" %}
```

Just like other import statements the directory name may be omitted when it matches
the file name.

```html
{% polymer import "@AcmeBundle:hello-world.html.twig" %}
```

#### Resolving Paths
*How* the path to your custom elements gets resolved to a URL depends on the
[polymer.debug](configuration.md#debug) setting. When debugging is turned on
the `Headzoo\Bundle\PolymerBundle\Controller` controller is used to output the
element HTML.

For example this import tag:

```html
{% polymer import "@AcmeBundle:hello-world.html.twig" %}
```

Will generate this `<link>` tag:

```html
<link rel="import" href="/_polymer/import?bundle=AcmeBundle&element=hello-world%2Fhello-world.html.twig">
```

When debugging is off you must install your custom elements using the
[assets:install](http://symfony.com/blog/new-in-symfony-2-6-smarter-assets-install-command)
command after making changes. See the documentation on [deploying your app](deploy.md)
for more information.

For example this import tag:

```html
{% polymer import "@AcmeBundle:hello-world.html.twig" %}
```

Will generate this `<link>` tag:

```html
<link rel="import" href="/bundles/acme/elements/hello-world/hello-world.html">
```

_Note: The ".html.twig" extension is changed to ".html" in the link href attribute._


## Other Elements
Sometimes you may need to import an element a full URL or relative path. You can do
that by starting the asset name with a `/` character, or `http://`, or `https://`.

#### Example:
```html
{% polymer import "/some-element/some-element.html" %}
{% polymer import "http://example.com/some-element/some-element.html" %}
```

Generates these `<link>` tags:

```html
<link rel="import" href="/some-element/some-element.html">
<link rel="import" href="http://example.com/some-element/some-element.html">
```

Note that Polyphonic does not modify the asset name in any way.
