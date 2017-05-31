<?php

namespace App\Console\Commands;

use App\Support\Api;
use Illuminate\Console\Command;

class GenerateApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:api-token {app key?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate api token.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = $this->argument('app key') ?: Api::defaultAppKey();

        if ($data = Api::tokenDataForKey($key)) {
            $this->table(array_keys($data), [array_values($data)]);
        } else {
            $this->error('Invalid app key: '. $key);
        }
    }
}
