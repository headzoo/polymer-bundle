Configuration
=============

.. highlight:: twig

This document covers the Polyphonic configuration. These settings should
be added to your */app/config/config.yml* file.

.. sourcecode:: yaml

    polymer:
        debug:         %kernel.debug%
        auto_verbatim: true
        auto_imports:
            - "core-animation.html"
            - "paper-elements.html"
        twig:
            tag: "polymer"
            templates:
                element: "PolymerBundle:polymer:element.html.twig"
                import:  "PolymerBundle:polymer:import.html.twig"
        paths:
            elements:   "elements"
            components: "bower_components"

debug
-----

Default: ``true``

Turns debugging on and off. This setting dictates how the
``{% polymer import %}`` tag resolves custom element paths. When
debugging is turned on the Polyphonic bundle will serve your custom
element .html files directory from your bundle
*Resources/public/elements* directory. When debugging is turned off
you must `install your
assets <http://symfony.com/blog/new-in-symfony-2-6-smarter-assets-install-command>`__
to the */web* directory. Including your custom elements. The
Polyphonic bundle will look for your custom elements in the directory
*/web/bundles/your_bundle/elements* directory.

auto\_verbatim
--------------

Default: ``true``

The bundle configures Twig to ignore code between {% polymer %} tags,
which is *usually* what you want. However, in order for the feature to
work the bundle uses it's own *Twig_Environment* and *Twig_Lexer*
implementations, which may interfer with your application. You can set
this setting to ``false`` if you run into problems, however when this
feature is turned off you must have to wrap your Polymer code in Twig's
own ``{% verbatim %}{% endverbatim %}`` tag.

See the `Creating Elements <custom.rst>`__ documentation for more
information.

auto\_imports
-------------

Default: ``[]``

A list of components to import automatically when using the
``{% polymer element %}`` tag. This is useful when many of your custom
elements need to import the same components. Using the following
setting:

.. sourcecode:: yaml

    polymer:
        auto_imports:
            - "paper-elements/paper-elements.html"
            - "core-ajax/core-ajax.html"

Will generate the these import statements whenever you use the
``{% polymer element %}`` tag:

.. sourcecode:: twig

    {% polymer import "polymer/polymer.html" %}
    {% polymer import "paper-elements/paper-elements.html" %}
    {% polymer import "core-ajax/core-ajax.html" %}

    {% polymer element %}
        ...
    {% endpolymer %}

.. note::
    Note: You do not add "polymer/polymer.html" to this setting. It's
    automatically imported every time you write a {% polymer element %}
    tag.

See the `Importing Components <importing.rst>`__ documentation for more
information.

twig.tag
--------

Default: ``"polymer"``

If you need to you can change the ``{% polymer %}`` tags to use a
different value. For instance if you set this setting to "poly" you
would then use the tags ``{% poly element %}`` and
``{% poly import %}``.

.. important::
	This is an advanced setting that should not be
	changed unless you absolutely need to. Setting it to a different
	value may break other bundles that reply on the Polyphonic bundle.

twig.templates.element
----------------------

Default: ``"PolymerBundle:polymer:element.html.twig"``

Path to the template used to create ``<polymer-element>`` tags.

twig.templates.import
---------------------

Default: ``"PolymerBundle:polymer:import.html.twig"``

Path to the template used to create ``<link rel="import">`` tags.

paths.elements
--------------

Default: ``"elements"``

Specifies the directory inside your bundle *Resources/public*
directory where custom elements are saved. When using the setting
"elements" the bundle will look for your custom elements in the
*Resources/public/elements* directory.

.. important::
	This is an advanced setting that should not be
	changed unless you absolutely need to. Setting it to a different
	value may break other bundles that reply on the Polyphonic bundle.

paths.components
----------------

Defaults: ``"bower_components"``

Specifies the directory inside your project */web* directory where
Polymer's core components are installed. When using the setting
"bower\_components" the bundle will look for core components in the
*/web/bower_components* directory.

.. important::
	This is an advanced setting that should not be
	changed unless you absolutely need to. Setting it to a different
	value may break other bundles that reply on the Polyphonic bundle.
