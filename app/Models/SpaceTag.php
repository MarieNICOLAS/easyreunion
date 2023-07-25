<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpaceTag extends Model
{
    protected $table = 'space_tag';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = ['tag_id','space_id'];

}
