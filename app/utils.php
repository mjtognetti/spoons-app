<?php
namespace spoons\Utils;

function dget($array, $key, $default) {
   return (array_key_exists($key, $array) ? $array[$key] : $default);
}

?>
