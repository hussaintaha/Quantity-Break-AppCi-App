<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;
use OhMyBrew\ShopifyApp\Models\Shop;
use View;
use Artisan;
use URL;
use Carbon\Carbon;
use App\Jobs\DeleteSets;
use App\Jobs\SaveDiscountSets;
use App\Jobs\Metafieldscheck;
use App\Jobs\IncludeSnippets;

use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;
class AppController extends Controller
{

    public function GetActiveTheme()
    {
        $shop   = ShopifyApp::shop();
        $themes = $shop->api()->request('GET', '/admin/themes.json');
        foreach ($themes->body->themes as $theme) {
            if ($theme->role == 'main') {
                $active = $theme;
            }
        }
        $theme_id     = $active->id;
        $product_page = $shop->api()->request('GET', 'admin/themes/' . $active_theme->id . '/assets.json', ['asset[key]' => 'templates/product.liquid']);
    }
    public function index(Request $request)
    {
        $shop = ShopifyApp::shop();
        try {
            $shopdata    = $shop->api()->request('GET', '/admin/shop.json');
            $shopDatashp = $this->getShopDetails($shopdata->body->shop->myshopify_domain);
            $d_prices    =  DB::table('price_types')->get();
            $discount_set    = DB::table('tbl_discount_set')->where('shop_id',$shopDatashp->id)->get();
            $previousCount    = DB::table('tbl_discount_set')->where('shop_id',$shopDatashp->id)->get()->count();
            $url = URL::to("/");
            return View::make('welcome', ['shop' => $shopdata->body->shop->myshopify_domain,'prevJobs'=>$previousCount, 'shopdata' => $shopDatashp, 'd_rules' => $d_prices, 'discount_set'=>$discount_set,'AppURL'=>$url]);
        } catch (\Exception $e) {
            return View::make('shopify-app::auth.index');
        }
    }

    public function getShopDetails($shopp)
    {
        return DB::table('shops')->where('shopify_domain', $shopp)->first();
    }

    public function GetPreviousRecords($shopp)
    {
        return DB::table('shops')->where('shopify_domain', $shopp)->first();
    }


    public function GetProducts(Request $request)
    {
      $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
      // dd($ShopifyApiClient);
      if ($request->title != '') {
          $search         = ['title' => $request->title, 'page' => $request->pageNumber];
          $products_count = $ShopifyApiClient->api()->request('GET', '/admin/products/count.json', ['title' => $request->title]);
      } else {
          $search         = ['page' => $request->pageNumber];
          $products_count = $ShopifyApiClient->api()->request('GET', '/admin/products/count.json');
      }

      $ShopifyApiClient = ShopifyApp::shop_get($request->shop);


      $products = $ShopifyApiClient->api()->request('GET', '/admin/products.json', $search);
// dd($products->body->products);
      if (isset($products->body->products)) {
          if (count($products->body->products) > 0) {

              $responsedata               = [];
              $responsedata['type']       = 'products';
              $responsedata['type_value'] = 'all';
              $i                          = 0;
              foreach ($products->body->products as $singleProduct) {
                  $returnProduct['id']     = $singleProduct->id;
                  $returnProduct['title']  = $singleProduct->title;
                  $returnProduct['handle'] = $singleProduct->handle;
                  foreach ($singleProduct->variants as $singleVariants) {
                      $returnVariants['id']               = $singleVariants->id;
                      $returnVariants['price']            = $singleVariants->price;
                      $returnVariants['compare_at_price'] = $singleVariants->compare_at_price;
                      $returnVariants['title']            = $singleVariants->title;
                      $variantDaTa[]  = $returnVariants;
                      $returnVariants = [];
                  }
                  $returnProduct['variants']  = $variantDaTa;
                  $variantDaTa                = [];
                  $returnProduct['image_url'] = (isset($singleProduct->image->src)) ? $singleProduct->image->src : '';
                  $product[]                  = $returnProduct;
                  $returnProduct              = [];
                  $i++;
                }

              $responsedata['totalNumber'] = $products_count->body->count;
              $responsedata['currentPage'] = 1;
              $responsedata['totalPage']   = ceil($products_count->body->count / 50);
              $responsedata['data'] = $product;
              $responsedata['code'] = 200;
              $responsedata['msg']  = $i . " product found.";
          } else {
              $responsedata['totalNumber'] = $products_count->body->count;
              $responsedata['type']        = 'products';
              $responsedata['type_value']  = 'all';
              $responsedata['code']        = 100;
              $responsedata['data']        = [];
              $responsedata['msg']         = "No product found.";
          }

      } else {
          $responsedata['totalNumber'] = $products_count->body->count;
          $responsedata['type']        = 'products';
          $responsedata['type_value']  = 'all';
          $responsedata['code']        = 100;
          $responsedata['data']        = [];
          $responsedata['msg']         = "No product found.";
      }
      return response()->json($responsedata);
    }

