Legacy Website Wrapper
======================

There is no much to it, just open index.php and tweak it as required using all the benefits of Silex.

All the requests are being handled by the route:

```php
$app->match('/{uri}', function (Silex\Application $app, Request $request, $uri){
//code
})
->assert('uri', '.*');
```

Installation
============
At the moment you'll have to clone this repo and run:

```
composer install
```

To make sure all the requests are sent to the front controller you'll have to teak your web server configuration, here is the config file for nginx:
https://gist.github.com/lucianodelucchi/8999075

Enjoy!
