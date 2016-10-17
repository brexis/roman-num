<?php

namespace App\Services;

use App\Roman;

class RomanConversionService extends AbstractNumberConversion
{
  protected $model = \App\Roman::class; // Set the conversion service model

  protected $transformer = \App\Transformers\RomanTransformer::class; // Set the conversion service transformer

  /**
   * Implement the convert method to convert integer to roman
   * @param  integer $integer
   * @return string
   */
  public function convert($integer)
  {
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = [
      'M' => 1000,
      'CM' => 900,
      'D' => 500,
      'CD' => 400,
      'C' => 100,
      'XC' => 90,
      'L' => 50,
      'XL' => 40,
      'X' => 10,
      'IX' => 9,
      'V' => 5,
      'IV' => 4,
      'I' => 1
    ];

    foreach($lookup as $roman => $value){
      // Determine the number of matches
      $matches = intval($integer/$value);

      // Add the same number of characters to the string
      $result .= str_repeat($roman,$matches);

      // Set the integer to be the remainder of the integer and the value
      $integer = $integer % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
  }
}
