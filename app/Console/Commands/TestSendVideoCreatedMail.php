<?php

namespace App\Console\Commands;

use App\Notifications\VideoCreated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestSendVideoCreatedMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:videocreatednotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Per enviar un test de prova';

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
        Notification::route('mail', 'dpont@iesebre.com')->notify(new VideoCreated(create_default_video()));

    }
}
