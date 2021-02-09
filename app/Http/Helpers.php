<?php
namespace App\Http;
class Helpers {

   public static function makeOnlyFirstLetterUppercase($string): string 
   {
      return  str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($string))));
   }
}
