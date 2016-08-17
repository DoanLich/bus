<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendRegisterEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail after register';

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
     * @return mixed
     */
    public function handle()
    {
        sleep(2);
        \Log::info("Send mail success");
    }
}
