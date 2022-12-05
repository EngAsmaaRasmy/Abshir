<?php

namespace App\Console\Commands;

use App\Models\admin\OfferModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class removeExpireOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:offer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove expire offers from datebase';

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
        $now=Carbon::now();
        $offers=OfferModel::where("expireDate","<",$now)->get();
        foreach ($offers as $offer){
            File::delete(public_path().'/'.$offer->image);
            $offer->delete();

        }
        echo "done";

    }
}
