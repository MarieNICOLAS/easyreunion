<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpaceAction extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'resolved', 'space_id', 'user_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function scopePending($query)
    {
        return $query->where('resolved', false);
    }
}
