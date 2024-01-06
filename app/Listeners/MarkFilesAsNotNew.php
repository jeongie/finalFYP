<?php

// app/Listeners/MarkFilesAsNotNew.php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\File;

class MarkFilesAsNotNew
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        // Mark the files as not new when the user logs out
        File::where('user_id', $event->user->id)->update(['is_new' => false]);
    }
}

