<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UserDeletionNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAccountDeletionNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-account-deletion';
    protected $description = 'Send email notifications 24 hours before account deletion';

    public function handle()
    {
        $this->info('Sending account deletion notifications...');

        $threshold = now()->subHours(24);

        $users = User::where('blocked_at', '<=', $threshold)->get();

        foreach ($users as $user) {
            $user->notify(new UserDeletionNotification($user));
            $this->info('Notification sent to: ' . $user->email);
        }

        $this->info('Account deletion notifications sent.');
    }
}
