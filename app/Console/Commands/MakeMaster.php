<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:master {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate master';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('make:model', [
            'name' => $this->argument('name'),
            '-a' => true,
            '--api' => true,
            '--force' => true
        ]);

        Artisan::call('make:request', [
            'name' => $this->argument('name') . 'Request'
        ]);

        Artisan::call('make:resource', [
            'name' => $this->argument('name') . 'Collection'
        ]);

        Artisan::call('make:policy', [
            'name' => $this->argument('name') . 'Policy',
            '--model' => $this->argument('name')
        ]);
    }
}
