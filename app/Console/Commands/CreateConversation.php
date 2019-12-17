<?php

namespace App\Console\Commands;

use App\Http\Helpers\FirebaseDatabaseHelper;
use Illuminate\Console\Command;
use Log;

class CreateConversation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'realtimedb:createConversation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $value = FirebaseDatabaseHelper::get_firebase_connection()->getReference('Conversations')
            ->getValue();
        foreach($value as $item) {
            if(count($item) > 0 ) {
                Log::alert($item[key($item)]['fromID']);
            }
            break;
        }

    }
}
