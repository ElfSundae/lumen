<?php

namespace App\Console\Commands;

use App\Support\Api;
use Illuminate\Console\Command;

class GenerateApiApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:api-app {app name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate key and secret for an api client.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $app = $this->argument('app name');

        $data = [
            'name' => $app,
            'key' => Api::appKeyForName($app),
            'secret' => Api::generateAppSecretForName($app),
        ];

        $this->table(array_keys($data), [array_values($data)]);
    }
}
