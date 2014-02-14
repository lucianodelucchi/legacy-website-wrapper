<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app['debug'] = true;

//do fancy stuff before each request
//see http://silex.sensiolabs.org/doc/middlewares.html#before-middleware
$app->before(function (Request $request) use($app) {

}, Silex\Application::EARLY_EVENT);

//will match any request method (POST, GET, etc.)
$app->match('/{uri}', function (Silex\Application $app, Request $request, $uri){

  //the pattern /{uri} won't match something like /test/ so the $uri var will be empty,
  //we need to get the URI from the actual request
  //now we have /test/ in $uri
  $uri = empty($uri) ? $request->getRequestUri() : $uri;

  if (!is_file($uri)) {
    //we tried to include a file that doesn't exist e.g. /test/
    //append index.html and redirect to see what happens
    $uri .= 'index.html';
    return $app->redirect($uri);
  }

  //tweak error reporting in case the scripts being included generate some warnings
  //error_reporting(E_ERROR | E_PARSE);
  $page = get_include_contents($uri);

  //send the representation as a string
  //it's turned into an actual Response object by silex
  return $page;

})
->assert('uri', '.*');

$app->run();

/* helpers */
function get_include_contents($filename)
{
	ob_start();
	include $filename;
	return ob_get_clean();
}
/* end helpers */
