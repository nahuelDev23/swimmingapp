<?php
namespace App\Http;
use Illuminate\Support\Collection;
class Helpers {

   public static function makeOnlyFirstLetterUppercase($string): string 
   {
      return  str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($string))));
   }

   public static function ConvertCollectionToArray(Collection $collection): Array 
   {
      $array = [];
        foreach ($collection as $item) {
         array_push($array, $item);
     }
     return $array;
   }
}
