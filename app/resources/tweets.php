<?php
namespace spoons\resources;

class Tweets 
{

   public static function getCollection($params) 
   {
      $from = $params[FROM];
      $to = $params[TO];
      $lang = $params[LANG];
      $limit = $params[LIMIT];
   }
}

?>
