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

class IncludeSnippets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $requestedShop;
     protected $requestedthemeId;
     protected $requestedthemeName;
    public function __construct($shop, $themeId, $themeName)
    {
        $this->requestedShop      = $shop;
        $this->requestedthemeId  = $themeId;
        $this->requestedthemeName = $themeName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
      $url = URL::to("/");
      $postUrl = 'https://amkwebsolutions.com/shopify-app/TahaQuantityBreakAppCi/ApiController/themeInstallation';
      $client = new Client();
      $client->request('POST', $postUrl, [
        'json' => [
          'shop'      => $this->requestedShop,
          'themeId'   => $this->requestedthemeId,
          'themeName' => $this->requestedthemeName
        ]
      ]);
      return true;
    }



}
