<?php

namespace App\Notifications\Admin;

use App\Models\Partner;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PartnerRequestNotification extends Notification
{
    use Queueable;

    private Partner $partner;

    public function __construct(Partner $partner)
    {
        $this->partner = $partner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
</svg>',
            'message' => 'Nouvelle demande !',
            'link' => route('admin.partners.show', $this->partner),
        ];
    }
}
