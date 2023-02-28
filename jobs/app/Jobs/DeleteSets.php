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


class DeleteSets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $setId;
     protected $shop;
    public function __construct($set_id,$reqshop)
    {
        $this->setId=(int)$set_id;
        $this->shop=$reqshop;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = URL::to("/");
        $postUrl = $url.'/ProcessDeleteDicountSet';
        $client = new Client();
        $client->request('GET', $postUrl, ['json' => ['set_id' => $this->setId,'shop' => $this->shop]]);
        return true;
    }


}
