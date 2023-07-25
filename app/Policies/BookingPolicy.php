<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin') {
            return true;
        }
    }

    public function accessUserPerspective(User $user, Booking $booking)
    {
        return $booking->user_id === $user->id;
    }
}
