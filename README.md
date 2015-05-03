# Polyphonic
Polymer Project bundle for the Symfony2 framework.



### Example Element
A simple example of using the `{% polymer element %}` Twig tag to create a custom `<hello-world><hello-world>` element. This element displays "Hello, World!" by default, but the message can be changed by setting the `name` attribute.

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
{% polymer import "hello-world" %}

<!-- Displays "Hello, World!" -->
<hello-world></hello-world>

<!-- Displays "Hello, Pascal!" -->
<hello-world name="Pascal"></hello-world>
```
