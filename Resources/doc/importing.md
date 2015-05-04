# Importing
Elements are typically imported using the `<link rel="import" href="...">` tag, but
you can also use the `{% polymer import %}` tag. The Twig tag generates `<link>` tags,
but is more beneficial than using a `<link>` tag directory. This document covers
those benefits.

### Syntax:
```html
{% polymer import <asset name> [<asset name>...] %}
```

##### Example 1:
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

##### Example 2:
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

### Core Components
Core Polymer components -- such as those installed using Bower -- are expected to
be saved in the directory `www/bower_components/`. This location may be changed
using the [polymer.paths.components](doc/configuration.md#pathscomponents) setting.

##### Example:
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

### Custom Components
You can write custom elements for your bundle and import them using the
`@BundleName:path-to-element.html` syntax. The location may be changed using the
[polymer.paths.elements](doc/configuration.md#pathselements) setting. See the
documentation on [custom elements](doc/custom.md) for more information on creating your own
elements.

The following examples use the fictitious bundle `AcmeBundle`, which is saved with
the other bundles in the Symfony `src/` directory. For example `src/Acme/Bundle/AcmeBundle`.
The asset name `@AcmeBundle:hello-world/hello-world.html.twig` is expected to be
found in the directory `AcmeBundle/Resources/public/elements/hello-world/hello-world.html`.

##### Example:
```html
{% polymer import "@AcmeBundle:hello-world/hello-world.html.twig" %}
```

Just like other import statements the directory name may be omitted when it matches
the file name.

```html
{% polymer import "@AcmeBundle:hello-world.html.twig" %}
```

