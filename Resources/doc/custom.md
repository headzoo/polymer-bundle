# Creating Elements
This document covers creating your custom components using Polymer and Twig.
The Polyphonic Polymer Bundle primarily acts as a compatibility layer between
Polymer and the Twig template engine, and the goal of this document is to cover
those differences. It does not attempt to fully cover creating web components
with Polymer. The [Polymer Project documentation](https://www.polymer-project.org)
covers those details in great detail.

Before you start make sure you have installed Polymer.
[Installing Polymer](https://www.polymer-project.org/0.5/docs/start/getting-the-code.html)
This document assumes you have used [Bower](http://bower.io/) to install Polymer to the
`web/bower_components` directory. By default Polyphonic is configured to look for
components in that directory.

## Hello World
To get started lets look at how we would create a simple `<hello-world>` element
outside of a Symfony project using plain HTML5 and JavaScript. 

```html
<link rel="import" href="/bower_components/polymer/polymer.html">

<polymer-element name="hello-world" attributes="name">
	<template>
		<p>Hello, {{name}}!</p>
	</template>
	<script>
		Polymer({
			name: "World"
		});
	</script>
</polymer-element>
```

You can now use the element by importing it.

```html
<link rel="import" href="hello-world/hello-world.html">

<!-- Displays "Hello, World!" -->
<hello-world></hello-world>

<!-- Displays "Hello, Pascal!" -->
<hello-world name="Pascal"></hello-world>
```

As you can see creating custom web components with Polymer is easy, but as Symfony/Twig
developers we run into a problem with this line of code:

```html
<p>Hello, {{name}}!</p>
```

Both Polymer and Twig use the `{{double mustache}}` syntax for variables. Symfony/Twig
would throw a `Twig_Error_Runtime` exception if you tried to use this code in
your templates.

```
Variable "name" does not exist in AcmeBundle:Default:index.html.twig at line 7
500 Internal Server Error - Twig_Error_Runtime
```

The Polyphonic Polymer Bundle exists to get around this problem. The bundle also
includes a few other features that make creating and using components easier
within a Symfony project. Lets rewrite our component using the bundle syntax.
This lesson assumes you already have a Symfony bundle generated for your
application. The bundle name **AcmeBundle** will be used.

Start by creating a file for your component inside your bundle directory.
Polyphonic expects your component templates to be saved in the bundle's
`Resources/public/elements` directory along with your bundles other assets.
Create the file `AcmeBundle/Resources/public/elements/hello-world/hello-world.html`,
and add the following code.

```html
{% polymer element "hello-world" attributes="names" %}
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

Now you can use the element in your templates with the following code:

```html
{% polymer import "@AcmeBundle:hello-world/hello-world.html" %}

<!-- Displays "Hello, World!" -->
<hello-world></hello-world>

<!-- Displays "Hello, Pascal!" -->
<hello-world name="Pascal"></hello-world>
```
