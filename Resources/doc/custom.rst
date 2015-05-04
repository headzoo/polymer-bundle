Creating Elements
=================

This document covers creating your custom components using Polymer and
Twig. The Polyphonic Polymer Bundle primarily acts as a compatibility
layer between Polymer and the Twig template engine, and the goal of this
document is to cover those differences. It does not attempt to fully
cover creating web components with Polymer. The `Polymer Project
documentation <https://www.polymer-project.org>`__ covers those details
in great detail.

Before you start make sure you have installed Polymer. `Installing
Polymer <https://www.polymer-project.org/0.5/docs/start/getting-the-code.html>`__
This document assumes you have used `Bower <http://bower.io/>`__ to
install Polymer to the ``web/bower_components`` directory. By default
Polyphonic is configured to look for components in that directory.

Hello World
-----------

To get started lets look at how we would create a simple
``<hello-world>`` element outside of a Symfony project using plain HTML5
and JavaScript.

.. sourcecode:: html

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

You can now use the element by importing it.

.. sourcecode:: html

    <link rel="import" href="/some/directory/hello-world/hello-world.html">

    <!-- Displays "Hello, World!" -->
    <hello-world></hello-world>

    <!-- Displays "Hello, Pascal!" -->
    <hello-world name="Pascal"></hello-world>

As you can see creating custom web components with Polymer is easy, but
as Symfony/Twig developers we run into a problem with this line of code:

.. sourcecode:: html

    <p>Hello, {{name}}!</p>

Both Polymer and Twig use the ``{{double mustache}}`` syntax for
variables. Symfony/Twig would throw a ``Twig_Error_Runtime`` exception
if you tried to use this code in your templates.

::

    Variable "name" does not exist in AcmeBundle:Default:index.html.twig at line 7
    500 Internal Server Error - Twig_Error_Runtime

The Polyphonic Polymer Bundle exists to get around this problem. The
bundle also includes a few other features that make creating and using
components easier within a Symfony project. Lets rewrite our component
using the bundle syntax. This lesson assumes you already have a Symfony
bundle generated for your application. The bundle name **AcmeBundle**
will be used.

The Polymer Tag
---------------

Start by creating a file for your component inside your bundle
directory. Polyphonic expects your component templates to be saved in
the bundle's ``Resources/public/elements`` directory along with your
bundles other assets. Create the file
``AcmeBundle/Resources/public/elements/hello-world/hello-world.html``,
and add the following code.

.. sourcecode:: twig

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

Lets look at the differences between creating a component using plain
HTML5/JS and Polyphonic.

With the Polyphonic you do not explicity import polymer.html with a
``<link>`` tag. It's done for you automatically.

.. sourcecode:: html

    <link rel="import" href="/bower_components/polymer/polymer.html">

Next, instead of wrapping your component code in the following tag:

.. sourcecode:: html

    <polymer-element name="hello-world" attributes="name"></polymer-element>

We use the ``{% polymer element %}`` tag:

.. sourcecode:: twig

    {% polymer element "hello-world" attributes="names" %}{% endpolymer %}

The similarities should be apparent. We add two attributes to the
``{% polymer element %}`` tag: The name of the element, and the list of
attributes. You can add any attribute that's valid in the
``<polymer-element>`` tag, for instance ``constructor``, ``noscript``,
and ``extends``.

The code between the tags is identical. The difference when using the
``{% polymer element %}`` element tag is the code between the opening
and close tag is ignored by Twig. An exception **will not** be thrown
because of the ``{{name}}`` variable.

Importing Your Component
------------------------

Now you can use the element in your templates with the following code:

.. sourcecode:: twig

    {% polymer import "@AcmeBundle:hello-world/hello-world.html" %}

    <!-- Displays "Hello, World!" -->
    <hello-world></hello-world>

    <!-- Displays "Hello, Pascal!" -->
    <hello-world name="Pascal"></hello-world>

This code is also slightly different from using plain HTML5/JS. Instead
of using the following code to import your custom element:

.. sourcecode:: html

    <link rel="import" href="/some/directory/hello-world/hello-world.html">

You use this code:

.. sourcecode:: twig

    {% polymer import "@AcmeBundle:hello-world/hello-world.html" %}

Polyphonic will automatically resolve the component URL when using the
``{% polymer import %}`` tag. The ``{% polymer import %}`` tag also
provides a shortcut when the base file name of your ``.html`` file is
the same as the directory where it's save. The above statement could be
shortended to this:

.. sourcecode:: twig

    {% polymer import "@AcmeBundle:hello-world.html" %}

Importing Multiple Assets
-------------------------

The same ``{% polymer import %}`` tag can be used to import multiple
components.

.. sourcecode:: twig

    {% polymer import "@AcmeBundle:hello-world.html" "@AcmeBundle:custom-icons" "@AcmeBundle:custom-menu" %}

    <!-- You can write the asset names on separate lines as well. -->
    {% polymer import
        "@AcmeBundle:hello-world.html"
        "@AcmeBundle:custom-icons"
        "@AcmeBundle:custom-menu"
    %}

You've probably seen similar syntax when using the ``{% stylesheets %}``
and ``{% javascripts %}`` tags.

The Twig Tag
------------

Twig ignores *all* code between the
``{% polymer element %}{% endpolymer %}`` tag, which means you cannot
use Twig tags or variables inside your component definition. The
following code will not produce the expected results:

.. sourcecode:: twig

    {% polymer element "hello-world" attributes="names" %}
        <template>
            <p>Hello, {{name}}! Count with me!</p>
            {% for i in 0..3 %}
                <p>{{i}}!</p>
            {% endfor %}
        </template>
        <script>
            Polymer({
                name: "World"
            });
        </script>
    {% endpolymer %}

The ``{% for i in 0..3 %}`` tag will **not** get parsed by Twig. It will
simply be output as plain text. Also Polymer will try to parse the
``{{i}}`` variable, which is not a valid property. You have to use the
``<twig>`` tag if you want to include template code inside your element
definition.

.. sourcecode:: twig

    {% polymer element "hello-world" attributes="names" %}
        <template>
            <p>Hello, {{name}}! Count with me!</p>
            <twig>
                {% for i in 0..3 %}
                    <p>{{ i }}!</p>
                {% endfor %}
            </twig>
        </template>
        <script>
            Polymer({
                name: "World"
            });
        </script>
    {% endpolymer %}

You will get the expected output when using the ``<hello-world>`` tag.

::

    Hello, World! Count with me!
    0!
    1!
    2!
    3!

The `Importing Components documentation <importing.rst>`__ completely
covers using the ``{% polymer import %}`` tag.