    public function DeleteDiscountSet(Request $request)
    {
        $total_jobs = DB::table('jobs')->count();
        $delay = $total_jobs+20;
        $job = (new DeleteSets($request->set_id,$request->shop))->delay(Carbon::now()->addSeconds($delay));
        dispatch($job);
        $responsedata = ["code" => 200, "msg" => "Delete Request  Added in queue "];
        // Artisan::call("queue:work");
        return response()->json($responsedata);
    }

    public function ProcessDeleteDicountSet(Request $request)
      {
            $setid = $request->set_id;
            $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
            $tbl_set_data = DB::table('tbl_product_discount')->where(["set_id"=>$setid])->get();
            $setProducts=array();
            $setQtys=array();
            foreach ($tbl_set_data as $set) {
                  if(!in_array($set->p_id,$setProducts)){
                      $setProducts[]=$set->p_id;
                  }
                  if(!in_array($set->qty,$setQtys)){
                      $setQtys[]=$set->qty;
                  }
            }

            foreach ($setProducts as $product) {
                  $productMeta = $ShopifyApiClient->api()->request('GET', '/admin/products/'.$product.'/metafields.json');
                  if (count($productMeta->body->metafields) > 0) {
                      // Log::info('Seacrh For Product.--'.$product);
                      foreach ($setQtys as $qty) {
                        foreach ($productMeta->body->metafields  as  $meta) {
                          $explode = explode('~',$meta->key);
                          if(count($explode) > 1  && $explode[1] == $qty){
                            // Log::info('Count of Exloded Key--'.$meta->key.'-- Delete For QTY '.$qty);
                              $delete = $ShopifyApiClient->api()->request('DELETE', '/admin/metafields/'.$meta->id.'.json');
                          }
                        }
                      }
                  }
            }
            // Log::info('Remove Discount Sets For Set ID.--'.$setid);

            $delete1 = DB::table("tbl_discount_set")->where(["id"=>$setid])->delete();
            $delete2 = DB::table("tbl_product_discount")->where(["set_id"=>$setid])->delete();
            $delete3 = DB::table("tbl_set_price")->where(["set_id"=>$setid])->delete();
            $delete4 = DB::table("tbl_product_grid")->where(["set_id"=>$setid])->delete();
      }

    public function GetMetaID($metafields,$qty)
    {
          foreach ($metafields as $meta) {
              if (explode('~',$meta->key)[1] == $qty) {
                  $return = $meta;
              }
          }
          return $return;
    }

    public function includesnippets_job(Request $request) {
      // dd($request->all());
      $total_jobs = DB::table('jobs')->count();
      $delay = $total_jobs+2;
      $job = (new IncludeSnippets($request->shop, $request->themeId, $request->themeName))->delay(Carbon::now()->addSeconds($delay));
      dispatch($job);
    }

    public function discountset_job(Request $request){
      //dd($request->all());
      $total_jobs = DB::table('jobs')->count();
      $delay = $total_jobs+2;
      $job = (new SaveDiscountSets($request->setId,$request->shop))->delay(Carbon::now()->addSeconds($delay));
      dispatch($job);
    }

    public function checkmetafields_job(Request $request){
      $total_jobs = DB::table('jobs')->count();
      $delay = $total_jobs+2;
      $job = (new Metafieldscheck($request->setId,$request->shop,$request->productid))->delay(Carbon::now()->addSeconds($delay));
      dispatch($job);
    }

