<?php
namespace spoons\api;

require_once '../app/resources/events.php';
require_once '../app/constants.php';

use \spoons\resources\Events;

/*
const FROM = 'from';
const TO = 'to';
const EVENT_TYPE = 'type';
const ANNOTATION = 'annotation';
const SEVERITY = 'severity';
*/


$app->get('/api/events', function() {
   Events::getSources();
});

$app->post('/api/events/:source', function($source) {
   Events::createEvent($source);
});
$app->get('/api/events/:source', function($source)
{
   global $app;
   $from = $app->request()->get(FROM);
   $to = $app->request()->get(TO);

   Events::getEvents($source, $from, $to);
});
$app->put('/api/events/:source/:eventId', function($source, $eventId)
{
   global $app;
   $getParams = $app->request()->get();
   Events::editEvent($source, $eventId, $getParams);
});


?>
