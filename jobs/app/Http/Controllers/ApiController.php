<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;
use OhMyBrew\ShopifyApp\Models\Shop;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

      public function GetProductPrice($productData)
      {
          return $productData->body->product->variants[0]->price;
      }

      public function GetShopCurrency($shop_data)
      {
          return $shop_data->body->shop->currency;
      }

    public function GetDiscountedPrice($type, $discount, $product_price)
    {
        $p1;
        switch ($type) {
            case 1:
                //Percent Discount
                $p1 = $product_price - (($product_price * $discount) / 100);
                break;
            case 2:
                // Fixed Price Discount
                $p1 = $product_price - $discount;
                break;
            case 3:
                // Set Product Price  Equal TO Discount
                $p1 = $discount;
                break;
        }
        return $p1;
    }

    public function CreateDiscountTableHtml($grid_style,$result, $currency, $product_price)
    {

          $return;
          $ReturnHtml = "";
        switch ($grid_style) {
            case 1:
                $ReturnHtml .= '<table class="shappify_qb_grid">';
                $ReturnHtml .= '<thead>';
                $ReturnHtml .= '<tr>';
                $ReturnHtml .= '<th>Qty</th>';
                $ReturnHtml .= '<th>Price</th>';
                $ReturnHtml .= '</tr>';
                $ReturnHtml .= '</thead>';
                $ReturnHtml .= '<tbody>';
                foreach ($result as $tbl_r) {
                    $ReturnHtml .= '<tr>';
                    $ReturnHtml .= '<td>Buy ' . $tbl_r->qty . '</td>';
                    $ReturnHtml .= '<td>'.$currency.' ' . $this->GetDiscountedPrice($tbl_r->discount_type, $tbl_r->discount, $product_price) . ' ea</td>';
                    $ReturnHtml .= '</tr>';
                }
                $ReturnHtml .= '</tbody>';
                $ReturnHtml .= '</table>';
                break;
            case 2:
                $ReturnHtml .= '<table class="shappify_qb_grid">';
                $ReturnHtml .= '<thead>';
                $ReturnHtml .= '<tr><th>Qty</th><th>Price</th></tr></thead>';
                $ReturnHtml .= '<tbody>';
                foreach ($result as $tbl_r) {
                $ReturnHtml .= '<tr>';
                $ReturnHtml .= '<td>'.$tbl_r->qty.'</td>';
                $ReturnHtml .= '<td>'.$currency.' ' . $this->GetDiscountedPrice($tbl_r->discount_type, $tbl_r->discount, $product_price) . '</td>';
                $ReturnHtml .= '</tr>';
                }
                $ReturnHtml .= '</tbody>';
                $ReturnHtml .= '</table>';
                break;
            case 3:
                  $ReturnHtml .= '<table class="shappify_qb_grid">';
                  $ReturnHtml .= '<thead>';
                  $ReturnHtml .= '<tr><th>Minimum Qty</th><th>Maximum Qty</th><th>Price</th></tr></thead>';
                  $ReturnHtml .= '<tbody>';
                  foreach ($result as $key => $tbl_r) {
                    $ReturnHtml .= '<tr>';
                    $ReturnHtml .= '<td>'.$tbl_r->qty.'</td>';
                    $ReturnHtml .= '<td>'.(isset($result[$key+1]->qty) ? ($result[$key+1]->qty-1) : $tbl_r->qty.'++').'</td>';
                    $ReturnHtml .= '<td>'.$currency.' ' . $this->GetDiscountedPrice($tbl_r->discount_type, $tbl_r->discount, $product_price) . '</td>';
                    $ReturnHtml .= '</tr>';
                  }
                  $ReturnHtml .= '</tbody>';
                  $ReturnHtml .= '</table>';
                break;
            case 4:
                $ReturnHtml .= '<table class="shappify_qb_grid">';
                $ReturnHtml .= '<thead>';
                $ReturnHtml .= '<tr>';
                $ReturnHtml .= '<th>Qty</th>';
                $ReturnHtml .= '<th>Price</th>';
                $ReturnHtml .= '<th>Discount</th>';
                $ReturnHtml .= '</tr>';
                $ReturnHtml .= '</thead>';
                $ReturnHtml .= '<tbody>';
                foreach ($result as $key => $tbl_r) {
                    $ReturnHtml .= '<tr>';
                    $ReturnHtml .= '<td>'.$tbl_r->qty.'</td>';
                    $ReturnHtml .= '<td>'.$currency.' ' . $this->GetDiscountedPrice($tbl_r->discount_type, $tbl_r->discount, $product_price) . ' ea</td>';
                    $ReturnHtml .= '<td>'.(100-(($this->GetDiscountedPrice($tbl_r->discount_type, $tbl_r->discount, $product_price)*100)/$product_price)).' % Off</td>';
                    $ReturnHtml .= '</tr>';
                }
                $ReturnHtml .= '</tbody>';
                $ReturnHtml .= '</table';
                break;
            case 5:
                $ReturnHtml .= '<table class="shappify_qb_grid">';
                $ReturnHtml .= '<thead>';
                $ReturnHtml .= '<tr>';
                $ReturnHtml .= '<th>Qty</th>';
                $ReturnHtml .= '<th>Discount</th>';
                $ReturnHtml .= '</tr>';
                $ReturnHtml .= '</thead>';
                $ReturnHtml .= '<tbody>';
                foreach ($result as $key => $tbl_r) {
                    $ReturnHtml .= '<tr>';
                    $ReturnHtml .= '<td>Buy '.$tbl_r->qty.'</td>';
                    $ReturnHtml .= '<td>'.(100-(($this->GetDiscountedPrice($tbl_r->discount_type, $tbl_r->discount, $product_price)*100)/$product_price)).' % Off</td>';
                    $ReturnHtml .= '</tr>';
                }
                $ReturnHtml .= '</tbody>';
                $ReturnHtml .= '</table';
                break;
            case 6:
                  $ReturnHtml .= '<table class="shappify_qb_grid">';
                  $ReturnHtml .= '<thead>';
                  $ReturnHtml .= '<tr>';
                  $ReturnHtml .= '<th>Qty</th>';
                  $ReturnHtml .= '<th>Price</th>';
                  $ReturnHtml .= '</tr>';
                  $ReturnHtml .= '</thead>';
                  $ReturnHtml .= '<tbody>';
                  foreach ($result as $key => $tbl_r) {
                      $ReturnHtml .= '<tr>';
                      $ReturnHtml .= '<td>Buy '.$tbl_r->qty.'-'.(isset($result[$key+1]->qty) ? ($result[$key+1]->qty-1) : $tbl_r->qty.'++').'</td>';
                      $ReturnHtml .= '<td>'.$currency.' ' . $this->GetDiscountedPrice($tbl_r->discount_type, $tbl_r->discount, $product_price) . '</td>';
                      $ReturnHtml .= '</tr>';
                  }
                  $ReturnHtml .= '</tbody>';
                  $ReturnHtml .= '</table';
                break;
            default:
                echo "NO Table Structure Found";
        }

        return $ReturnHtml;
    }

    public function GetProductDiscount(Request $request)
    {
        $result = DB::table('tbl_product_discount')->where('p_id', $request['p_id'])->get();
        if ($result->count() > 0) {
            $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
            $shop_data        = $ShopifyApiClient->api()->request('GET', '/admin/shop.json');
            $productData      = $ShopifyApiClient->api()->request('GET', '/admin/products/' . $request['p_id'] . '.json');
            $currency         = $this->GetShopCurrency($shop_data);
            $product_price    = $this->GetProductPrice($productData);
            $data['is_qb_enabled']=true;
            $grid = DB::table('tbl_product_grid')->where('p_id', $request['p_id'])->orderBy('id', 'desc')->first();
            $data['grid']=$this->CreateDiscountTableHtml($grid->grid_style,$result, $currency, $product_price);
            $data['style']='';
            return response()->json($data);
        } else {
            $data['message']='No Data Found';
            return response()->json($data);
        }

    }

    public function GetCartPrices(Request $request)
    {
            header('Content-Type: application/json');
            $add=array();
            $update=array();
            $delete=array();
            $ShopifyApiClient = ShopifyApp::shop_get($request->shop);
            $data['add']=$add;
            $data['update']=$update;
            $data['delete']=$delete;
            $data['savings']='';
            $cart_data = json_decode($request['cart']);
            $return=array();
            $return['token'] = $cart_data->token;
            $return['note'] = $cart_data->note;
            $return['attributes'] = $cart_data->attributes;
            $arrayall=['add'=>[],'update'=>[],'delete'=>[],'savings'=>'','request'=>$cart_data];
            echo json_encode($arrayall);
            exit;

    }


    public function customer_pricing(Request $request)
    {
      $contents = View::make('getprices');
      $response = Response::make($contents);
      $response->header('Content-Type', 'application/javascript');
      return $response;
      return View::make('getprices');
    }

    public function csp_install_check(Request $request)
    {
        header('Content-Type: application/javascript');
        echo $data='window.VWQBRK = window.VWQBRK || {};
        window.VWQBRK.csp = window.VWQBRK.csp || {};
        window.VWQBRK.csp.is_installed = true;';
        exit;
    }

    public function cspqb(Request $request)
    {
         // $contents = View::make('cspqb');
         // $response = Response::make($contents);
         // $response->header('Content-Type', 'application/javascript');
         // return $response;
    }


    public function get_qb_discount_banner_data(Request $request)
    {
      header('Content-Type: application/json');
      echo '{"is_qb_enabled": true,
        "is_you_saved_banner_enabled": true,
        "csp_qb_discount_banner_style":"color:#114760;background-color:#CDE8F4;border-color:#A4CBDD;margin:0px;padding:10px;font-size:12px;" ,
        "csp_display_fields": {
        "shop_app_id": 505162,
        "display_id": 2,
        "price_text": "Price",
        "qty_text": "Qty",
        "qty_min_text": "Minimum Qty",
        "qty_max_text": "Maximum Qty",
        "buy_qty_text": "Buy",
        "price_each_text": "ea",
        "preceeding_cart_text": "You will save",
        "following_cart_text": "by buying bulk",
        "unlimited_qty_text": "+",
        "color": "114760",
        "background_color": "CDE8F4",
        "border_color": "A4CBDD",
        "margin": 0,
        "padding": 10,
        "font_size": 12,
        "custom_display": null,
        "css": null,
        "overwrite_grid_css": false,
        "thead_background_color": "D6D6D6 ",
        "table_font_size": 12,
        "thead_color": "000",
        "thead_bold": true,
        "tbody_background_1": "FFF",
        "tbody_background_2": "EFEFEF",
        "tbody_color": "000",
        "cell_padding": 5,
        "table_border": true,
        "table_border_color": "ccc",
        "table_margin": 0,
        "additional_css": "",
        "percent_discounted_text": "Off",
        "percent_text": "Discount",
        "show_base_price": true
      }}';
      exit;

    }


      public function CreateDraftOrder(Request $request)
      {

          $ShopifyApiClient = ShopifyApp::shop_get($request['shop']);
          $cart_data = json_decode($request['cart_data']);
          $line_items = array();
          foreach ($cart_data->items as $key => $item) {
              $discount_get=0;
              if($item->original_price != $item->price){
                $discount_get=($item->original_price-$item->price)/100;
              }
              if($discount_get > 0){
                $line_items[] = ["variant_id" => $item->id,"quantity"   => $item->quantity,"applied_discount"=>["description"=>"VWQBRK Discount","value_type" => "fixed_amount","value"=> $discount_get,"amount"=> ($discount_get*$item->quantity)]];
              }else{
                $line_items[] = ["variant_id" => $item->id,"quantity"   => $item->quantity];
              }
          }
          if($request['shopify_customer_id']){
            $draft_order = ["draft_order"=>["line_items"=>$line_items,'customer'=>['id'=>$request['shopify_customer_id']]]];
          }else{
            $draft_order = ["draft_order"=>["line_items"=>$line_items]];
          }

          // dd($draft_order);
          $draft_order_status=$ShopifyApiClient->api()->request('POST', '/admin/draft_orders.json', $draft_order);
          return redirect($draft_order_status->body->draft_order->invoice_url);

      }







}
