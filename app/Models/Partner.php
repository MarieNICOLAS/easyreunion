<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class Partner extends Model
{
    use HasFactory;
    use Billable;
    use SoftDeletes;
    use Notifiable;

    protected $hidden = ['balance', 'iban'];

    protected $fillable = ['type', 'company', 'email', 'phone', 'website', 'is_validated'];

    protected static function booted()
    {
        static::created(function ($partner) {
            if ($partner->type !== 'spaceowner') {
                Agenda::create([
                    'name'       => 'Agenda de '.$partner->name,
                    'partner_id' => $partner->id,
                ]);
            }
            Address::create([
                'address_name'  => 'Adresse '.$partner->name,
                'customer_name' => 'Agenda '.$partner->name,
                'partner_id'    => $partner->id,
                'address'       => '',
                'city'          => '',
                'zipcode'       => '',
                'country'       => '',
            ]);
        });
    }

    public function getBalanceWithIncomingAttribute()
    {
        return $this->balance - $this->invoices()->pending()->pluck('ttc_total')->sum('ttc_total');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function spaceGroups()
    {
        return $this->hasMany(SpaceGroup::class);
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_partners')->withPivot('status');
    }

    public function scopeActive($query)
    {
        return $query->where('is_validated', 1);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getNameAttribute()
    {
        return $this->company;
    }

    public function routeNotificationFor($driver)
    {
        return $this->users->where('email_notifications', true)->pluck('email');
    }
}