    public function testcode(){

      $postUrl = 'https://amkwebsolutions.com/shopify-app/TahaQuantityBreakAppCi/Home/DiscountSet_process';
      $client = new Client();
    $json=  $client->request('POST', $postUrl, ['json' => ['setID' => 1,'shop' => 'vw-product-customizer.myshopify.com']]);
    print_r($json->getBody());
    }
    public function SaveData(Request $request)
    {
      // dd($request);
        $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
        $discount_set_array=["set_name"=>$request->name,"shop_id"=>$ShopifyApiClient->id];
        $tbl_set_id = DB::table('tbl_discount_set')->insertGetId($discount_set_array);
          $tblgrid          = array();
          $details=array();
          foreach ($request['selected_products'] as $ky => $product) {
              $precount = DB::table('tbl_product_details')->where('p_id', '=', $product)->count();
              $tblgrid[] = ["p_id" => $product, "grid_style" => $request['custom_display'],"set_id"=>$tbl_set_id];
              if($precount <=0){
                $details[]=["p_id" => $product,'image'=>$request[$product.'image'],'price'=>$request[$product.'price'],'title'=>$request[$product.'title']];
              }
          }
          $save1 = DB::table('tbl_product_grid')->insert($tblgrid);
          if(count($details) >0){
            DB::table('tbl_product_details')->insert($details);
          }

        $discount_set_data = array();
        foreach ($request['selected_products'] as $ky => $product) {
            foreach ($_POST[$product] as $key => $variant) {
                foreach ($request['pb_quantity'] as $qtykey => $qty) {
                    $price_rule[] = array(
                        'p_id'           => $product,
                        'variant_id'     => $variant,
                        'qty'            => $qty,
                        'discount_price' => $request['pb_quantity_price'][$qtykey],
                        'discount_type'  => $this->GetDiscountTypeId($request['price_type'])->id,
                        'shop_id'        => $ShopifyApiClient->id,
                        "set_id"=>$tbl_set_id
                    );
                }
                $save2 = DB::table('tbl_set_price')->insert($price_rule);
            }
            DB::table('tbl_product_discount')->where('p_id', $product)->delete();
            foreach ($request['pb_quantity'] as $kt => $qty) {
                $discount_set_data[] = ["p_id" => $product, "qty" => $qty,  "discount_type"=>$this->GetDiscountTypeId($request['price_type'])->id, "discount" => $request['pb_quantity_price'][$kt],"set_id"=>$tbl_set_id];
            }

        }
            $save3 = DB::table('tbl_product_discount')->insert($discount_set_data);
            $total_jobs = DB::table('jobs')->count();
            $delay = $total_jobs+20;
            $job = (new SaveDiscountSets($tbl_set_id,$request->shop))->delay(Carbon::now()->addSeconds($delay));
            dispatch($job);
            $responsedata = ["code" => 200, "msg" => "Discount Sync Request Added in queue"];
            return response()->json($responsedata);
    }

    public function ProcessDiscountSet(Request $request)
    {
          $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
          $tbl_set_data = DB::table('tbl_product_discount')->get();
          $setProducts=array();
          foreach ($tbl_set_data as $set) {
              if($set->set_id == $request->setID){
                if(!in_array($set->p_id,$setProducts)){
                    $setProducts[]=$set->p_id;
                }
              }
          }
      foreach ($setProducts as $product) {
          $productMeta = $ShopifyApiClient->api()->request('GET', '/admin/products/'.$product.'/metafields.json');
          $qty_data = DB::table('tbl_product_discount')->where(["p_id"=>$product])->get();
          $productVariants = DB::table('tbl_set_price')->select('variant_id')->where(["p_id"=>$product])->distinct()->get();
          foreach ($productVariants as $variant) {
                  $variant_data  = $ShopifyApiClient->api()->request('GET', '/admin/products/' . $product . '/variants/' . $variant->variant_id . '.json');
                  $variant_price = $variant_data->body->variant->price;
                  $chk           = $this->FindMetafields($productMeta->body->metafields, $variant->variant_id, '1');
                  if ($chk == false) {
                      $mtSingle =["metafield"=>["namespace"  => "csp" . $variant->variant_id,"key" => "default~1","value"=> "%,1,,2,,0","value_type" => "string"]];
                      $saveMeta = $ShopifyApiClient->api()->request('POST', '/admin/products/' . $product . '/metafields.json', $mtSingle);
                  }

              foreach ($qty_data as $qty) {
                    if (count($productMeta->body->metafields) > 0) {
                      $already = $this->FindMetafields($productMeta->body->metafields, $variant->variant_id, $qty->qty);
                        if ($already) {
                          $delete = $ShopifyApiClient->api()->request('DELETE', '/admin/metafields/' . $already->id . '.json');
                        }
                    }
                    $PostMeta = array("metafield" => $this->MetaFieldsArray($variant->variant_id, $qty->qty, $qty->discount_type, $variant_price));
                    $saveMeta = $ShopifyApiClient->api()->request('POST', '/admin/products/' . $product . '/metafields.json', $PostMeta);
              }
          }
      }
    }



    public function GetType($lowest_price)
    {
        $type = $lowest_price->discount_type;
        switch ($type) {
            case 1:
                $p1 = "%";
                break;
            case 2:
                $p1 = "-";
                break;
            case 3:
                $p1 = "$";
                break;
        }
        return $p1;

    }
    public function GetAmt($type, $customer_price, $variant_price)
    {
        switch ($type) {
            case "%":
                $p1 = 1 - ($customer_price->discount_price / 100);
                break;
            case "-":
                $p1 = $variant_price - $customer_price->customer_gets;
                break;
            case "$":
                $p1 = $customer_price->customer_gets;
                break;
        }
        return $p1;

    }
    public function MetaFieldsArray($variant, $qty, $d_type, $variant_price)
    {

        $lowest_price = $this->FindMinimumPrice($variant, $qty, $d_type, $variant_price);
        $type         = $this->GetType($lowest_price);
        $amt          = $this->GetAmt($type, $lowest_price, $variant_price);
        $value        = $type . "," . $amt . ",2,,0";
        $key          = "default~" . $qty;
        $array        = ["namespace"  => "csp".$variant,"key"=> $key,"value"=> $value,"value_type" => "string"];
        return $array;
    }

