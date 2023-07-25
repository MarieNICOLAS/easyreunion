<?php

namespace App\Models;

use App\Services\SellsyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'rank',
        'organization_id',
        'email_notifications',
        'sellsy_id',
        'active',
        'suppressed'
    ];

    protected $appends = ['sellsy_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function booted()
    {
        static::created(function ($user)
        {
            // If we're not creating it from sellsy
            if (!$user->sellsy_id && $user->rank !== 'admin')
            {
                $sellsy = new SellsyService();
                $user->sellsy_id = $sellsy->createCustomer($user);
                $user->save();
            }
        });
    }


    /**
     * Get the initials of user
     *
     * @return string
     */
    public function getInitials(): string {
        return $this->first_name[0].' '.$this->last_name[0];
    }


    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }

    public function selectedPartner()
    {
        if ($this->rank === 'admin') {
            return Partner::first();
        }
        // This will be updated later on
        return $this->partners->first();
    }

    public function getIsAdminAttribute()
    {
        return 'admin' === $this->rank;
    }

    public function getIsPartnerAttribute()
    {
        return 'partner' === $this->rank;
    }

    public function getHomeUrlAttribute()
    {
        return [
            'partner' => route('partner.dashboard'),
            'admin' => route('admin.dashboard'),
            'user' => route('user.bookings.index'),
            '' => route('user.bookings.index'),
        ][$this->rank];
    }


    public static function getAdmins()
    {
        return self::where('rank', 'admin')->get();
    }

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function getCurrentCart(): Estimate
    {
        if (! $this->estimates()->cart()->exists()) {
            return Estimate::create([
                'user_id' => $this->id,
            ]);
        }

        return $this->estimates()->cart()->orderBy('created_at', 'DESC')->first();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function getSellsyUrlAttribute()
    {
        if (!$this->sellsy_id)
            return null;

        return "https://www.sellsy.fr/peoples/" . $this->sellsy_id;
    }

}
