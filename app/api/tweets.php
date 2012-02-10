<?php
namespace spoons\api;

// PHP require paths are relative to the initial script, which in this
// case is index.php in /public.
require_once '../app/resources/tweets.php';
use \spoons\resources\Tweets;

// Retrieve information about the entire collection of tweets or
// retrieve a subset of tweet collection.
$app->get('/api/tweets', function()
{
   global $app;
   $getParams = $app->request()->get();

   $collection = Tweets::getCollection($getParams);

   //Error checking
   //conditions:
   // missing paramters
   // no results

   echo json_encode($collection);
});


?>
