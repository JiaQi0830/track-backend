<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupApplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup application command';

    public function handle()
    {
        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('passport:install', ['--force' => true]);
    }
}
