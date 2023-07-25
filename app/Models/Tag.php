<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'type'];
    

    public function scopeSearchType($query, string $type)
    {
        return $query->where('type', strtolower($type));
    }

    public function scopeSearch($query, string $name)
    {
        return $query->where('name', 'LIKE', strtolower($name));
    }

    public function spaces()
    {
        return $this->belongsToMany(Space::class, SpaceTag::class, 'tag_id', 'space_id')->withTimestamps();
    }

    public function scopeMaterials($query)
    {
        return $query->where('type', 'material');
    }

    public function scopeType($query)
    {
        return $query->where('type', 'type');
    }

    public static function types()
    {
        return self::searchType('type')->pluck('name', 'id');
    }

    public static function accesses()
    {
        return self::searchType('access')->pluck('name', 'id');
    }
    public static function mobilier()
    {
        return self::searchType('mobilier')->pluck('name', 'id');
    }
    public static function services()
    {
        return self::searchType('services')->pluck('name', 'id');
    }
}
