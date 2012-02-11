<?php
namespace spoons\api;

require_once '../app/constants.php';
require_once '../app/resources/timeseries.php';

use \spoons\resources\Timeseries;


$app->get('/api/timeseries', function() 
{
   global $app;
   $request = $app->request();

   $getMembers = $request->get('members');
   $getAttributes = $request->get('attributes');

   $collection = Timeseries\getCollection($getMembers, $getAttributes);

   // Error checking...

   echo json_encode($collection);
});

$app->get('/api/timeseries/:group', function($group) 
{
   global $app;
   $lang = $app->request()->get(LANG);

   $group = Timeseries\getGroup($group, $lang);

   // Error checking...
   // $group might not exist.
   if (empty($group)) 
   {
      $app->notFound();
   }
   else
   {
      echo json_encode($group);
   }
});

$app->get('/api/timeseries/:group/attributes', function($group) 
{
   global $app;
   $lang = $app->request()->get(LANG);

   $groupAttributes = Timeseries\getGroupAttributes($group, $lang);

   if (empty($groupAttributes))
   {
      $app->notFound();
   }
   else
   {
      echo json_encode($groupAttributes);
   }
});

// Retrieve statistics for the given series.
$app->get('/api/timeseries/:group/:name', function($group, $name) 
{
   global $app;
   $lang = $app->request()->get(LANG);

   $statistics = Timeseries\getSeriesStatistics($group, $name, $lang);

   if (empty($statistics))
   {
      $app->notFound();
   }
   else
   {
      echo json_encode($statistics);
   }
});

$app->get('/api/timeseries/:group/:name/:attribute', 
   $ensureTimerange, 
   function($group, $name, $attribute) 
{
   global $app;
   $request = $app->request();

   $from = $request->get(FROM);
   $to =  $request->get(TO);
   $lang = $request->get(LANG);
   $periodSize = $request->get(PERIOD_SIZE);
   $periodShift = $request->get(PERIOD_SHIFT);
   $js = $request->get(JS);

   $data = Timeseries\getSeriesAttribute(
      $group,
      $name,
      $attribute,
      $from,
      $to,
      $lang,
      $periodSize,
      $periodShift
   );

   if (!is_null($js))
   {
      $data = array_map(function($obj)
      {
         $values = array_values($obj);
         $values[0] = $values[0] * 60 * 1000;
         $values[1] = (int) $values[1];
         return $values;
      }, $data);
   }
 
   echo json_encode($data);
});

// Retrieve last minute data for a specific series.
$app->get('/api/timeseries/:group/:name/last_minute', function($group, $name) {
   $lastMinute = Timeseries\getLastMinute($group, $name);

   echo json_encode($lastMinute);
});

?>
