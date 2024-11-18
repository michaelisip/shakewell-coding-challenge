<?php

namespace App\Observers;

use App\Mail\WelcomeMail;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $voucher = Voucher::factory()->state([
            'user_id' => $user->id,
        ])->create();

        Mail::to($user)->send(new WelcomeMail($voucher));
    }
}
