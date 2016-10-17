<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roman extends Model
{
  protected $table = 'roman';

  protected $hidden = ['updated_at'];
}
