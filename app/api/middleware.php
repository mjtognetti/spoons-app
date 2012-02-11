<?php
namespace spoons\api;
require_once '../app/constants.php';


$ensureTimerange = function() {
   global $app;
   $request = $app->request();

   if ($request->isGet()) {
      $from = $request->params(FROM);
      $to = $request->params(TO);
   }
   else {
      $params = json_decode($request->getBody(), TRUE);
      $from = (array_key_exists(FROM, $params) ? $params[FROM] : NULL);
      $to = (array_key_exists(TO, $params) ? $params[TO] : NULL);
   }

   if ( (is_null($from) && !ctype_digit($from)) ||
        (is_null($to) && !ctype_digit($to)) ) 
   {
      $app->halt(400, "No timerange set.");
   }
}

?>
