<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;
use OhMyBrew\ShopifyApp\Models\Shop;
use URL;

use GuzzleHttp\Client;

class Metafieldscheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $setId;
     protected $requestedShop;
     protected $productid;

    public function __construct($setid,$shop,$productid)
    {
        $this->setId=$setid;
        $this->requestedShop=$shop;
        $this->productid=$productid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
           $url = URL::to("/");
           $postUrl = 'https://amkwebsolutions.com/shopify-app/TahaQuantityBreakAppCi/Home/process_single_product';
           $client = new Client();
           $client->request('POST', $postUrl, ['json' => ['setID' => (int)$this->setId,'shop' => $this->requestedShop,'productid'=>$this->productid]]);
           return true;
    }



}
