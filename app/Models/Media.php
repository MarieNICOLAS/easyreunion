<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    protected $primaryKey = 'id';


    public function scopeImage($query)
    {
        return $query->where('type', 'image');
    }

    public function getUrlAttribute()
    {
        if ($this->type !== 'video')
        {
            return asset('storage/media/' . $this->content);
        }

        return $this->content;
    }
}
