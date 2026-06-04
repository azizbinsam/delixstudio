<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteUser extends Command
{
    protected $signature   = 'user:promote {email}';
    protected $description = 'Jadikan user sebagai admin';

    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->firstOrFail();
        $user->update(['is_admin' => true]);
        $this->info("✓ {$user->email} sekarang adalah admin.");
    }
}
