Polyphonic Polymer Bundle
=========================

.. highlight:: twig

Symfony bundle and Twig extension for developing and deploying Polymer
web components.

.. image:: https://img.shields.io/travis/headzoo/polymer-bundle/master.svg?style=flat-square
	:target: https://travis-ci.org/headzoo/polymer-bundle
.. image:: https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square
	:target: https://raw.githubusercontent.com/headzoo/polymer-bundle/master/LICENSE.md

.. figure:: images/logos-wide.png
   :alt: Symfony, Polymer, Twig

.. important::
	This bundle is no where near production ready. Use at your own risk.

Creating and using custom Polymer elements within a Twig environment
can be difficult and error prone, because both Polymer and Twig use the
same ``{{double mustache}}`` syntax for variables and expressions.


Quick Start
-----------

A simple example of using the ``{% polymer element %}`` Twig tag to
create a custom ``<hello-world><hello-world>`` element. This element
displays "Hello, World!" by default, but the message can be changed by
setting the ``name`` attribute.

Note that there's no need to add
``<link rel="import" href="polymer/polymer.html">`` as the import
statement is added automatically. The template is saved in the bundle
directory at
*Resources/public/elements/hello-world/hello-world.html.twig*.

.. sourcecode:: twig

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

Using the element in your views:

.. sourcecode:: twig

    {% polymer import "@AcmeBundle:hello-world/hello-world.html.twig" %}

    <!-- Displays "Hello, World!" -->
    <hello-world></hello-world>

    <!-- Displays "Hello, Pascal!" -->
    <hello-world name="Pascal"></hello-world>

Polyphonic assumes a file named *hello-world.html.twig* can be found
in a directory of the same name, e.g. *hello-world*.

.. toctree::
	:maxdepth: 2
	
	installing.rst
	configuration.rst
	custom.rst
	importing.rst
	deploy.rst
	extension.rst
	
	about/credits.rst
	about/license.rst