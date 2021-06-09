<?php

namespace App\Observers;

use App\Models\Invite;

class InviteObserver
{
    public function creating(Invite $invite)
    {
        $invite->token = $this->generateToken();
    }
    /**
     * Handle the Invite "created" event.
     *
     * @param  \App\Models\Invite  $invite
     * @return void
     */
    public function created(Invite $invite)
    {
        event(new NewInviteWasCreated($invite));
    }

    protected function generateToken()
    {
        $token = str_random(10);
        if(Invite::where('token', $token)->first()) {
            return $this->generateToken();
        }
        return $token;
    }

    /**
     * Handle the Invite "updated" event.
     *
     * @param  \App\Models\Invite  $invite
     * @return void
     */
    public function updated(Invite $invite)
    {
        //
    }

    /**
     * Handle the Invite "deleted" event.
     *
     * @param  \App\Models\Invite  $invite
     * @return void
     */
    public function deleted(Invite $invite)
    {
        //
    }

    /**
     * Handle the Invite "restored" event.
     *
     * @param  \App\Models\Invite  $invite
     * @return void
     */
    public function restored(Invite $invite)
    {
        //
    }

    /**
     * Handle the Invite "force deleted" event.
     *
     * @param  \App\Models\Invite  $invite
     * @return void
     */
    public function forceDeleted(Invite $invite)
    {
        //
    }
}
