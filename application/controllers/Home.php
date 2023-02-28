<?php

defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
class Home extends CI_Controller {
   public function __construct() {
      parent::__construct(); //Do your magic here
      $this->load->database();
      $this->load->helper('url');
      $this->load->helper('global_helper');
      $this->load->helper('date');
      $this->load->model('Home_model');
      $this->load->library('Jobs');
   }
      public function demo()
      {
         if ($_GET['shop']!='') {
            $shop = $_GET['shop'];
            $shop_id = $this->Home_model->GetShopId($shop);
            if($shop_id != ''){
               $data = array();

               $this->load->load_admin('', $data);
            }else{
               echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
            }
         }else{
            $this->load->view('errors/html/error_404');
         }
      }

   public function welcome()
   {
      if ($_GET['shop']!='') {
         $shop = $_GET['shop'];
         $shop_id = $this->Home_model->GetShopId($shop);
         if($shop_id != ''){
            $data = array();
            $data['d_prices']         = $this->Home_model->getPriceset();
            $data['discount_set']     = $this->Home_model->discountSet($shop_id);
            $data['previousCount']    = $this->Home_model->discountSetCount($shop_id);
            $data['page']             = 'welcome';
            // dd($data);
            $this->load->load_admin('welcome', $data);
         }else{
            echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
         }
      }else{
         $this->load->view('errors/html/error_404');
      }
   }

