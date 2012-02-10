<?php
namespace spoons\api;

require_once '../app/constants.php';
require_once '../app/api/middleware.php';
require_once '../app/resources/tweets.php';

use \spoons\resources\Tweets;


$app->get('/api/tweets', $ensureTimerange, function()
{
   global $app;
   $request = $app->request();

   $from = $request->get(FROM);
   $to = $request->get(TO);
   $lang = $request->get(LANG);
   $limit = $request->get(LIMIT);
   $randomize = $request->get(RANDOMIZE);

   $collection = Tweets\getCollection($from, $to, $lang, $limit, $randomize);

   //Error checking

   echo json_encode($collection);
});

?>
