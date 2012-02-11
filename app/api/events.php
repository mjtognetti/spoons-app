<?php
namespace spoons\api;

require_once '../app/constants.php';
require_once '../app/utils.php';
require_once '../app/api/middleware.php';
require_once '../app/resources/events.php';


use \spoons\resources\Events;
use \spoons\Utils;

$app->get('/api/events', function() {
   $sources = Events\getSources();
   echo json_encode($sources);
});

$app->get('/api/events/:source', $ensureTimerange, function($source)
{
   global $app;
   $from = $app->request()->get(FROM);
   $to = $app->request()->get(TO);

   $events = Events\getEvents($source, $from, $to);
   echo json_encode($events);
});

$app->post('/api/events/:source', 
   $ensureTimerange, 
   function($source) 
{
   global $app;
   $params = json_decode($app->request()->getBody(), TRUE);

   $from = Utils\dget($params, FROM, NULL);
   $to = Utils\dget($params, TO, NULL);
   $type = Utils\dget($params, TYPE, NULL);
   $severity = Utils\dget($params, SEVERITY, NULL);
   $annotation =  Utils\dget($params, ANNOTATION, NULL);

   $event = Events\createEvent(
      $source, 
      $from, 
      $to, 
      $type, 
      $severity, 
      $annotation
   );
   echo json_encode($event);
});

$app->put('/api/events/:source/:eventId', 
   $ensureTimerange, 
   function($source, $id) 
{
   global $app;
   $params = json_decode($app->request()->getBody(), TRUE);

   $from = Utils\dget($params, FROM, NULL);
   $to = Utils\dget($params, TO, NULL);
   $type = Utils\dget($params, TYPE, NULL);
   $severity = Utils\dget($params, SEVERITY, NULL);
   $annotation =  Utils\dget($params, ANNOTATION, NULL);

   $event = Events\editEvent(
      $source, 
      $from, 
      $to, 
      $type, 
      $severity, 
      $annotation, 
      $id
   );
   echo json_encode($event);
});


?>