   public function GetProducts()
   {
      $year = getYear();
     $shopAccess = getShop_accessToken_byShop($_GET['shop']);
     $this->load->library('Shopify', $shopAccess);
     if ($_GET['title'] != '') {
         $search         = ['title' => $_GET['title'], 'page' => $_GET['pageNumber'] ];
         $products_count = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin//api/'.$year.'products/count.json?title='.$_GET['title']  ]);
     } else {
         $search         = ['page' => $_GET['pageNumber']];
         $products_count = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/products/count.json ']);
     }

     $products = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/products.json'], $search);

     if (isset($products)) {
         if (count($products->products) > 0) {

             $responsedata               = [];
             $responsedata['type']       = 'products';
             $responsedata['type_value'] = 'all';
             $i                          = 0;
             foreach ($products->products as $singleProduct) {
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

             $responsedata['totalNumber'] = $products_count->count;
             $responsedata['currentPage'] = 1;
             $responsedata['totalPage']   = ceil($products_count->count / 50);
             $responsedata['data'] = $product;
             $responsedata['code'] = 200;
             $responsedata['msg']  = $i . " product found.";
         } else {
             $responsedata['totalNumber'] = $products_count->count;
             $responsedata['type']        = 'products';
             $responsedata['type_value']  = 'all';
             $responsedata['code']        = 100;
             $responsedata['data']        = [];
             $responsedata['msg']         = "No product found.";
         }

     } else {
         $responsedata['totalNumber'] = $products_count->count;
         $responsedata['type']        = 'products';
         $responsedata['type_value']  = 'all';
         $responsedata['code']        = 100;
         $responsedata['data']        = [];
         $responsedata['msg']         = "No product found.";
     }
     // dd($responsedata);
     echo json_encode($responsedata);
   }

   public function DeleteDiscountSet()
   {
     // dd($_GET);
     if($_GET['shop'] && $_GET['set_id'])
     {
          $total_jobs = $this->db->select('*')->get('tbl_discount_set')->num_rows();
          $delay = $total_jobs+20;
          $this->ProcessDeleteDicountSet($_GET['set_id'],$_GET['shop']);
     }else {
       print_r('shop name and set id is not passed');
     }
   }

   public function ProcessDeleteDicountSet($setid, $shop)
     {
        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);
           $tbl_set_data = $this->db->where(["set_id"=>$setid])->get('tbl_product_discount')->result();
           $setProducts=array();
           $setQtys=array();
           // dd($tbl_set_data);
           foreach ($tbl_set_data as $set) {
                 if(!in_array($set->p_id,$setProducts)){
                     $setProducts[]=$set->p_id;
                 }
                 if(!in_array($set->qty,$setQtys)){
                     $setQtys[]=$set->qty;
                 }
           }

           foreach ($setProducts as $product) {
                 $productMeta = $this->shopify->call(['METHOD' =>'GET', 'URL' =>'/admin/products/'.$product.'/metafields.json']);
                 if (count($productMeta->metafields) > 0) {
                     // Log::info('Seacrh For Product.--'.$product);
                     foreach ($setQtys as $qty) {
                       foreach ($productMeta->metafields  as  $meta) {
                        $explode = explode('~',$meta->key);
                        if(count($explode) > 1  && $explode[1] == $qty) {
                           // dd($meta->id);
                           // Log::info('Count of Exloded Key--'.$meta->key.'-- Delete For QTY '.$qty);
                             $delete = $this->shopify->call(['METHOD' =>'DELETE', 'URL' => '/admin/metafields/'.$meta->id.'.json']);

                        }
                       }
                     }
                 }
           }
           // Log::info('Remove Discount Sets For Set ID.--'.$setid);
           $delete1 = $this->db->where(["id"=>$setid])->delete("tbl_discount_set");
           $delete2 = $this->db->where(["set_id"=>$setid])->delete("tbl_product_discount");
           $delete3 = $this->db->where(["set_id"=>$setid])->delete("tbl_set_price");
           $delete4 = $this->db->where(["set_id"=>$setid])->delete("tbl_product_grid");

           $responsedata = ["code" => 200, "msg" => "Discount set is deleted"];
           echo json_encode($responsedata);
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


     public function test_func(){
       $send_data['shop']="vw-product-customizer.myshopify.com";
       $send_data["setId"]=40;
         $curl_url=base_url().'jobs/discountset_job';
       $response=$this->CurlData($send_data,  $curl_url);
       print_r($response);
       exit;

     }

        public function SaveData()
     {
       // dd($_POST);
        if ($_GET['shop']!='') {
           $shop = $_GET['shop'];
           $shop_id = $this->Home_model->GetShopId($shop);
           if($shop_id != ''){
             $custom_display    = $this->input->post('custom_display');
             $name              = $this->input->post('name');
             $selected_products = $this->input->post('selected_products');
             $pb_quantity_price = $this->input->post('pb_quantity_price');
             $shopAccess = getShop_accessToken_byShop($_GET['shop']);
             $this->load->library('Shopify', $shopAccess);
             $discount_set_array=["set_name"=>$name,"shop_id"=>$shop_id];

             //insert data to table .get id of last increamented row
              $this->db->insert('tbl_discount_set',$discount_set_array);
              $tbl_set_id = $this->db->insert_id();
             $tblgrid          = array();
             $details=array();
             foreach ($selected_products as $ky => $product) {
                $precount = $this->db->select('*')->where('p_id', $product)->where('shop_id', $shop_id)->from('tbl_product_details')->count_all_results();
                $tblgrid[] = ["p_id" => $product, "grid_style" => $custom_display,"set_id"=>$tbl_set_id,'shop_id'=>$shop_id];
                if($precount <=0){
                  $details[] =['shop_id'=>$shop_id,"p_id" => $product,'image'=>$this->input->post($product.'image'),'price'=>$this->input->post($product.'price'),'title'=>$this->input->post($product.'title') ];
                }
            }

            foreach ($tblgrid as $row) {
               $save1 = $this->db->insert('tbl_product_grid', $row);
            }

           if(count($details) >0){
             foreach ($details as $row) {
                $this->db->insert('tbl_product_details', $row);
             }
           }

         $discount_set_data = array();
         foreach ($selected_products as $ky => $product) {
             foreach ($_POST[$product] as $key => $variant) {
                 foreach ($_POST['pb_quantity'] as $qtykey => $qty) {
                     $price_rule[] = array(
                        'p_id'           => $product,
                        'variant_id'     => $variant,
                        'qty'            => $qty,
                        'discount_price' => $_POST['pb_quantity_price'][$qtykey],
                        'discount_type'  => $this->Home_model->GetDiscountTypeId($this->input->post('price_type')),
                        'shop_id'        => $shop_id,
                        "set_id"         => $tbl_set_id
                     );
                 }
                 foreach ($price_rule as $row) {
                    $save2 = $this->db->insert('tbl_set_price',$row);
                 }
                 $price_rule=[];
             }
             $this->db->where(['p_id' => $product,'shop_id'=> $shop_id]);
              $this->db->delete('tbl_product_discount');
             foreach ($_POST['pb_quantity'] as $kt => $qty) {
                 $discount_set_data[] = ['shop_id' => $shop_id,"p_id" => $product, "qty" => $qty,  "discount_type"=>$this->Home_model->GetDiscountTypeId($this->input->post('price_type')), "discount" => $_POST['pb_quantity_price'][$kt],"set_id"=>$tbl_set_id];
             }

         }

         foreach ($discount_set_data as $row) {
            $save3 = $this->db->insert('tbl_product_discount', $row);
         }

             $total_jobs = $this->db->select('*')->from('jobs')->count_all_results();
             $delay = $total_jobs+20;
             // dd('getting jobs');
             // $job = (new SaveDiscountSets($tbl_set_id,$shop))->delay(Carbon::now()->addSeconds($delay));
             // dispatch($job);
             $send_data['shop']=$shop;
             $send_data["setId"]=$tbl_set_id;
             //$this->ProcessDiscountSet($shop,$tbl_set_id);
              $curl_url=base_url().'jobs/discountset_job';

             $returndata= $this->CurlData($send_data, $curl_url);
             //print_r($returndata);
             //exit;
             if($returndata){
             $responsedata = ["code" => 200, "msg" => "Discount Sync Request Added in queue"];
             echo json_encode($responsedata);
              }else{
                $responsedata = ["code" => 200, "msg" => "Error! Try again."];
                echo json_encode($responsedata);
              }
           }else{
             echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
           }
        }else{
           $this->load->view('errors/html/error_404');
        }

     }

     public function editGroup()
     {
       if ($_GET['shop']!='') {
          $shop = $_GET['shop'];
          $set_id = $this->input->get('set_id');
          $shop_id = $this->Home_model->GetShopId($shop);
          if($shop_id != ''){
            $data = array();
            $product = array();
            $data['d']                = $this->Home_model->getPriceset();
            $data['getGridName']      = $this->Home_model->getGridName($shop_id,$set_id);
            $data['d_prices']         = $this->Home_model->getPricesetName($shop_id,$set_id);
            $data['dis_type']         = $this->Home_model->discountType($shop_id,$set_id);
            $data['product_ids']      = $this->Home_model->getProductIdsName($shop_id,$set_id);
            $data['previousCount']    = $this->Home_model->discountSetCount($shop_id,$set_id);
            $data['groupName']        = $this->Home_model->discountgroupName($shop_id,$set_id);
            $data['set_price']        = $this->Home_model->set_price($shop_id,$data['product_ids'],$set_id);
            $product[]                = $this->Home_model->productDetail($shop_id,$data['product_ids'],$set_id);
            $data['product']          = $product[0];
            // dd($data);
            $this->load->load_admin('editGroupSample', $data);
          }
        }
     }

     public function UpdateData()
  {
    // dd($_POST);
     if ($_GET['shop']!='') {
        $shop = $_GET['shop'];
        $set_id              = $this->input->get('set_id');
        $shop_id = $this->Home_model->GetShopId($shop);
        if($shop_id != ''){
          $custom_display    = $this->input->post('custom_display');
          $name              = $this->input->post('name');
          $selected_products = $this->input->post('selected_products');
          $pb_quantity_price = $this->input->post('pb_quantity_price');
          $shopAccess = getShop_accessToken_byShop($_GET['shop']);
          $this->load->library('Shopify', $shopAccess);
          $discount_set_array=["set_name"=>$name,"shop_id"=>$shop_id];
          $Update_discount_set_array=["set_name"=>$name,];
          //insert data to table .get id of last increamented row
          $tbl_set_id = 0;

          // get the record that you want to update
          $this->db->where(['shop_id' => $shop_id,'id'=>$set_id]);
          $query = $this->db->get('tbl_discount_set');

          // getting the Id
          $result = $query->result_array();
          $tbl_set_id = $result[0]['id'];

          // updating the record
          $this->db->where(['shop_id' => $shop_id,'id'=>$set_id]);
          $this->db->update('tbl_discount_set',$Update_discount_set_array);

          $tblgrid          = array();
          $details=array();

          foreach ($selected_products as $ky => $product) {
             $precount = $this->db->select('*')->where('p_id', $product)->where('shop_id', $shop_id)->from('tbl_product_details')->count_all_results();
             $tblgrid[] = ["p_id" => $product, "grid_style" => $custom_display,"set_id"=>$tbl_set_id,'shop_id'=>$shop_id];
             if($precount <=0){
               $details[] =['shop_id'=>$shop_id,"p_id" => $product,'image'=>$this->input->post($product.'image'),'price'=>$this->input->post($product.'price'),'title'=>$this->input->post($product.'title') ];
             }
         }


         $this->db->where(['shop_id' => $shop_id,'set_id'=>$set_id]);
         $save3 = $this->db->delete('tbl_product_grid') ;
         foreach ($tblgrid as $row) {
             if($save3)
             {
               $save4 = $this->db->insert('tbl_product_grid', $row);
             }
         }

        if(count($details) >0){
          $this->db->where(['shop_id' => $shop_id]);
           $save5 = $this->db->delete('tbl_product_details') ;
          foreach ($details as $row) {
             if($save5)
             {
               $save6 = $this->db->insert('tbl_product_details', $row);
             }
          }
        }

      $discount_set_data = array();


      $this->db->where(['shop_id' => $shop_id,'id'=>$set_id]);
      $save7 = $this->db->delete('tbl_set_price');
      foreach ($selected_products as $ky => $product) {
          foreach ($_POST[$product] as $key => $variant) {
              foreach ($_POST['pb_quantity'] as $qtykey => $qty) {
                  $price_rule[] = array(
                     'p_id'           => $product,
                     'variant_id'     => $variant,
                     'qty'            => $qty,
                     'discount_price' => $_POST['pb_quantity_price'][$qtykey],
                     'discount_type'  => $this->Home_model->GetDiscountTypeId($this->input->post('price_type')),
                     'shop_id'        => $shop_id,
                     "set_id"         => $tbl_set_id
                  );
              }

              foreach ($price_rule as $row) {
                  if($save7)
                  {
                    $save8 = $this->db->insert('tbl_set_price', $row);
                  }
              }
              $price_rule=[];
          }
          $this->db->where(['p_id', $product,'shop_id', $shop_id]);
          $this->db->delete('tbl_product_discount');
          foreach ($_POST['pb_quantity'] as $kt => $qty) {
              $discount_set_data[] = ['shop_id' => $shop_id,"p_id" => $product, "qty" => $qty,  "discount_type"=>$this->Home_model->GetDiscountTypeId($this->input->post('price_type')), "discount" => $_POST['pb_quantity_price'][$kt],"set_id"=>$tbl_set_id];
          }

      }

      $this->db->where(['shop_id' => $shop_id,'set_id'=>$set_id]);
       $save3 = $this->db->delete('tbl_product_discount');
      foreach ($discount_set_data as $row) {
        $this->db->where(['shop_id' => $shop_id,'set_id'=>$set_id]);
         $save3 = $this->db->insert('tbl_product_discount', $row);
      }
        // dd($save3)
          $total_jobs = $this->db->select('*')->from('jobs')->count_all_results();
          $delay = $total_jobs+20;
          // dd('getting jobs');
          // $job = (new SaveDiscountSets($tbl_set_id,$shop))->delay(Carbon::now()->addSeconds($delay));
          // dispatch($job);
          $send_data['shop']=$shop;
          $send_data["setId"]=$tbl_set_id;
          //$this->ProcessDiscountSet($shop,$tbl_set_id);
           $curl_url=base_url().'jobs/editdiscountset_job';

          $returndata= $this->CurlData($send_data, $curl_url);
          if($returndata){
          $responsedata = ["code" => 200, "msg" => "Now added in queue"];
          echo json_encode($responsedata);
           }else{
             $responsedata = ["code" => 200, "msg" => "Error! Try again."];
             echo json_encode($responsedata);
           }
        }else{
          echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
        }
     }else{
        $this->load->view('errors/html/error_404');
     }

  }
     public function CurlData($data,$url)
     {

       $post_str ='';
       foreach($data as $key=>$val) {
       $post_str .= $key.'='.urlencode($val).'&';
       }

       $post_str = substr($post_str, 0, -1);
       //Initialize cURL and connect to the remote URL
       $ch = curl_init();
       curl_setopt($ch,CURLOPT_URL,$url);
       //Instruct cURL to do a regular HTTPS POST
       curl_setopt($ch, CURLOPT_POST, TRUE);
       //Specify the data which is to be posted
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
       //Tell curl_exec to return the response output as a string
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       // Execute the cURL response
       // dd($ch);
       $response = curl_exec($ch);
       //Close cURL session and file
       $xml= array();
       if ($response === FALSE) {
         $return= FALSE;
       } else {
       $return= $response;
       }
       curl_close($ch);
       return $return;
     }

     public function DiscountSet_process(){
       //echo json_encode(["test"=>100]);
      $post=file_get_contents('php://input');
      $_POST=json_decode($post,true);
       $shop=$_POST['shop'];
       $set_id=$_POST['setID'];
      if ($shop!='') {
        $shop_id = $this->Home_model->GetShopId($shop);
        $tbl_set_data = $this->db->select('p_id')->where('shop_id',$shop_id)->where('set_id',$set_id)->group_by('p_id')->get('tbl_product_discount')->result();
        $setProducts=array();
        foreach ($tbl_set_data as $set) {
          $send_data['setId']=$set_id;
          $send_data['shop']=$shop;
          $send_data['productid']=$set->p_id;
          $curl_url= base_url().'jobs/checkmetafields_job';
          $returndata= $this->CurlData($send_data,$curl_url);
        }
      }
     }

     public function process_single_product(){
       $year = getYear();
       $post=file_get_contents('php://input');
       $this->db->insert('test',['data'=>$post]);
       $_POST=json_decode($post,true);
              $shop=$_POST['shop'];
              $set_id=$_POST['setID'];
              $productid=$_POST['productid'];
              if ($shop!='') {
              $shop_id = $this->Home_model->GetShopId($shop);
              $shopAccess = getShop_accessToken_byShop($shop);
              $this->load->library('Shopify', $shopAccess);
              $productMeta = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/products/'.$productid.'/metafields.json'], TRUE);
            // print_r($productMeta);
          //  exit;
              $AllProducuct = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/products/'.$productid.'.json'], TRUE);
              $qty_data = $this->db->where(["p_id"=>$productid,'shop_id'=>$shop_id,'set_id'=>$set_id])->get('tbl_product_discount')->result();
             // print_r($AllProducuct->product->variants);
             //  exit;
              $productVariants = $this->Home_model->productVariants($productid);
                foreach ($productVariants as $variant) {
                  $variant_data=$this->get_current_variants($AllProducuct->product->variants,$variant->variant_id);
                  $variant_price = $variant_data->price;
                  //print_r($variant_price);
                  $chk           = $this->FindMetafields($productMeta->metafields, $variant->variant_id, '1');
                  if ($chk == false) {
                      sleep(1);
                      $mtSingle =["metafield"=>["namespace"  => "csp" . $variant->variant_id,"key" => "default~1","value"=> "%,1,,2,,0","value_type" => "string"]];
                      $saveMeta = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/products/' . $productid . '/metafields.json', 'DATA' =>$mtSingle], TRUE);
                  }
                  foreach ($qty_data as $qty) {
                        sleep(1);
                        if (count($productMeta->metafields) > 0) {
                          $already = $this->FindMetafields($productMeta->metafields, $variant->variant_id, $qty->qty);
                            if ($already) {
                               $this->shopify->call(['METHOD' => 'DELETE', 'URL' => '/admin/metafields/' . $already->id . '.json'], TRUE);
                            }
                        }
                        $metafield = $this->MetaFieldsArray($variant->variant_id, $qty->qty, $qty->discount_type, $variant_price);
                        $PostMeta = array("metafield" => $this->MetaFieldsArray($variant->variant_id, $qty->qty, $qty->discount_type, $variant_price));
                        $saveMeta = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/products/' . $productid . '/metafields.json', 'DATA' =>$PostMeta], TRUE);
                        // dd($saveMeta);
                  }
                }
            }
     }
     public function create_product_metafields(){

     }


     public function get_current_variants($all_variant,$single_var){
       foreach ($all_variant as $single) {
         if($single->id==$single_var){

           return $single;
         }
       }

     }


     public function ProcessDiscountSet($shop, $set_id)
     {
        if ($shop!='') {
           $shopAccess = getShop_accessToken_byShop($shop);
           $this->load->library('Shopify', $shopAccess);
           $tbl_set_data = $this->db->select('*')->get('tbl_product_discount')->result();

           $setProducts=array();
           foreach ($tbl_set_data as $set) {
               if($set->set_id == $set_id){
                 if(!in_array($set->p_id,$setProducts)){
                     $setProducts[]=$set->p_id;
                 }
               }
           }
       foreach ($setProducts as $product) {
           $productMeta = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/products/'.$product.'/metafields.json'], TRUE);
           $qty_data = $this->db->where(["p_id"=>$product])->get('tbl_product_discount')->result();
           $productVariants = $this->Home_model->productVariants($product);
           foreach ($productVariants as $variant) {
                   $variant_data =  $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/products/'.$product.'/variants/' . $variant->variant_id . '.json'], TRUE);
                   $variant_price = $variant_data->variant->price;
                   $chk           = $this->FindMetafields($productMeta->metafields, $variant->variant_id, '1');
                   if ($chk == false) {
                       $mtSingle =["metafield"=>["namespace"  => "csp" . $variant->variant_id,"key" => "default~1","value"=> "%,1,,2,,0","value_type" => "string"]];
                       $saveMeta = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/products/' . $product . '/metafields.json', 'DATA' =>$mtSingle], TRUE);
                   }

               foreach ($qty_data as $qty) {
                     if (count($productMeta->metafields) > 0) {
                       $already = $this->FindMetafields($productMeta->metafields, $variant->variant_id, $qty->qty);
                         if ($already) {
                            $this->shopify->call(['METHOD' => 'DELETE', 'URL' => '/admin/metafields/' . $already->id . '.json'], TRUE);
                         }
                     }
                     $metafield = $this->MetaFieldsArray($variant->variant_id, $qty->qty, $qty->discount_type, $variant_price);
                     $PostMeta = array("metafield" => $this->MetaFieldsArray($variant->variant_id, $qty->qty, $qty->discount_type, $variant_price));
                     $saveMeta = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/products/' . $product . '/metafields.json', 'DATA' =>$PostMeta], TRUE);
                     // dd($saveMeta);
               }
           }
       }

       $responsedata = ["code" => 200, "msg" => "Discount Sync Request Added in queue"];
       echo json_encode($responsedata);
        }else{
          $responsedata = ["code" => 200, "msg" => "Error! Try again."];
          echo json_encode($responsedata);
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
      $prices =   $this->Home_model->productPrizesObjFormat($variant,$qty);
      // dd($prices);
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



   public function GetProductDiscountSet()
   {
      if($_GET['p_id'] != '' && $_GET['shop'] != '')
      {
         $p_id = $this->input->post('p_id');
         // dd($p_id);
         $result = $this->Home_model->GetProductDiscountSet($p_id);
         if (count($result) > 0) {
            $data = $result;
            foreach ($data as $key => $dat) {
               $dat->dis_type = $this->GetDiscuntType($dat->discount_type)->price_type;
            }
            $responsedata = array("code" => 200, "msg" => "Data Found", "data" => $data);
         } else {
            $responsedata = array("code" => 100, "msg" => "Data not Found");
         }
         echo json_encode($responsedata);
      }
   }

   public function GetDiscuntType($type)
   {
      $this->db->select('*');
      $this->db->where(['type' => $type]);
      $query = $this->db->get('price_types')->row();
      return $query;
   }

   public function CheckExistense($variant)
   {
      return DB::table('tbl_set_price')->where('variant_id', $variant)->first();
   }

   public function GetDiscountSetProducts()
   {

      if ($_GET['shop']!='') {
         $set_id = $this->input->post('set_id');
         $shop = $_GET['shop'];
         $shop_id = $this->Home_model->GetShopId($shop);
         $year = getYear();
         $shopAccess = getShop_accessToken_byShop($shop);
         $this->load->library('Shopify', $shopAccess);
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
         $return.='<div>';
         $return.='<table style="border:1px solid black;border-collapse:collapse;"><tr><th style="border:1px solid black;">Product Image</th><th style="border:1px solid black;">Title</th><th style="border:1px solid black;">View</th></tr>';
         if($shop_id != ''){
           $setProducts = $this->Home_model->setproducts($set_id);
             foreach ($setProducts as $setProduct) {
            $productMeta = $this->Home_model->productInfo($shop_id,$setProduct->p_id);
            // dd($productMeta);
            $img = $productMeta->image !== '' ? $productMeta->image : '' ;
            $return.='<tr>
                        <td style="border:1px solid black;text-align: center;">
                            <img style="height: 50px;" src="'.$img.'" >
                        </td>
                        <td style="border:1px solid black;text-align: center;">'.$productMeta->title.'</td>
                        <td style="border:1px solid black;text-align: center;">
                          <div style="display:inline-flex">
                            <a target="_blank"   href="https://'.$shop.'/admin/products/'.$setProduct->p_id.'"  class="btnclass">Admin</button></a>
                          </div>
                        </td>
                  </tr>';
         }
         // <a  target="_blank"  href="https://'.$shop.'/products/'.$productMeta->product->handle.'" class="btnclass" style="margin-left: 2%;background:#fe9d52;border:#fe9d52;">StoreFront</a>
          $return.='</table>';
            $return.='</div>';

            echo json_encode(array('code' => 200,'shop'=>$shop,'shop_id'=>$shop_id, 'msg'=> $return ));
         }else{
            echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
         }
      }else{
         $this->load->view('errors/html/error_404');
      }


   }

   public function GetProductPrice($productData)
   {
       return $productData->product->variants[0]->price;
   }

   public function GetShopCurrency($shop_data)
   {
       return $shop_data->shop->currency;
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

   public function GetProductDiscount()
   {

      $p_id = $this->input->get('p_id');
      $shop = $this->input->get('shop');
      if($p_id != '' && $shop != '')
      {
        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);
        $result = $this->db->where('p_id', $p_id)->get('tbl_product_discount')->result();
         if ($result) {
           $shop_data        = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/shop.json']);
           $productData      = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/products/' . $p_id . '.json']);
           $currency         = $this->GetShopCurrency($shop_data);
           $product_price    = $this->GetProductPrice($productData);
           $data['is_qb_enabled']=true;
           $grid = $this->db->where('p_id', $p_id)->order_by('id', 'desc')->get('tbl_product_grid')->row();
           $data['grid']=$this->CreateDiscountTableHtml($grid->grid_style,$result, $currency, $product_price);
           $data['style']='';
           echo json_encode($data);
      } else {
           $data['message']='No Data Found';
           echo json_encode($data);
      }

      }

   }

   public function GetCartPrices()
   {
         $shopAccess = getShop_accessToken_byShop($shop);
         $this->load->library('Shopify', $shopAccess);
         header('Content-Type: application/json');
         $add=array();
         $update=array();
         $delete=array();
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


   public function customer_pricing() //???????
   {
   $contents = View::make('getprices');
   $response = Response::make($contents);
   $response->header('Content-Type', 'application/javascript');
   return $response;
   return View::make('getprices');
   }

   public function csp_install_check()
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


   public function get_qb_discount_banner_data()
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

   public function CreateDraftOrder()
   {

       $shop = $this->input->post('shop');
       $cart_data = $this->input->post('cart_data');
       $cart_data = json_decode($cart_data);
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
       $draft_order_status=$this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/draft_orders.json', 'DATA' => $draft_order]);
       redirect($draft_order_status->body->draft_order->invoice_url);

   }
//installation tab
public function InstallationPage()
{
  if($_GET['shop']!='') {
  $shop = $this->input->get('shop');
  $shop_id = $this->Home_model->GetShopId($shop);
    if($shop_id != ''){
      $data = array();
      $data['install'] = $this->Home_model->getRequestData($shop_id);

      $this->load->load_admin('installationPage', $data);
    }else{
       echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
    }
  }else{
    $this->load->view('errors/html/error_404');
  }

}

public function installationRequest()
{
  if ($_GET['shop']!='') {
     $shop = $_GET['shop'];
     $shop_id = $this->Home_model->GetShopId($shop);
     if($shop_id != ''){
        $data = array();
        $year   = getYear();
        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);
        $themes = $this->shopify->call(['METHOD' => 'GET', 'URL' => 'admin/api/'.$year.'/themes.json'], TRUE);

        if (count($themes->themes) > 0) {
          foreach ($themes->themes as $theme) {
              $name[] = $theme->name;
              $id[]   = $theme->id;
              $role[] = $theme->role;
            }
          }
          for($i = 0; $i<count($name); $i++)
          {
            $data['themes'][$i]['name'] = $name[$i];
            $data['themes'][$i]['id']   = $id[$i];
            $data['themes'][$i]['role'] = $role[$i];
          }
          $install = $this->Home_model->getRequestData($shop_id);
          $data['install'] = $install;
          $data['req_send'] = !empty($install) ? TRUE : FALSE;
          $this->load->load_admin('installationRequest', $data);
     }else{
        echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
     }
  }else{
     $this->load->view('errors/html/error_404');
  }
}

public function createRequest()
{
  // dd($_POST);
  if ($_GET['shop']!='') {
     $shop = $_GET['shop'];
     $shop_id = $this->Home_model->GetShopId($shop);
     if($shop_id != ''){
        $data = array();
        $mystring = $this->input->post('theme_name');
        $word = ' (Activated)';

        if(strpos($mystring, $word) !== false){
            $mystring = str_replace($word,"",$mystring);
        }

        $data['theme_id']     = $this->input->post('theme_id');
        $data['theme_name']   = $mystring;
        $data['message']      = $this->input->post('message');
        $data['cust_email']   = $this->input->post('email');
        $data['send_on']      = date("Y-m-d h:i:s");
        $data['status']       = 1;
        $data['shop_id']      = $shop_id;
        $data['shop']         = $shop;

         $save1 = $this->db->insert('installation', $data);
         if($save1)
         {
           echo json_encode(array('code'=>200,'title'=> "Your request is successfully received!",'msg'=>'Our expert team will contact you soon! Till now please create staff to complete the procedure.','shop'=>$shop,'shop_id'=>$shop_id));
         }
         else {
           echo json_encode(array('code'=>200,'title'=> "Your request is not received!",'msg'=>'Please Try Again!','shop'=>$shop,'shop_id'=>$shop_id));
         }
        // $this->load->load_admin('', $data);
     }else{
        echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
     }
  }else{
     $this->load->view('errors/html/error_404');
  }
}

public function cancelRequest()
{
  // dd($_POST);
  if ($_GET['shop']!='') {
     $shop = $_GET['shop'];
     $shop_id = $this->Home_model->GetShopId($shop);
     if($shop_id != ''){
        $data = array();
        $data['theme_id']     = $this->input->post('themes');
        $data['message']      = $this->input->post('message');
        $data['cust_email']   = $this->input->post('email');
        $data['send_on']      = date("Y-m-d h:i:s");
        $data['status']       = 0;
        $data['shop_id']      = $shop_id;
        $data['shop']         = $shop;

         $this->db->where('shop_id', $shop_id);
         $save1 = $this->db->update('installation',$data);
         if($save1)
         {
           echo json_encode(array('code'=>200,'title'=> "Your request is cancelled successfully",'msg'=>'If you want to create a new request you are free to go.','shop'=>$shop,'shop_id'=>$shop_id));
         }
         else {
           echo json_encode(array('code'=>200,'title'=> "Your request is not cancelled!",'msg'=>'Please Try Again!','shop'=>$shop,'shop_id'=>$shop_id));
         }
        // $this->load->load_admin('', $data);
     }else{
        echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
     }
  }else{
     $this->load->view('errors/html/error_404');
  }
}

public function generalSetting()
{

  if ($_GET['shop']!='') {
     $shop = $_GET['shop'];
     $shop_id = $this->Home_model->GetShopId($shop);
     if($shop_id != ''){
        $data = array();
        $data['discount_method']     = $this->Home_model->discount_method($shop_id);
        $this->load->load_admin('generalSetting', $data);
     }else{
        echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
     }
  }else{
     $this->load->view('errors/html/error_404');
  }

}

public function discountMethod()
{
  // dd($_POST);
  if ($_GET['shop']!='') {
     $shop = $_GET['shop'];
     $shop_id = $this->Home_model->GetShopId($shop);
     if($shop_id != ''){
        $data = array();
        $data['discount_method']     = $this->input->post('method');

         $this->db->where('id', $shop_id);
         $save1 = $this->db->update('shopify_stores',$data);
         if($save1)
         {
           echo json_encode(array('code'=>200,'title'=> "Your setting is saved!",'msg'=>'Your setting is saved!','shop'=>$shop,'shop_id'=>$shop_id));
         }
         else {
           echo json_encode(array('code'=>200,'title'=> "Failed! Please Try Again.",'msg'=>'Please Try Again!','shop'=>$shop,'shop_id'=>$shop_id));
         }

     }else{
        echo json_encode(array('code'=>100,'msg'=>'Shop does not exists!','shop'=>$shop,'shop_id'=>$shop_id));
     }
  }else{
     $this->load->view('errors/html/error_404');
  }
}

public function accountPlan()
{
  $shop = $this->input->get('shop');

  $this->load->load_admin('accountPlan');

}

public function feedback()
{
  $this->load->load_admin('feedback');
}

public function saveFeedback()
{
  if ($_GET['shop']!='') {
  $shop = $_GET['shop'];
  $shop_id = $this->Home_model->GetShopId($shop);
  if($shop_id != ''){
     $data = array(
       'shop_id' => $shop_id,
       'name'    => $this->input->post('name', true),
       'email'   => $this->input->post('email', true),
       'mgs'     => $this->input->post('message', true),
       'created_at' => date('Y-m-d h:i:s'),
     );
     $save = $this->Home_model->saveFeedback($data);

     if($save)
     {
       echo json_encode(array( 'code' => 200, 'mgs' => 'Your feedback has been send. We will contact you soon.'));
     }else {
       echo json_encode(array( 'code' => 100, 'mgs' => '<b>Error!</b> Please try again!'));
     }
   }else{
   $data = array( 'code' => 403, 'mgs' => 'Shop id is not set');
   echo json_encode($data);
     }
   }else{
     $data = array( 'code' => 403, 'mgs' => 'Page not found');
     echo json_encode($data);
   }
}










}//end of class
