<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dealer;
use App\Http\Controllers\Helper\Efris\KeysController;
use App\Http\Controllers\Helper\Efris\PostdataController;
use App\Http\Controllers\Helper\Efris\InvoiceController;
use Carbon\Carbon;
use App\Models\EfrisSetting;

class GetAesKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aeskey:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get aes assymetric key for TIN, Device number';

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
       
        $dealer = EfrisSetting::find(1);
        // foreach($dealers as $dealer){
            $keypath = $dealer->keypath;
            $keypwd = $dealer->keypwd;
            $tin = $dealer->tin;
            $deviceno = $dealer->deviceno;
            $privatek = (new KeysController)->getPrivateKey($keypath,$keypwd);
            $aeskey = (new KeysController)->getAesKey($tin,$deviceno,$privatek);

            $dealer->aeskey = $aeskey;
            $dealer->save();
       // }
        $this->info('Hourly Update has been send successfully');
        // \Log::info("running");
        // return 0;
    }
}
