<?php

namespace App\Models;

use App\Services\SellsyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'sellsy_id'];

    protected $appends = ['sellsy_url'];

    protected static function booted()
    {
        static::created(function ($org)
        {
            // If we're creating the org from ER and not from sellsy, add it to sellsy
            if (!$org->sellsy_id)
            {
                $sellsy = new SellsyService();
                $org->sellsy_id = $sellsy->createCompany($org->name);
                $org->save();
            }
        });
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getSellsyUrlAttribute()
    {
        if (!$this->sellsy_id)
            return null;

        return "https://www.sellsy.fr/thirds/client/" . $this->sellsy_id;
    }
}
