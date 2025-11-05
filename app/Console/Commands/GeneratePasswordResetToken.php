<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GeneratePasswordResetToken extends Command
{
    protected $signature = 'password:reset-token {email}';
    protected $description = 'Generate password reset token for testing';

    public function handle()
    {
        $email = $this->argument('email');

        // Generate plain token
        $token = Str::random(64);

        // Hash token for database
        $hashedToken = Hash::make($token);

        // Store in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $hashedToken,
                'created_at' => now()
            ]
        );

        $url = url('/reset-password/' . $token . '?email=' . urlencode($email));

        $this->info('Password reset token generated successfully!');
        $this->line('');
        $this->line('Email: ' . $email);
        $this->line('Token: ' . $token);
        $this->line('');
        $this->line('Reset URL:');
        $this->line($url);

        return 0;
    }
}
