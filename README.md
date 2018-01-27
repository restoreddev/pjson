# PJSON: A PHP templating system for JSON
PJSON makes it easy to design JSON responses using a PHP template.
The library was heavily inspired by Jbuilder by [@dhh](https://github.com/dhh).
Here is an example using Slim:

#### App
```php
// index.php
$app = new \Slim\App;

$container = $app->getContainer();
$container['pjson'] = function () {
    return new \Pjson\SlimRenderer('templates/');
};

$app->get('/', function ($request, $response) {
    return $this->pjson->render($response, 'index.pjson.php', [
        'greeting' => 'Hello World!'
    ]);
});
```

#### Template
```php
// templates/index.pjson/php
$pjson->greeting = $greeting;
```

#### Response
```json
{
    "greeting": "Hello World!"
}
```
