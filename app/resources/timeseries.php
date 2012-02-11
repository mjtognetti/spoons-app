<?php
namespace spoons\resources\Timeseries;
use \DB;

function getCollection($getMembers, $getAttributes, $lang = 'all') 
{
   $lang = $lang ?: 'all';
   if (is_null($getMembers))
   {
      $groups = DB::call('CALL getGroupNames();');
   }
   else
   {
      $members = DB::call('CALL getGroupMemberNames();');
      $groups = array();

      foreach ($members as $member) 
      {
         $groupName = $member['group'];
         if (!array_key_exists($groupName, $groups))
         {
            $groups[$groupName] = array('members' => array());
         }
         $groups[$groupName]['members'][] = $member;
      }

      $groups = array_map(function($group, $groupName) {
         $group['name'] = $groupName;
         return $group;
      }, $groups, array_keys($groups));
   }

   if (!is_null($getAttributes))
   {
      $groups = array_map(function($group) use ($lang) {
         $group['attributes'] = DB::call('CALL getGroupAttributes(%s, %s);',
            $group['name'],
            $lang
         );
         return $group;
      }, $groups);
   }

   return $groups;
}

function getGroup($group, $lang='all') 
{
   $lang = $lang ?: 'all';
   $group = DB::call('CALL getMembers(%s, %s);', $group, $lang);
   return $group;
}

function getGroupAttributes($group, $lang = 'all') 
{
   $lang = $lang ?: 'all';
   $attributes = DB::call('CALL getGroupAttributes(%s, %s);', 
      $group, 
      $lang
   );
   return $attributes;
}

function getSeriesStatistics($group, $series, $lang = 'all') 
{
   $lang = $lang ?: 'all';
   $statistics = DB::call('CALL seriesStats(%s, %s, %s);',
      $group,
      $series,
      $lang
   );
   return $statistics;
}

function getSeriesAttribute(
   $group, 
   $series, 
   $attribute, 
   $from,
   $to,
   $lang = 'all',
   $periodSize = 0,
   $periodShift = 0
) 
{
   $lang = $lang ?: 'all';
   $periodSize = (is_null($periodSize) ? 0 : $periodSize);
   $periodShift = (is_null($periodShift) ? 0 : $periodShift);

   $data = DB::call('CALL periodResults(%s, %s, %s, %s, %i, %i, %i, %i);',
      $group,
      $series,
      $lang,
      $attribute,
      $from,
      $to,
      $periodSize,
      $periodShift
   );

   return $data;
}

function getLastMinute($group, $name) 
{

}

?>
