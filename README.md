# UpCloo Module for Zend Framework 2

UpClooModule integrates UpCloo with Zend Framework 2 quickly and easily

*This module is in alpha state do not use in production*

## Installation

Simple add to your composer

```
"require": {
    "wdalmut/upcloo-module": "dev-master"
}
```

## Usage

In your configuration add you sitekey and configure the module.

```php
<?php

return array(
    'upcloo' => array(
        'sitekey' => 'your-sitekey-here',
        'auto_apply' => true,
        'route' => array(
            'application/default',
            'blog/post'
        )
    )
)
```

The route options is useful to add UpCloo SDK automatically in particular
routes.

Remember that your have to add this module in your main configuration
`application.config.php`

```php
<?php
return array(
    'modules' => array(
        'UpClooModule',
        'Application',
        // ...
    ),
    // ...
```

## Engage UpCloo Manually

If you disable the `auto_apply` options (set to `false`) you have to place
the UpCloo SDK manually using the dedicated `HelperView`.

```php
<div>
    // a view...
</div>

<!-- This is the UpCloo JavaScript SDK -->
<?php echo $this->upclooSdk($this->pageURL); ?>

</div class="a-class">
    <p>The page continue...</p>
</div>
```

## UpCloo optimized for Search Engines

If you want to create a link based strategy useful for Search Engine Optimization
you can use `UpClooForSpiders` view helper. In order to achieve this result
you have to use the dedicated view helper

```php
<div>
    // a view...
</div>

<!-- This is the UpCloo JavaScript SDK -->
<?php
    $relatedPosts = $this->upclooForSpiders($this->pageURL);
    //Style $relatedPosts as you want (array of contents).
?>

</div class="a-class">
    <p>The page continue...</p>
</div>
```

