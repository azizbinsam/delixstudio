<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DemoteUser extends Command
{
    protected $signature   = 'user:demote {email}';
    protected $description = 'Cabut akses admin dari user';

    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->firstOrFail();
        $user->update(['is_admin' => false]);
        $this->info("✓ {$user->email} bukan admin lagi.");
    }
}
