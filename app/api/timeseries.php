<?php
namespace spoons\api;

require_once('../app/resources/timeseries.php');
use \spoons\resources\Timeseries;


const FROM = 'from';
const TO = 'to';
const PERIOD_SIZE = 'period_size';
const PERIOD_SHIFT = 'perdiod_shift';
const LANG = 'lang';
const JS = 'js';


$app->get('/api/timeseries', function() {
   global $app;
   $getMembers = $app->request()->get('members');
   $getAttributes = $app->request()->get('attributes');

   $collection = Timeseries::getCollection($getMembers, $getAttributes);

   // Error checking...

   echo json_encode($collection);
});

// Retrieve list of members within a group.
$app->get('/api/timeseries/:group', function($group) {
   $group = Timeseries::getGroup($group);

   // Error checking...

   echo json_encode($group);
});

// Retrieve attributes of a given group.
$app->get('/api/timeseries/:group/attributes', function($group) {
   $groupAttributes = Timeseries::getGroupAttributes($group);

   echo json_encode($groupAttributes);
});

// Retrieve statistics for the given series.
$app->get('/api/timeseries/:group/:name', function($group, $name) {
   $statistics = Timeseries::getSeriesStatistics($group, $name);

   echo json_encode($statistics);
});

// Retrieve data points for the given series and attribute. 'from' and 'to' parameters are required.
$app->get('/api/timeseries/:group/:name/:attribute', function($group, $name, $attribute) {
   global $app;
   $getParams = $app->request()->get();
   
   $data = Timeseries::getSeriesAttribute($group, $name, $attribute, $getParams);

   echo json_encode($data);
});

// Retrieve last minute data for a specific series.
$app->get('/api/timeseries/:group/:name/last_minute', function($group, $name) {
   $lastMinute = Timeseries::getLastMinute($group, $name);

   echo json_encode($lastMinute);
});

?>
