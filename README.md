# Polyphonic
Polymer Project bundle for the Symfony2 framework.



### Example Element
```html
<hello-world></hello-world>
<hello-world name="Pascal"></hello-world>

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
