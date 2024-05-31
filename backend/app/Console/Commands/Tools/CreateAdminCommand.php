<?php

namespace App\Console\Commands\Tools;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {pass?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $pass = $this->argument('pass') ?? env('APP_ADMIN_PWD');
            $email = env('APP_ADMIN_EMAIL');

            $user = User::where('email', $email)->first();
            if (!empty($user)) {
                echo 'already exist';
            }

            User::factory()->create([
                'name' => 'admin',
                'email' => $email,
                'password' => $pass,
            ]);
        } catch (\Throwable $t) {
            Log::error(json_encode($t->getTrace()));
            echo $t->getMessage();
        }
    }
}
