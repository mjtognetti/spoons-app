<?php
namespace spoons\crazyQuery;
use \DB;

$app->get('/crazyQuery', function()
{
   global $app;
   $app->render('crazyQuery.mustache');
});

$app->post('/crazyQuery', function()
{
   global $app;
   $query = $app->request()->post('query');
   
   if (!is_null($query))
   {
      if (stripos($query, 'delete') !== FALSE ||
         stripos($query, 'drop') !== FALSE ||
         stripos($query, 'truncate') !== FALSE ||
         stripos($query, 'alter') !== FALSE)
      {
         $app->halt(400, "I don't think so.");
      }
      

      $response = DB::query($query);
      $data = array_map(function($obj)
      {
         $values = array();
         $values[] = ((int)$obj['x']) * 60 * 1000;
         $values[] = (int)$obj['y'];
         return $values;
      }, $response);

      echo json_encode($data);
   }
   else
   {
      $app->halt(
         400, 
         "You're a fool. This is a query page and you don't have a query!"
      );
   }
   
});


?>
