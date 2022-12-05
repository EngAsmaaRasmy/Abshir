<?php

namespace App\Console\Commands;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use DB;
use App\traits\FCMTrait;
use App\Models\admin\ShopModel;
use App\Models\Admin;

class NotifiyShop extends Command
{
    
        use  FCMTrait;


   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';
    
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
        \Log::info("Cron is working fine!");
 
         $shops_ids = OrderProduct::where('status', 'pending')->get()->pluck('shop');
         
         foreach($shops_ids as $shop_id){
            $shop = ShopModel::find($shop_id);
             
            if($shop){
                $this->sendToUser($shop->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
            }
         }
         
         foreach(Admin::whereNotNull('fcm_token')->get() as $admin){
 
                $this->sendToUser($admin->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
         }
         
         
         OrderProduct::where([['notify_count', '>=' , 2],['status','pending']])->update([
            'status' => 'cancelled',
            ]);
            
 
        OrderProduct::where('status', 'pending')->update([
            'notify_count' => DB::raw('notify_count+1'),
            ]);
            

        $this->info('Demo:Cron Cummand Run successfully!');
    }
}