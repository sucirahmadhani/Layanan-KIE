<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    protected $table = 'tes';
    protected $fillable = ['skor_pretest', 'skor_posttest', 'survey'];

}
