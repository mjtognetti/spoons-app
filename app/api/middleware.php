<?php
namespace spoons\api;
require_once '../app/constants.php';


$ensureTimerange = function() {
   global $app;
   $request = $app->request();

   $from = $request->params(FROM);
   $to = $request->params(TO);

   if ( (is_null($from) && !ctype_digit($from)) ||
        (is_null($to) && !ctype_digit($to)) ) 
   {
      $app->halt(400, "No timerange set.");
   }
}

?>
