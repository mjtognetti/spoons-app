<?php
namespace spoons\resources\Tweets;
use \DB;

function getCollection($from, $to, $lang='all', $limit=500, $randomize=1) 
{
   $lang = (is_null($lang) ? 'all' : $lang);
   $limit = (is_null($limit) ? 500 : $limit);
   $randomize = (is_null($randomize) ? 1 : $randomize);

   $collection = DB::query('CALL getTweets(%s, %i, %i, %i, %i);',
      $lang,
      $from,
      $to,
      $limit,
      $randomize);

   return $collection;
}

?>
