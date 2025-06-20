<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScoutReimportAll extends Command
{
    protected $signature = 'scout:reimport-all';
    protected $description = 'Reimport all searchable models into Laravel Scout';


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
        $this->call('scout:import', ['model' => 'App\Models\Post']);
        $this->call('scout:import', ['model' => 'App\Models\Folder']);
        $this->info('All models have been reimported into Scout.');
    }
}
