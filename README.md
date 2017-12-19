# Eskirex Cache Component
Hello.
This is Cache component.

## Examples
```php
<?php
    use Eskirex\Component\Cache\VariableCache;
    
    require __DIR__ . '/vendor/autoload.php';
    
    $cacheNode1 = new VariableCache('foo_bar_baz');
    
    $cacheNode1->set('foo', [
        'bar' => 'baz'
    ]);
    
    print_r($cacheNode1->get('foo'));
    // Array
    // (
    //     [bar] => baz
    // )
    
    
    $cacheNode2 = new VariableCache('foo_bar_baz');
    
    print_r($cacheNode2->get('foo'));
    // Array
    // (
    //     [bar] => baz
    // )
```
## License
MIT