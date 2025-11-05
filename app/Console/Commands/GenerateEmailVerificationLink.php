<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Carbon\Carbon;

class GenerateEmailVerificationLink extends Command
{
    protected $signature = 'email:verification-link {email}';
    protected $description = 'Generate email verification link for testing';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        if ($user->hasVerifiedEmail()) {
            $this->warn("User email is already verified!");
            $this->line("Verified at: " . $user->email_verified_at);
            return 0;
        }

        // Generate verification URL
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->info('Email verification link generated successfully!');
        $this->line('');
        $this->line('Email: ' . $email);
        $this->line('User ID: ' . $user->id);
        $this->line('');
        $this->line('Verification URL:');
        $this->line($url);
        $this->line('');
        $this->line('Link expires in: 60 minutes');

        return 0;
    }
}
