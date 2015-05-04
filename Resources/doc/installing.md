## Installing
Follow the steps below to install the bundle.

### Requirements
PHP 5.5.*  
Symfony 2.6.*

### Installing
Add `headzoo/polymer-bundle` to your composer.json requirements.

```javascript
"require": {
    "headzoo/polymer-bundle": "0.0.3"
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