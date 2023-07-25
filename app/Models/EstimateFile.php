<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstimateFile extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'name', 'type', 'estimate_id', 'booking_id'];
    protected $appends = ['url_view', 'url_download'];

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(Estimate::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function getUrlViewAttribute(): string
    {
        return route('admin.files.view', $this);
    }

    public function getUrlDownloadAttribute(): string
    {
        return route('admin.files.download', $this);
    }
}
