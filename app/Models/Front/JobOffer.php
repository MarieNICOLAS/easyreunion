<?php

namespace App\Models\Front;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;
    use Sluggable;

    public static $validation = [
        'title' => 'required|min:3|max:100',
        'description' => 'required|min:10|max:50000',
        'active' => 'required|in:true,false'
    ];
    protected $fillable = ['title', 'description', 'active'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
