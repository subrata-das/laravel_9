<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Models\Task;

class ForceDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively delete old soft deleted record';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $carbon_now = Carbon::now();
        $tasks = Task::where('deleted_at', '<', $carbon_now->subMonth()->format('Y-m-d'))->forceDelete();
        if($tasks){
            $this->info('Successfully Deleted.');
        } else {
            $this->info('No task to delete here.');
        }
    }
}
