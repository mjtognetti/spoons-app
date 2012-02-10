<?php
namespace spoons\resources\Events;
use \DB;

function getSources()
{
   // Monitors == sources.
   $monitors = DB::query('CALL getMonitors();');

   // Extract the monitor names from the response.
   $sources = array_map(function($monitor) {
      return $monitor['monitor'];
   }, $monitors);

   $sources[] = 'reported';
   
   return $sources;
}

function getEvents($source, $from, $to)
{
   $events = DB::query('CALL getEvents(%s, %i, %i);', $source, $from, $to);
   return $events;
}

function createEvent()
{
   return call_user_func_array('upsertEvent', func_get_args());
}

function editEvent()
{
   return call_user_func_array('upsertEvent', func_get_args());
}

function upsertEvent(
   $source,
   $from, 
   $to,
   $type,
   $annotation,
   $severity = 'unknown',
   $id = -1
)
{
   /*
   $response = DB::query('CALL upsertEvent(%i, %s, %s, %s, %i, %i, %s);',
      $id,
      $source,
      $type,
      $severity,
      $from,
      $to,
      $annotation
   );
   return $response;
   */

   return func_get_args();
}

?>
