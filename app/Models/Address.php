<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public static $rules = [
        'address_name' => 'required',
        'customer_name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'zipcode' => 'required',
        'country' => 'required',
    ];

    protected $fillable = ['user_id', 'partner_id', 'address_name', 'customer_name', 'address', 'city', 'zipcode', 'country'];
}
