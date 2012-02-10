<?php
namespace spoons\api;

require_once '../app/api/middleware.php';
require_once '../app/constants.php';
require_once '../app/resources/events.php';


use \spoons\resources\Events;


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

$app->post('/api/events/:source', $ensureTimerange, function($source) {
   global $app;
   $post = $app->request();

   $from = $post(FROM);
   $to = $post(TO);
   $type = $post(TYPE);
   $severity = $post(SEVERITY);
   $annotation = $post(ANNOTATION);

   $event = Events\createEvent($source, $from, $to, $type, $severity, $annotation);
   echo json_encode($event);
});

$app->put('/api/events/:source/:eventId', $ensureTimerange, function($source, $eventId)
{
   global $app;
   $post = $app->request();

   $from = $post(FROM);
   $to = $post(TO);
   $type = $post(TYPE);
   $severity = $post(SEVERITY);
   $annotation = $post(ANNOTATION);
   $id = $post(ID);

   $event = Events\editEvent($source, $from, $to, $type, $severity, $annotation, $id);
   echo json_encode($event);
});


?>
