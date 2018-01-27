# PJSON: A PHP templating system for JSON
PJSON makes it easy to design JSON responses using a PHP template.
The library was heavily inspired by Jbuilder by [@dhh](https://github.com/dhh).

I will use Silex to explain the librarys abilities
```php
use Silex\Application;

$app['pjson'] = function () {
    return new \Pjson\Renderer('../templates/');
};

$app->get('/', function () use ($app) {
    return $app['pjson']->render('index.pjson.php', [
        'greeting' => 'Hello World!'
    ]);
});
```