    public function FindMinimumPrice($variant, $qty, $d_type, $variant_price)
    {
        $prices = DB::table('tbl_set_price')->where(['variant_id' => $variant, 'qty' => $qty])->get()->toArray();
        foreach ($prices as $price) {
            $price->customer_gets = $this->GetDiscountedPrice($price->discount_type, $price->discount_price, $variant_price);
        }
        $pr = array();
        foreach ($prices as $key => $record) {
            $pr[] = $record->customer_gets;
        }
        array_multisort($pr, SORT_ASC, $prices);
        return $prices[0];
    }

    public function GetDiscountedPrice($type, $discount, $product_price)
    {
        $p1;
        switch ($type) {
            case 1:
                $p1 = $product_price - (($product_price * $discount) / 100);
                break;
            case 2:
                $p1 = $product_price - $discount;
                break;
            case 3:
                $p1 = $discount;
                break;
        }
        return $p1;
    }

    public function FindMetafields($metafields, $var_id, $qty)
    {
        $return = false;
        foreach ($metafields as $meta) {
            if ($meta->namespace == "csp" . $var_id && $meta->key == "default~" . $qty) {
                $return = $meta;
            }
        }
        return $return;
    }

    public function GetDiscountTypeId($type)
    {
        return $result = DB::table('price_types')->where(['value' => $type])->first();
    }

    public function GetProductDiscountSet(Request $request)
    {
        $result = DB::table('tbl_set_price')->where('p_id', $request['p_id']);
        if ($result->count() > 0) {
            $data = $result->get();
            foreach ($data as $key => $dat) {
                $dat->dis_type = $this->GetDiscuntType($dat->discount_type)->price_type;
            }
            $responsedata = array("code" => 200, "msg" => "Data Found", "data" => $data);
        } else {
            $responsedata = array("code" => 100, "msg" => "Data Found");
        }
        return response()->json($responsedata);
    }

    public function GetDiscuntType($type)
    {
        return DB::table('price_types')->where('id', $type)->first();
    }

    public function CheckExistense($variant)
    {
        return DB::table('tbl_set_price')->where('variant_id', $variant)->first();
    }

    public function GetDiscountSetProducts(Request $request)
    {
      $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
      $return="";
      $return.='<style>
      .btnclass{
          background: linear-gradient(180deg,#6371c7,#5563c1);
          box-shadow: inset 0 1px 0 0 #6774c8,0 1px 0 0 rgba(22,29,37,.05),0 0 0 0 transparent;
          position: relative;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          min-height: 2.6rem;
          margin: 0;
          padding: .7rem 1.6rem;
          border-color:#3f4eae;
          color:#fff;
          border-radius: 6px;
          cursor:pointer;
      }
                </style>';
      $return.='<div style="margin-left: 7%;">';
      $return.='<table style="border:1px solid black;border-collapse:collapse;"><tr><th style="border:1px solid black;">Product Image</th><th style="border:1px solid black;">Title</th><th style="border:1px solid black;">View</th></tr>';


      $setProducts = DB::table('tbl_product_discount')->select('p_id')->where('set_id',  $request->set_id)->distinct()->get();
      foreach ($setProducts as $key => $products) {

          $productMeta = $ShopifyApiClient->api()->request('GET', '/admin/products/'.$products->p_id.'.json');
          $return.='<tr>
          <td style="border:1px solid black;text-align: center;"><img style="height: 50px;" src="'.( isset($productMeta->body->product->image->src) ? $productMeta->body->product->image->src : ''  ).'"></td><td style="border:1px solid black;text-align: center;">'.$productMeta->body->product->title.'</td>
          <td style="border:1px solid black;text-align: center;">
          <div style="display:inline-flex">
          <a  target="_blank"   href="https://'.$request->shop.'/admin/products/'.$products->p_id.'" ><button  type="button" class="btnclass" >Admin</button></a>
          <a  target="_blank"  href="https://'.$request->shop.'/products/'.$productMeta->body->product->handle.'" ><button  type="button" class="btnclass"  style="margin-left: 2%;background:#fe9d52;border:#fe9d52;" >StoreFront</button></a>
          </div>
          </td></tr>';
      }
      $return.='</table>';
      $return.='</div>';
     echo $return;

    }
}
