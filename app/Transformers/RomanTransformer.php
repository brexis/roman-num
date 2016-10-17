<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Roman;

/**
 * Roman data transformer class
 */
class RomanTransformer extends TransformerAbstract
{
  public function transform(Roman $roman)
  {
    return [
      'id'          => $roman->id,
      'number'      => $roman->number,
      'result'      => $roman->result,
      'created_at'  => $roman->created_at->toDateTimeString()
    ];
  }
}
