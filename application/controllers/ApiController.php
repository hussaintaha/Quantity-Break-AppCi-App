<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

include  APPPATH.'controllers/simple_html_dom_node.php';
class ApiController extends CI_Controller {
  public function __construct() {
    parent::__construct(); //Do your magic here
    $this->load->database();
    $this->load->helper('url');
    $this->load->helper('global_helper');
    $this->load->helper('date');
    $this->load->model('Home_model');
    // $this->load->library('input');
  }

  public function customer_pricing() {
    $response = $this->load->view('vw-csp/customer_pricing', '', true);
    $this->output
        ->set_status_header(200)
        ->set_content_type('application/javascript')
        ->set_output($response);
  }

  public function csp_install_check() {
    $response = 'window.BOLD = window.BOLD || {};
window.BOLD.csp = window.BOLD.csp || {};
window.BOLD.csp.is_installed = true;';
    $this->output
        ->set_status_header(200)
        ->set_content_type('application/javascript')
        ->set_output($response);
  }

  public function cspqb() {
    $response = $this->load->view('vw-csp/cspqb', '', true);
    $this->output
        ->set_status_header(200)
        ->set_content_type('application/javascript')
        ->set_output($response);
  }

  public function checkScripts($shop) {

    $year   = getYear();
    $shopAccess = getShop_accessToken_byShop($shop);
    $this->load->library('Shopify', $shopAccess);
    $script_tags      = $this->shopify->call(['METHOD' => 'GET', 'URL' => 'admin/api/'.$year.'/script_tags.json'], TRUE);

    $script_tags      = $script_tags->script_tags;

    $scriptSrc1        = base_url('customer_pricing.php');
    $scriptSrc2        = base_url('csp_install_check.js');
    $scriptSrc3        = base_url('js/cspqb.js');

    $isAlreadyAdded1     = false;
    $isAlreadyAdded2     = false;
    $isAlreadyAdded3     = false;
    if (empty($script_tags)) {
      $isAlreadyAdded1     = false;
      $isAlreadyAdded2     = false;
      $isAlreadyAdded3     = false;
    } else {
      foreach ($script_tags as $script_tag) {
        if ($script_tag->src == $scriptSrc1) {
          $isAlreadyAdded1     = true;
        } elseif ($script_tag->src == $scriptSrc2) {
          $isAlreadyAdded2     = true;
        } elseif ($script_tag->src == $scriptSrc3) {
          $isAlreadyAdded3     = true;
        }
      }
    }

    if (!$isAlreadyAdded1) {
      $script_data1 = array(
        'script_tag' => array(
          'event'         => 'onload',
          'src'           => $scriptSrc1,
          'display_scope' => 'all'
        )
      );
      $script_tag1 = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/api/'.$year.'/script_tags.json ', 'DATA' => $script_data1], TRUE);
    }

    sleep(1);

    if (!$isAlreadyAdded2) {
      $script_data2 = array(
        'script_tag' => array(
          'event'         => 'onload',
          'src'           => $scriptSrc2,
          'display_scope' => 'all'
        )
      );
      $script_tag2 = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/api/'.$year.'/script_tags.json ', 'DATA' => $script_data2], TRUE);
    }

    if (!$isAlreadyAdded3) {
      $script_data3 = array(
        'script_tag' => array(
          'event'         => 'onload',
          'src'           => $scriptSrc3,
          'display_scope' => 'all'
        )
      );
      $script_tag3 = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/api/'.$year.'/script_tags.json ', 'DATA' => $script_data3], TRUE);
    }



  }

  // public function removeScript($shop) {
  //   $year   = getYear();
  //   $shopAccess = getShop_accessToken_byShop($shop);
  //   $this->load->library('Shopify', $shopAccess);
  //   $script_tags      = $this->shopify->call(['METHOD' => 'GET', 'URL' => 'admin/api/'.$year.'/script_tags.json'], TRUE);
  //   $script_tags      = $script_tags->script_tags;
  //
  //   // $scriptSrc        = base_url('customer_pricing.php');
  //   // $scriptSrc        = base_url('csp_install_check.js');
  //   $scriptSrc        = base_url('js/cspqb.js');
  //   foreach ($script_tags as $script_tag) {
  //     if ($script_tag->src == $scriptSrc) {
  //       $script_tag_delete = $this->shopify->call(['METHOD' => 'DELETE', 'URL' => 'admin/api/'.$year.'/script_tags/'.$script_tag->id.'.json'], TRUE);
  //       echo "<pre>";
  //       print_r($script_tag_delete);
  //       exit;
  //     }
  //   }
  // }

  public function install() {
    if(isset($_GET['shop']) || $_GET['shop'] !== '') {
      // $this->checkScripts($_GET['shop']);
      $this->GetActiveThemeName($_GET['shop']);
    } else {
      echo "something Wrong while getting theme info";
    }
  }

  public function GetActiveThemeName($shop) {
    //base url
    // $base = 'https://'.$shop.'/';
    //
    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    // curl_setopt($curl, CURLOPT_HEADER, false);
    // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($curl, CURLOPT_URL, $base);
    // curl_setopt($curl, CURLOPT_REFERER, $base);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    // curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
    // $str = curl_exec($curl);
    // curl_close($curl);
    // // Create a DOM object
    // $html_base = new simple_html_dom();
    // // Load HTML from a string
    // $html_base->load($str);
    //
    // //get all category links
    // foreach($html_base->find('script') as $element) {
    //   if(strpos($element->innertext, 'Shopify.theme') !== false) {
    //     $html_base1 = $element->innertext.PHP_EOL;
    //     break;
    //   }
    // }
    //
    // $html_base->clear();
    // unset($html_base);
    // $htmlExplo = explode(';',$html_base1);
    // foreach ($htmlExplo as $key => $value) {
    //   if(stripos($value, 'Shopify.theme =') !== false) {
    //     $expl = explode("=",$value);
    //     $string = json_decode($expl[1]);
    //     $themeName = $string->name;
    //   }
    // }

    $year   = getYear();
    $shopAccess = getShop_accessToken_byShop($shop);
    $this->load->library('Shopify', $shopAccess);
    $themes = $this->shopify->call(['METHOD' => 'GET', 'URL' => 'admin/api/'.$year.'/themes.json'], TRUE);

    if (count($themes->themes) > 0) {
      foreach ($themes->themes as $theme) {
        if ($theme->role == "main") {
          $themeId   = $theme->id;
          break;
        }
      }
    }

    $settings_schema = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/'.$themeId.'/assets.json?asset[key]=config/settings_schema.json'], TRUE);
    $settings_schema_value = $settings_schema->asset->value;

    $settings_schema_array = json_decode($settings_schema_value);

    $themeName = '';
    foreach ($settings_schema_array as $key => $object) {
      if (isset($object->theme_name)) {
        $themeName = $object->theme_name;
      }
    }

    $this->themeInstallationJob($shop, $themeId, $themeName);
    // $this->themeInstallation($shop,$themeName);
  }

  public function themeInstallationJob($shop, $themeId, $themeName) {
    if (!$themeName) {
      echo json_encode(['code' => 100, 'msg'  => 'Installation Failed. Please Try Manual installation!']);
      exit;
    }

    $send_data['shop'] = $shop;
    $send_data['themeId'] = $themeId;
    $send_data['themeName'] = $themeName;
    $curl_url = base_url().'jobs/includesnippets_job';
    $response = $this->CurlData($send_data, $curl_url);
    // if ($response) {
      $responsedata = ["code" => 200, "msg" => "Snippets Added in queue"];
      echo json_encode($responsedata);
    // }
  }

  public function CurlData($data,$url) {
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
      $return = FALSE;
    } else {
      $return = $response;
    }
    curl_close($ch);
    return $return;
  }

  public function themeInstallation() {
    $post  = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $shop      = $_POST['shop'];
    $themeId   = $_POST['themeId'];
    $themeName = $_POST['themeName'];

    $this->checkScripts($shop);
    exit;

    $year   = getYear();
    $shopAccess = getShop_accessToken_byShop($shop);
    $this->load->library('Shopify', $shopAccess);

    $qbrkCommon        = $this->qbrkCommon($themeId, $shop);
    $qbrkProduct       = $this->qbrkProduct($themeId, $shop);
    sleep(1);
    $qbrkVariant       = $this->qbrkVariant($themeId, $shop);
    $qbrkcart          = $this->qbrkcart($themeId, $shop);
    sleep(1);
    $qbrkCartItem      = $this->qbrkCartItem($themeId, $shop);
    $qbrkCSPMetafields = $this->qbrkCSPMetafields($themeId, $shop);
    sleep(1);

    switch ($themeName) {
      case "Debut":
              try {
                //check the theme liquid id present or not
                $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
                if($getThemeLiquid !== NULL)
                {
                  $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
                }

                $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
                if($getProductLiquid !== NULL)
                {
                  $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
                }

                $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
                if($getProductTempLiquid !== NULL)
                {
                  $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
                  $qbrkVariantDivThemeInstall = $this->qbrkVariantDivTheme($themeId, $shop);
                }

                $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
                if($getCartLiquid !== NULL)
                {
                  $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
                }

                try{

                  $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
                  if($getCartTempLiquid !== NULL)
                  {
                    $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
                  }
                }catch (\Exception $e) {
                   if($e)
                   {
                    $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
                  }
                }


                $data = array(
                  'code' => 200,
                  'mgs'  => 'Installation successful.'
                );
                echo  json_encode($data);
              } catch (\Exception $ex) {
                // dd($e);
                // echo $e;
                  if($ex)
                  {
                    $data = array(
                      'code' => 100,
                      'mgs'  => 'Installation Failed. Please Try Again!'
                    );
                    echo  json_encode($data);
                  }
              }
      break;

      case "Venue":
              try {
                //check the theme liquid id present or not
                $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
                if($getThemeLiquid !== NULL)
                {
                  $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
                }

                $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
                if($getProductLiquid !== NULL)
                {
                  $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
                }

                $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
                if($getProductTempLiquid !== NULL)
                {
                  $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
                  $qbrkVariantDivThemeInstall = $this->qbrkVariantDivTheme($themeId, $shop);
                }

                $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
                if($getCartLiquid !== NULL)
                {
                  $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
                }

                try{

                  $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
                  if($getCartTempLiquid !== NULL)
                  {
                    $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
                  }
                }catch (\Exception $e) {
                   if($e)
                   {
                    $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
                  }
                }


                $data = array(
                  'code' => 200,
                  'mgs'  => 'Installation successful.'
                );
                echo  json_encode($data);
              } catch (\Exception $ex) {
                // dd($e);
                // echo $e;
                  if($ex)
                  {
                    $data = array(
                      'code' => 100,
                      'mgs'  => 'Installation Failed. Please Try Again!'
                    );
                    echo  json_encode($data);
                  }
              }
      break;

      case "Brooklyn":
          try {
            //check the theme liquid id present or not
            $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
            if($getThemeLiquid !== NULL)
            {
              $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
            }

            $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
            if($getProductLiquid !== NULL)
            {
              $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
            }

            $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
            if($getProductTempLiquid !== NULL)
            {
              $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
              $qbrkVariantDivThemeInstall = $this->qbrkVariantDivBrooklynTheme($themeId, $shop);
            }

            $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
            if($getCartLiquid !== NULL)
            {
              $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
            }

            try{

              $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
              if($getCartTempLiquid !== NULL)
              {
                $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
              }
            }catch (\Exception $e) {
               if($e)
               {
                $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
              }
            }


            $data = array(
              'code' => 200,
              'mgs'  => 'Installation successful.'
            );
            echo  json_encode($data);
          } catch (\Exception $ex) {
            // dd($e);
            // echo $e;
              if($ex)
              {
                $data = array(
                  'code' => 100,
                  'mgs'  => 'Installation Failed. Please Try Again!'
                );
                echo  json_encode($data);
              }
          }
      break;

      case "Supply":
          try {
            //check the theme liquid id present or not
            $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
            if($getThemeLiquid !== NULL)
            {
              $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
            }

            $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
            if($getProductLiquid !== NULL)
            {
              $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
            }

            $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
            if($getProductTempLiquid !== NULL)
            {
              $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
              $qbrkVariantDivThemeInstall = $this->qbrkVariantDivSupplyTheme($themeId, $shop);
            }

            $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
            if($getCartLiquid !== NULL)
            {
              $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
            }

            try{

              $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
              if($getCartTempLiquid !== NULL)
              {
                $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
              }
            }catch (\Exception $e) {
               if($e)
               {
                $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
              }
            }


            $data = array(
              'code' => 200,
              'mgs'  => 'Installation successful.'
            );
            echo  json_encode($data);
          } catch (\Exception $ex) {
            // dd($e);
            // echo $e;
              if($ex)
              {
                $data = array(
                  'code' => 100,
                  'mgs'  => 'Installation Failed. Please Try Again!'
                );
                echo  json_encode($data);
              }
          }
      break;

      case "Boundless":
          try {
            //check the theme liquid id present or not
            $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
            if($getThemeLiquid !== NULL)
            {
              $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
            }

            $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
            if($getProductLiquid !== NULL)
            {
              $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
            }

            $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
            if($getProductTempLiquid !== NULL)
            {
              $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
              $qbrkVariantDivThemeInstall = $this->qbrkVariantDivBoundlessTheme($themeId, $shop);
            }

            $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
            if($getCartLiquid !== NULL)
            {
              $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
            }

            try{

              $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
              if($getCartTempLiquid !== NULL)
              {
                $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
              }
            }catch (\Exception $e) {
               if($e)
               {
                $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
              }
            }


            $data = array(
              'code' => 200,
              'mgs'  => 'Installation successful.'
            );
            echo  json_encode($data);
          } catch (\Exception $ex) {
            // dd($e);
            // echo $e;
              if($ex)
              {
                $data = array(
                  'code' => 100,
                  'mgs'  => 'Installation Failed. Please Try Again!'
                );
                echo  json_encode($data);
              }
          }
      break;

      case "Venture":
          try {
            //check the theme liquid id present or not
            $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
            if($getThemeLiquid !== NULL)
            {
              $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
            }

            $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
            if($getProductLiquid !== NULL)
            {
              $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
            }

            $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
            if($getProductTempLiquid !== NULL)
            {
              $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
              $qbrkVariantDivThemeInstall = $this->qbrkVariantDivTheme($themeId, $shop);
            }

            $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
            if($getCartLiquid !== NULL)
            {
              $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
            }

            try{

              $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
              if($getCartTempLiquid !== NULL)
              {
                $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
              }
            }catch (\Exception $e) {
               if($e)
               {
                $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
              }
            }


            $data = array(
              'code' => 200,
              'mgs'  => 'Installation successful.'
            );
            echo  json_encode($data);
          } catch (\Exception $ex) {
            // dd($e);
            // echo $e;
              if($ex)
              {
                $data = array(
                  'code' => 100,
                  'mgs'  => 'Installation Failed. Please Try Again!'
                );
                echo  json_encode($data);
              }
          }
      break;

      case "Simple":
          try {
            //check the theme liquid id present or not
            $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
            if($getThemeLiquid !== NULL)
            {
              $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
            }

            $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
            if($getProductLiquid !== NULL)
            {
              $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
            }

            $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
            if($getProductTempLiquid !== NULL)
            {
              $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
              $qbrkVariantDivThemeInstall = $this->qbrkVariantDivSimpleTheme($themeId, $shop);
            }

            $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
            if($getCartLiquid !== NULL)
            {
              $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
            }

            try{

              $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
              if($getCartTempLiquid !== NULL)
              {
                $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
              }
            }catch (\Exception $e) {
               if($e)
               {
                $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
              }
            }


            $data = array(
              'code' => 200,
              'mgs'  => 'Installation successful.'
            );
            echo  json_encode($data);
          } catch (\Exception $ex) {
            // dd($e);
            // echo $e;
              if($ex)
              {
                $data = array(
                  'code' => 100,
                  'mgs'  => 'Installation Failed. Please Try Again!'
                );
                echo  json_encode($data);
              }
          }
      break;

      case "Minimal":
          try {
            //check the theme liquid id present or not
            $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
            if($getThemeLiquid !== NULL)
            {
              $qbrkCommonInstall      = $this->qbrkCommonTheme($themeId, $shop);
            }

            $getProductLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
            if($getProductLiquid !== NULL)
            {
              $qbrkProductInstall     = $this->qbrkProductTheme($themeId, $shop);
            }

            $getProductTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
            if($getProductTempLiquid !== NULL)
            {
              $qbrkVariantInstall     = $this->qbrkVariantTheme($themeId, $shop);
              $qbrkVariantDivThemeInstall = $this->qbrkVariantDivMinimalTheme($themeId, $shop);
            }

            $getCartLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
            if($getCartLiquid !== NULL)
            {
              $qbrkcartInstall        = $this->vwqbrkCartTheme($themeId, $shop);
            }

            try{

              $getCartTempLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' .  $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
              if($getCartTempLiquid !== NULL)
              {
                $qbrkCartItemInstall    = $this->qbrkCartItemTheme($themeId, $shop);
              }
            }catch (\Exception $e) {
               if($e)
               {
                $qbrkCartItemInstall    = $this->qbrkCartItemAltTheme($themeId, $shop);
              }
            }


            $data = array(
              'code' => 200,
              'mgs'  => 'Installation successful.'
            );
            echo  json_encode($data);
          } catch (\Exception $ex) {
            // dd($e);
            // echo $e;
              if($ex)
              {
                $data = array(
                  'code' => 100,
                  'mgs'  => 'Installation Failed. Please Try Again!'
                );
                echo  json_encode($data);
              }
          }
      break;



      default:
      $data = array(
        'code' => 100,
        'mgs'  => 'Installation Failed. Please Try Manual installation!'
      );
      echo  json_encode($data);
     }
    }

   public function qbrkcart($themeId,$shop)
   {
     $year = getYear();
      $content_html_value = "<!-- vwqbrk-cart.liquid -->
      {% comment %} Last updated 2016-07-18 {% endcomment %}
      {% capture vwqbrk_cart_liquid %}
      {% comment %}
      VWQBRK-CART.LIQUID - Universal Vwqbrk Cart Updater
      This file creates liquid variables to assist in updating line items in cart.liquid.

      USED BY: Product Options, Product Builder, Recurring Orders
      REQUIRES: vwqbrk-cart-item.liquid, vwqbrk.css

      To use this file:
      * Include this file at the beginning of cart.liquid and before any quick-carts in your template
      	Example: {% include 'vwqbrk-cart' %}


      * Make the following replacements.
      	vwqbrk_cart_total_price        replaces	cart.total_price
      	vwqbrk_cart_item_count         replaces	cart.item_count

      * Follow the install instructions for your app to see where these variables need to be inserted
        (See vwqbrk-cart-item.liquid for additional installation requirements)

        PRODUCT OPTIONS
          vwqbrk_cart_item_count             replaces 	cart.item_count
          {{ vwqbrk_edit_in_cart }}          inserted	At the end of cart.liquid

        RECURRING ORDERS
          vwqbrk_cart_total_price            replaces	cart.total_price
          {{ vwqbrk_ro_cart }}               inserted	Inside the cart form where you would like the Recurring Cart widget to appear
          show_paypal			    		 inserted	Inside \"if additional_checkout_buttons\" (Becomes \"if additional_checkout_buttons and show_paypal\")

        PRODUCT BUILDER
          vwqbrk_cart_item_count             replaces 	cart.item_count

        BUY THE MEASURE
          vwqbrk_cart_item_count             replaces 	cart.item_count

      {% endcomment %}
      {% if cart %}
        {% assign vwqbrk_cart = cart %}
        {% assign vwqbrk_item_list = vwqbrk_cart.items %}
      {% elsif checkout %}
        {% assign vwqbrk_cart = checkout %}
        {% assign vwqbrk_item_list = checkout.line_items %}
      {% endif %}

      {% assign is_mixed_cart = false %}
      {% assign show_paypal = true %}
      {% assign vwqbrk_cart_total_price = 0 %}
      {% assign vwqbrk_cart_item_count =  0 %}

      {% for vwqbrk_cart_item in vwqbrk_item_list %}
              {% comment %} Apps like Persistent Cart can kill apps like options by stripping out property fields. This is a mini-failsafe to catch most instances where priced options have become visible due to property stripping {% endcomment %}
      	{% if vwqbrk_cart_item.product.type == 'OPTIONS_HIDDEN_PRODUCT' and vwqbrk_cart_item.properties.builder_id == blank and vwqbrk_cart_item.properties._builder_id == blank %}
      	  <script>window.location.href='/cart/clear'</script>
      	{% endif %}

      	{% include 'vwqbrk-cart-item' with vwqbrk_cart_item %}
      	{% if vwqbrk_hidden_item %}{% continue %}{% endif %}

      	{% assign vwqbrk_cart_total_price = vwqbrk_cart_total_price | plus: vwqbrk_item_line_price %}

      	{% comment %} Update item count. {% endcomment %}
          {% assign vwqbrk_cart_item_count  = vwqbrk_cart_item_count | plus: vwqbrk_item_quantity %}

      	{% if is_mixed_cart == false and vwqbrk_cart_item.properties.frequency_type_text and vwqbrk_cart_item.properties.frequency_num %}
      		{% assign is_mixed_cart = true %}
              {% assign show_paypal = false %}
      		<style>[name*=\"goto_\"] { display:none !important }</style>
      	{% endif %}
      {% endfor %}

      {% comment %} Check to see if something went wrong - if we only have priced options left, clear the cart {% endcomment %}
      {% if vwqbrk_cart_item_count == 0 and vwqbrk_cart.item_count > 0 %}<script>window.location.href = '/cart/clear';</script>{% endif %}

      {% capture vwqbrk_ro_cart %}
        {% if shop.metafields.vwqbrk_rp.recurring_type == 0 or shop.metafields.vwqbrk_rp.recurring_type == 2 %}
          <input name=\"shopify_customer_id\" type=\"hidden\" value=\"{{ customer.id }}\" >
          <input name=\"email\" type=\"hidden\" value=\"{{ customer.email }}\" >
          <input name=\"address1\" type=\"hidden\" value=\"{{ customer.default_address.address1 }}\" >
          <input name=\"address2\" type=\"hidden\" value=\"{{ customer.default_address.address2 }}\" >
          <input name=\"city\" type=\"hidden\" value=\"{{ customer.default_address.city }}\" >
          <input name=\"company\" type=\"hidden\" value=\"{{ customer.default_address.company }}\" >
          <input name=\"country\" type=\"hidden\" value=\"{{ customer.default_address.country }}\" >
          <input name=\"first_name\" type=\"hidden\" value=\"{{ customer.default_address.first_name }}\" >
          <input name=\"last_name\" type=\"hidden\" value=\"{{ customer.default_address.last_name }}\" >
          <input name=\"phone\" type=\"hidden\" value=\"{{ customer.default_address.phone }}\" >
          <input name=\"province\" type=\"hidden\" value=\"{{ customer.default_address.province }}\" >
          <input name=\"zip\" type=\"hidden\" value=\"{{ customer.default_address.zip }}\" >
          <div class='product_rp_cart_div'></div>
        {% endif %}
      {% endcapture %}

      {% capture vwqbrk_scripts %}
      <script async src=\"//secure.apps.shappify.com/apps/options/vwqbrk_cart_handler.php?shop={{shop.permanent_domain}}\"></script>
      <script>
        var Vwqbrk = Vwqbrk || {};
      	Vwqbrk.updateQtyBoxes = function(){
      	  /* First make sure all ratio information is properly set */
      	  jQuery.each(jQuery('[data-vwqbrk-ratio]'), function(index, obj){
      	    if(parseInt(jQuery(obj).data('vwqbrk-ratio')) != 1){
      	      /* The quantity displayed and the quantity passed to checkout are separate - create a hidden input with the true quantity */
      	      if(jQuery(obj).find('[name=\"updates[]\"]').length && !jQuery(obj).find('.vwqbrk-true-quantity').length){
      	        jQuery(obj).find('[name=\"updates[]\"]').addClass('vwqbrk-display-quantity').removeAttr('name').parent().append('<input type=\"hidden\" name=\"updates[]\" class=\"vwqbrk-true-quantity\">');
      	      }
      	    }
      	  });
      	  /* Now loop through all rows that have nonstandard quantity behaviour and set the correct quantity */
      	  jQuery.each(jQuery('[data-vwqbrk-ratio], .vwqbrk-master'), function(index, obj){
      	    var multiplier = parseInt(jQuery(obj).data('vwqbrk-ratio')) || 1;
      	    /* Find the base quantity value that we're basing the update on */
      	    var baseQty;
      	    if(jQuery(obj).find('.vwqbrk-display-quantity').length){
      	      baseQty = parseInt(jQuery(obj).find('.vwqbrk-display-quantity').val());
      	    }
      	    else{
      	      baseQty = parseInt(jQuery(obj).find('[name^=updates]').val());
      	    }
      	    if(isNaN(baseQty)) return; /* Abort this round if there's no base quantity to be found */
      	    /* Loop through all matching builder IDs to update. The name=updates will always hold the true quantity, a display-quantity (if it exists) will hold a 'faked' quantity based on the ratio */
      	    var components = jQuery(obj).closest('form').find('[data-vwqbrk-id=' + jQuery(obj).data('vwqbrk-id') + ']');
      	    if(components.length){
      	      jQuery.each(jQuery(components), function(cindex, component){
      	        var multiplier = parseInt(jQuery(component).data('vwqbrk-ratio')) || 1;
      	        if(jQuery(component).hasClass('vwqbrk-one-time-charge')){
      	          jQuery(component).find('[name*=\"updates\"]').val(multiplier);
      	          jQuery(component).find('.vwqbrk-display-quantity').val(1);
      	        }else{
      	          jQuery(component).find('[name*=\"updates\"]').val(multiplier * baseQty);
      	          jQuery(component).find('.vwqbrk-display-quantity').val(baseQty);
      	        }
      	      });
      	    }
      	    else{
      	      /* No builder ID, so we just have to worry about the multiplier ratio on this line */
      	      jQuery(obj).find('[name*=\"updates\"]').val(multiplier * baseQty);
      	      jQuery(obj).find('.vwqbrk-display-quantity').val(baseQty);
      	    }
      	  });
      	};
        var update_qty_builder = Vwqbrk.updateQtyBoxes;
        function remove_product_builder(builder_id){
          jQuery('[data-vwqbrk-id=\"'+ builder_id +'\"] [name*=\"updates\"]').val(0);
          jQuery('[data-vwqbrk-id]').closest('form').submit();
        }
        function trigger_qty_update(){
          setTimeout(function(){jQuery('.vwqbrk-master [name*=\"updates\"]').trigger('change');}, 100);
        }
        if(typeof(jQuery)!='undefined' && typeof(Vwqbrk)=='object' && typeof(Vwqbrk.updateQtyBoxes)=='function')
          jQuery(document).on('submit', 'form[action*=\"cart\"]', Vwqbrk.updateQtyBoxes);
        if(typeof(jQuery)!='undefined' && typeof(Vwqbrk)=='object' && typeof(Vwqbrk.updateQtyBoxes)=='function')
          jQuery(document).on('change', '[name*=\"updates\"]', Vwqbrk.updateQtyBoxes);
      </script>
      {% endcapture %}

      {% comment %} Output variables for Rivets-based carts {% endcomment %}
      {% assign vwqbrk_rivets_row_data = ' rv-class-vwqbrk-hidden=\"item.is_hidden\" rv-class-vwqbrk-master=\"item.is_master\" rv-data-vwqbrk-id=\"item.builder_id\" rv-data-line=\"item.line\" rv-data-vwqbrk-ratio=\"item.qty_ratio\" ' %}
      {% assign vwqbrk_rivets_item_properties = '<div rv-html=\"item.formatted_properties\"></div>' %}
      {% assign vwqbrk_rivets_recurring_desc = '<div rv-html=\"item.formatted_recurring_desc\"></div>' %}

      {% capture vwqbrk_rivets_script %}
      {{ vwqbrk_scripts }}
      <script>
        if(typeof(VWQBRK)==='object' && VWQBRK.helpers && typeof(VWQBRK.helpers.rivetsInit)==='function')
          VWQBRK.helpers.rivetsInit();
      </script>
      {% endcapture %}

      {% capture vwqbrk_edit_in_cart %}
      {{ vwqbrk_scripts }}
      <div class=\"modal fade\" style=\"display: none;\" id=\"vwqbrk-cart-modal\" aria-labelledby=\"vwqbrkcartmodal\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
          <div class=\"modal-content\">
            	<div class=\"modal-body\">
              <div class=\"vwqbrk-image\"></div>
              <div class=\"vwqbrk-title\"></div>
              <div class=\"vwqbrk-price\"></div>
              <div class=\"vwqbrk-desc\"></div>
              <div class=\"vwqbrk-options\"></div>
          	</div>
          </div>
        </div>
      </div>
      {% endcapture %}

      {% capture vwqbrk_cart_quantity_check %}
      <script>
        /* Control quantities for variant-swapping apps */
        var Vwqbrk=Vwqbrk || {};
        Vwqbrk.updateQtyMax = function(){
          jQuery.each(jQuery('[data-vwqbrk-inventory-policy=\"deny\"][data-vwqbrk-base-variant]'), function(index, obj){
            var total = jQuery(obj).data('vwqbrk-inventory-quantity');
            /* Find number in the cart, remembering that multiple lines may have the same base variant */
            var current = 0;
            jQuery.each(jQuery('[data-vwqbrk-base-variant=\"' + jQuery(obj).data('vwqbrk-base-variant') + '\"] [name^=\"updates\"]'),function(qtyIndex,qtyObj){
              current += parseInt(jQuery(qtyObj).val());
            });
            var remaining = total - current;
            /* Update maximums for cart quantity boxes */
            if(jQuery(obj).find('[name^=\"updates\"]').length){
              /* Each line's quantity box maximum is the current line quantity plus the number remaining */
              var max = parseInt(jQuery(obj).find('[name^=\"updates\"]').val()) + remaining;
              jQuery(obj).find('[name^=\"updates\"]').attr('max', max);
            }
            /* Update maximums for product-page quantity boxes */
            else if(jQuery(obj).attr('name').indexOf('quantity') != -1){
              jQuery(obj).attr('max', max);
            }
          });
        };
        /* Run function when updating the quantity box */
        jQuery(document).on('change', '[data-vwqbrk-inventory-policy=\"deny\"] [name*=\"updates\"], [data-vwqbrk-inventory-policy=\"deny\"][name*=\"quantity\"]', function(){
          var precheck = parseInt(jQuery(this).val());
          var max = parseInt(jQuery(this).attr('max'));
          if(precheck > max){
            /* Force the box down to the maximum value if a user manages to input a larger number */
            jQuery(this).val(jQuery(this).attr('max'));
            if(typeof(qty_error_message)==='function')
              qty_error_message(max, precheck);
          }
          Vwqbrk.updateQtyMax();
        });
        jQuery(window).load(function(){
          Vwqbrk.updateQtyMax();
          jQuery('[data-vwqbrk-inventory-policy=\"deny\"] [name*=\"updates\"]').trigger('change');
        });
      </script>
      {% endcapture %}

      <script>window['mixed_cart'] = {{ is_mixed_cart }};</script>
      {% endcapture %}{{ vwqbrk_cart_liquid | strip_newlines }}

";
      $content_html = array(
            "asset" => array(
                "key" => "snippets/vwqbrk-cart.liquid",
                "value" =>  $content_html_value
            )
        );

      $putForm = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $content_html], TRUE);
      return true;
   }


   public function qbrkVariant($themeId,$shop)
   {
     $year = getYear();
      $content_html_value = "{%- comment -%}
      VWQBRK-VARIANT.LIQUID
      Last updated: 2018-December-7

      Sets all appropriate liquid variables for Vwqbrk Apps that affect the variant.
      Creates an updated JSON object that includes key information relating to our apps.
      Combines the functionality of vwqbrk-hidden-variants, vwqbrk-base-variant and vwqbrk-variant-inventory

      FLAGS:
        base_product:      {product object}                          Base product object for the variant, used to check/set several properties. If not supplied, defaults to vwqbrk_product. If no vwqbrk_product is set, defaults to product
        line_item:         {line item object} | null (default)       If set, pass the line item to the included snippets - some apps may adjust prices differently depending on whether we're influencing the cart total or not
        output:            'json' | 'none'  (default)                Controls whether anything is printed to the DOM
        hide_action:       'skip' | 'none'  (default)                Forces a 'continue' to skip hidden variants when 'skip' is set
        customer_tag:      {string} | null (default)                 If set, forces vwqbrk-variant to calculate as though the customer had the specified tag
        price_style:       'json' | null (default)                   If set, sets prices as '10.00' instead of 1000
        custom_app_list:   {string} | null (default)                 List of apps to apply to the price. Associated snippets will be automatically included.  If not specified, will check for a shop metafield to get a list of all relevant apps that need to be included.
        third_party_check: false | true (default)                    If true, runs additional checks that we know about to be compatible with third-party apps
        additonal_includes: {string} | null (default)                 Additional snippets that need to be included after the initial liquid variable assignments (comma-delimited)

      {%- endcomment -%}

      {%- comment -%}
      ============================================================================================================
          ASSIGN LIQUID VARIABLES
      ============================================================================================================
      {%- endcomment -%}


      {%- comment -%} Assign flags to their default values if not set {%- endcomment -%}

      {%- assign vwqbrk_apps_installed = shop | map: 'metafields' | map: 'vwqbrk_apps_installed' | first -%}

      {%- assign vwqbrk_variant = vwqbrk-variant | default: variant -%}
      {%- assign vwqbrk_variant_line_item = line_item | default: false -%}
      {%- assign vwqbrk_variant_base_product = base_product | default: vwqbrk_product | default: vwqbrk_variant_line_item.product | default: product | default: item.product | default: item -%}
      {%- assign vwqbrk_variant_output = output | default: 'none' -%}
      {%- assign vwqbrk_variant_hide_action = hide_action | default: 'none' -%}
      {%- assign vwqbrk_variant_customer_tag = customer_tag | default: csp_customer_tag -%}

      {%- comment -%} Check for CSP visibility. Other 'hide' rules are based directly on metafields on the variants. {%- endcomment -%}

      {%- assign csp_hidden = false -%}
      {%- if vwqbrk_variant_hide_action == 'skip' and vwqbrk_apps_installed contains 'Customer Pricing' -%}
        {%- if shop.metafields.shop_csp_tag_group.shop_csp_tag or vwqbrk_variant.metafields.shappify_csp -%}
          {%- assign csp_flag_string = ' (' | append: vwqbrk_variant_customer_tag | append: ')' -%}
          {%- assign all_shop_tags = shop.metafields.shop_csp_tag_group.shop_csp_tag | append: ',default' | split: ',' -%}

          {%- unless vwqbrk_variant.metafields.shappify_csp.csp_tag == blank -%}

            {%- if vwqbrk_variant.metafields.shappify_csp.csp_tag == 'default' and vwqbrk_variant_customer_tag != 'default' -%}
              {%- if vwqbrk_variant_base_product -%}
                {%- assign found_csp_level = false -%}
                {%- assign csp_bases = vwqbrk_variant_base_product | map: 'variants' | map: 'metafields' | map: 'shappify_csp' |  map: 'csp_base' -%}
                {%- assign csp_tags = vwqbrk_variant_base_product | map: 'variants' | map: 'metafields' | map: 'shappify_csp' |  map: 'csp_tag' -%}
                {%- if csp_bases contains vwqbrk_variant.id and csp_tags contains vwqbrk_variant_customer_tag -%}{%- assign found_csp_level = true -%}{%- endif -%}
                {%- if found_csp_level -%}{%- continue -%}{%- endif -%}
              {%- endif -%}
            {%- elsif vwqbrk_variant_customer_tag != vwqbrk_variant.metafields.shappify_csp.csp_tag -%}
              {%- continue -%}
            {%- endif -%}
          {%- assign vwqbrk_variant_title = vwqbrk_variant.title | remove: csp_flag_string -%}
          {%- endunless -%}
        {%- endif -%}
      {%- endif -%}

      {%- assign app_list = '' -%}
      {%- if app_list != blank and custom_app_list != blank -%}
        {%- assign vwqbrk_variant_app_list = app_list | append: ',' | append: custom_app_list -%}
      {%- else -%}
        {%- assign vwqbrk_variant_app_list = app_list | default: custom_app_list | default: false -%}
      {%- endif -%}

      {%- assign vwqbrk_variant_price = vwqbrk_variant.price -%}

      {%- if vwqbrk_variant_app_list -%}

        {%- assign vwqbrk_variant_app_list = vwqbrk_variant_app_list | split: ',' -%}
        {%- for app in vwqbrk_variant_app_list -%}
          {%- assign snippet_title = 'vwqbrk-' | append: app | append: '-variant' -%}
          {%- capture silence_output -%}
              {%- include snippet_title with vwqbrk_variant, base_product: vwqbrk_variant_base_product, line_item: vwqbrk_variant_line_item, customer_tag: vwqbrk_variant_customer_tag -%}
          {%- endcapture -%}
        {%- endfor -%}

      {%- endif -%}

      {%- assign vwqbrk_variant_available = vwqbrk_variant.available -%}

      {% if vwqbrk_apps_installed contains 'Quantity Breaks' or vwqbrk_apps_installed contains 'Customer Pricing' or vwqbrk_apps_installed contains 'Product Bundles' %}
        {%- comment -%} Find the base variant and base variant's inventory {%- endcomment -%}
        {%- assign vwqbrk_base_variant_id = vwqbrk_variant.metafields.shappify_csp['csp_base'] | default: vwqbrk_variant.metafields.shappify_qb['qb_parent'] | default: vwqbrk_variant.metafields.shappify_bundle['bundle_parent'] | default: vwqbrk_variant.id -%}

        {%- comment -%} Make sure we can find the indicated base variant! {%- endcomment -%}
        {%- assign vwqbrk_is_base_variant = true -%}
        {%- assign vwqbrk_base_variant = vwqbrk_variant -%}
        {%- unless vwqbrk_base_variant_id == vwqbrk_variant.id -%}
          {%- for variant_check in vwqbrk_variant_base_product.variants -%}
            {%- if variant_check.id == vwqbrk_base_variant_id -%}
              {%- assign vwqbrk_base_variant = variant_check -%}
              {%- assign vwqbrk_is_base_variant = false -%}
              {%- break -%}
            {%- endif -%}
          {%- endfor -%}
        {%- endunless -%}

        {%- comment -%} Assign inventory variables (based on the base_variant, if different from the current variant) {%- endcomment -%}
        {%- assign target_variant_inventory_quantity = vwqbrk_base_variant.inventory_quantity -%}
        {%- assign target_variant_inventory_policy = vwqbrk_base_variant.inventory_policy -%}

        {%- assign vwqbrk_variant_cart_quantity = 0 -%}
        {%- for inv_check_item in cart.items -%}
          {%- assign cart_variant = inv_check_item.variant -%}
          {%- assign cart_base_variant_id = cart_variant.metafields.shappify_csp['csp_base'] | default: cart_variant.metafields.shappify_qb['qb_parent'] | default: cart_variant.metafields.shappify_bundle['bundle_parent'] | default: cart_variant.id -%}
          {%- if cart_base_variant_id == vwqbrk_base_variant_id -%}
            {%- assign vwqbrk_variant_cart_quantity = vwqbrk_variant_cart_quantity | plus: inv_check_item.quantity -%}
          {%- endif -%}
        {%- endfor -%}

        {%- assign vwqbrk_variant_inventory_quantity =  vwqbrk_base_variant.inventory_quantity  -%}
        {%- assign vwqbrk_variant_remaining_quantity = vwqbrk_variant_inventory_quantity | minus: vwqbrk_variant_cart_quantity -%}
        {%- assign vwqbrk_variant_inventory_policy = vwqbrk_base_variant.inventory_policy -%}
        {%- assign vwqbrk_variant_inventory_management = vwqbrk_base_variant.inventory_management -%}

        {%- comment -%} Now that we've established quantity, re-evaluate the variant's availablility {%- endcomment -%}
        {%- if vwqbrk_variant_remaining_quantity <= 0 and vwqbrk_variant_inventory_policy == 'deny' and vwqbrk_variant_inventory_management != blank -%}
          {%- assign vwqbrk_variant_available = false -%}
        {%- endif -%}


        {%- comment -%} If we're calling this from vwqbrk-cart-item, also set the max quantity the line item can go up to {%- endcomment -%}
        {%- if vwqbrk_item and vwqbrk_variant_inventory_management != blank and vwqbrk_variant_inventory_policy == 'deny' -%}
          {%- assign vwqbrk_item_max_quantity = vwqbrk_item.quantity | plus: vwqbrk_variant_remaining_quantity -%}
        {%- else -%}
          {%- assign vwqbrk_item_max_quantity = '' -%}
        {%- endif -%}

        {%- comment -%} Check for QB level, hide variant and update title as appropriate {%- endcomment -%}
        {%- if vwqbrk_apps_installed contains 'Quantity Breaks'  or vwqbrk_apps_installed contains 'Customer Pricing' -%}
          {%- assign qb_hidden = false -%}
          {%- assign qb_level = vwqbrk_variant.metafields.shappify_qb.qb_qty | default: vwqbrk_variant.metafields.shappify_csp.csp_qty | times: 1 -%}
          {%- if qb_level > 1 -%}{%- assign qb_hidden = true -%}{%- endif -%}
          {%- if vwqbrk_variant.title == '1+' -%}
            {%- assign vwqbrk_variant_title = 'Default title' -%}
          {%- endif -%}
        {%- endif -%}

        {%- comment -%} If required, check for third-party Hide Rules as well {%- endcomment -%}

        {%- if third_party_check == blank -%}{%- assign third_party_check = true -%}{%- endif -%}
        {%- assign third_party_hidden = false -%}
        {%- if third_party_check -%}
          {%- if vwqbrk_variant.title contains '% Off' or vwqbrk_variant.metafields.brodev_scn.hide == \"true\" or vwqbrk_variant.metafields.secomapp.freegifts or vwqbrk_variant.title contains '(Bundle price)' -%}{%- assign third_party_hidden = true%}{%- endif -%}
        {%- endif -%}

        {%- if csp_hidden or qb_hidden or third_party_hidden or vwqbrk_variant.metafields.shappify_bundle.is_bundle == 'true' or third_party_hidden -%}
          {%- assign vwqbrk_hidden_variant = true -%}
        {%- else -%}
          {%- assign vwqbrk_hidden_variant = false -%}
        {%- endif -%}


        {%- comment -%} Check for presence of our apps {%- endcomment -%}
        {%- if vwqbrk_variant.metafields.vwqbrk_measurement.formula -%}{%- assign variant_has_btm = true -%}{%- else -%}{%- assign variant_has_btm = false -%}{%- endif -%}
        {%- if vwqbrk_variant.metafields.shappify_csp.csp_tag -%}{%- assign variant_has_csp = true -%}{%- else -%}{%- assign variant_has_csp = false -%}{%- endif -%}
        {%- if vwqbrk_variant.metafields.shappify_qb.pricing_html or vwqbrk_variant.metafields.shappify_csp.pricing_html -%}{%- assign variant_has_qb = true -%}{%- else -%}{%- assign variant_has_qb = false -%}{%- endif -%}
        {%- if vwqbrk_variant.metafields.vwqbrk_rp.rp_group_id -%}{%- assign variant_has_ro = true -%}{%- else -%}{%- assign variant_has_ro = false -%}{%- endif -%}
        {%- assign bdl_check = base_product.variants | map: 'metafields' | map: 'shappify_bundle' | map: 'bundle_parent' -%}
        {%- if bdl_check contains vwqbrk_variant.id -%}{%- assign variant_has_bdl = true -%}{%- else -%}{%- assign variant_has_bdl = false -%}{%- endif -%}


        {%- if vwqbrk_variant_hide_action == 'skip' and vwqbrk_hidden_variant -%}{%- continue -%}{%- endif -%}
      {% endif %}

        {%- assign option1_clean_name = variant.option1 | remove: csp_flag_string -%}
        {%- assign option2_clean_name = variant.option2 | remove: csp_flag_string -%}
        {%- assign option3_clean_name = variant.option3 | remove: csp_flag_string -%}

      {%- comment -%}
      ============================================================================================================
          BEGIN JSON OUTPUT
      ============================================================================================================
      {%- endcomment -%}
      {%- if vwqbrk_variant_output == 'json' -%}
      {
        \"id\":{{- vwqbrk_variant.id | json -}},
        \"product_id\":{{- vwqbrk_variant_base_product.id | json -}},
        \"product_handle\":{{- vwqbrk_variant_base_product.handle | json -}},
        \"title\":{{- vwqbrk_variant_title | default: vwqbrk_variant.title | json -}},
        \"option1\":{%- unless option1_clean_name == blank -%}{{- option1_clean_name | json -}}{%- else -%}null{%- endunless -%},
        \"option2\":{%- unless option2_clean_name == blank -%}{{- option2_clean_name | json -}}{%- else -%}null{%- endunless -%},
        \"option3\":{%- unless option3_clean_name == blank -%}{{- option3_clean_name | json -}}{%- else -%}null{%- endunless -%},
        \"sku\":{{- vwqbrk_variant.sku | json -}},
        \"requires_shipping\":{{- vwqbrk_variant.requires_shipping | json -}},
        \"taxable\":{{- vwqbrk_variant.taxable | json -}},
        \"featured_image\":
        {%- if vwqbrk_variant.featured_image == blank -%}
          {{vwqbrk_base_variant.featured_image | json}},
        {%- else -%}
          {
          \"created_at\":{%- capture created_at -%}{{- vwqbrk_variant.featured_image.created_at -}}T{{- vwqbrk_variant.featured_image.created_at | date: \"%T\" -}}{%- endcapture -%}{{- shop.timezone -}}{{- created_at | json -}},
          \"id\":{{- vwqbrk_variant.featured_image.id | json -}},
          \"position\":{{- vwqbrk_variant.featured_image.position | json -}},
          \"product_id\":{{- vwqbrk_variant.featured_image.product_id | json -}},
          \"src\":{{- vwqbrk_variant.featured_image.src | json -}},
          \"updated_at\":{%- capture updated_at -%}{{- vwqbrk_variant.featured_image.updated_at | date: \"%F\" -}}T{{- vwqbrk_variant.featured_image.updated_at | date: \"%T\" -}}{%- endcapture -%}{{- shop.timezone -}}{{- updated_at | json -}},
          \"width\":{{- vwqbrk_variant.featured_image.width -}},
          \"height\":{{- vwqbrk_variant.featured_image.height -}}
          },
        {%- endif -%}

        \"image_id\":{{variant.featured_image.id | default: vwqbrk_base_variant.featured_image.id | json -}},
        \"available\":{{- vwqbrk_variant_available | json -}},
        \"name\":{{- vwqbrk_variant_base_product.title | append: \" - \" | append: vwqbrk_variant.title | remove: csp_flag_string | json -}},
        \"options\":{{- vwqbrk_variant.options | json | remove: csp_flag_string -}},
        \"price\":{%- unless price_style == 'json' -%}{{- vwqbrk_variant_price | default: vwqbrk_variant.price | json -}}{%- else -%}{%- assign cents = vwqbrk_variant_price | default: vwqbrk_variant.price | modulo: 100 | prepend: '00' | slice: -2, 2 -%}{%- assign dollars = vwqbrk_variant_price | default: vwqbrk_variant.price | times: 0.01 | floor -%}{{- dollars | append: '.' | append: cents | json -}}{%- endunless -%},
        \"weight\":{{- vwqbrk_variant.weight | json -}},
        \"compare_at_price\":{%- if vwqbrk_base_variant.compare_at_price == blank -%}null{% else %}{%- unless price_style == 'json' -%}{{- vwqbrk_variant_compare_at_price | default: vwqbrk_variant.compare_at_price | json -}}{%- else -%}{%- assign cents = vwqbrk_variant_compare_at_price | default: vwqbrk_variant.compare_at_price | modulo: 100 | prepend: '00' | slice: -2, 2 -%}{%- assign dollars = vwqbrk_variant_compare_at_price | default: vwqbrk_variant.compare_at_price | times: 0.01 | floor -%}{{- dollars | append: '.' | append: cents | json -}}{%- endunless -%}{%- endif -%},
        \"inventory_quantity\":{{- vwqbrk_variant_inventory_quantity | default: variant.inventory_quantity | json -}},
        \"inventory_management\":{{- vwqbrk_variant_inventory_management | default: variant.inventory_management | json -}},
        \"inventory_policy\":{{- vwqbrk_variant_inventory_policy | default: variant.inventory_policy | json -}},
        \"inventory_in_cart\":  {{- vwqbrk_variant_cart_quantity | default: 0 | json -}},
        \"inventory_remaining\":{{- vwqbrk_variant_remaining_quantity | default: vwqbrk_variant_inventory_quantity | default: vwqbrk_variant.inventory_quantity | json -}},
        \"incoming\":{{- vwqbrk_variant.incoming | default: vwqbrk_base_variant.incoming | json -}},
        \"next_incoming_date\":{{- vwqbrk_variant.next_incoming_date  | default: vwqbrk_base_variant.next_incoming_date | date: \"%Y-%m-%d\" | json -}},
        \"taxable\":{%- unless vwqbrk_variant_taxable == blank -%}{{- vwqbrk_variant_taxable | json -}}{%- else -%}{{- vwqbrk_variant.taxable | json -}}{%- endunless -%},
        \"barcode\":{{- variant.barcode | json -}}

      {% comment %}
        {%- comment -%} SPECIAL HANDLING FOR CSP {%- endcomment -%}
        {%- if variant_has_csp -%}
          ,\"csp_lookup\":{
            {%- for tag in all_shop_tags -%}
              {%- assign found_variant = '' -%}
              {%- if forloop.first != true -%},{%- endif -%}{{- tag | json -}}:
              {%- for csp_variant in vwqbrk_variant_base_product.variants -%}
                {%- if csp_variant.metafields.shappify_csp.csp_qty and csp_variant.metafields.shappify_csp.csp_qty != 1 -%}{%- continue -%}{%- endif -%}
                {%- assign base_check = csp_variant.metafields.shappify_csp.csp_base | default: csp_variant.id -%}
                {%- if base_check == vwqbrk_base_variant.id and csp_variant.metafields.shappify_csp.csp_tag == tag -%}
                  {%- assign found_variant = csp_variant -%}
                  {{- break -}}
                {%- endif -%}
              {%- endfor -%}
              {
                \"id\":{{- found_variant.id | json -}},
                \"price\":{{- found_variant.price | json -}}
                {%- if found_variant.metafields.shappify_csp.pricing_html -%},\"grid\":{{- found_variant.metafields.shappify_csp.pricing_html | json -}}{%- endif -%}
              }
            {%- endfor -%}
          }
        {%- endif -%}
        {%- comment -%} END OF CSP SPECIAL HANDLING {%- endcomment -%}

        {%- comment -%} SPECIAL HANDLING FOR BTM {%- endcomment -%}
        {%- if variant_has_btm -%}
          ,\"btm_lookup\":{{- vwqbrk_variant.metafields.vwqbrk_measurement | json -}}
        {%- endif -%}
        {%- comment -%} END OF BTM SPECIAL HANDLING {%- endcomment -%}

        {%- comment -%} SPECIAL HANDLING FOR QB {%- endcomment -%}
        {%- if variant_has_qb -%}
          ,\"qb_lookup\":{
            \"levels\": {
            {%- assign qb_price_varies = false -%}
            {%- assign not_first_tag = false -%}
            {%- for qb_variant in vwqbrk_variant_base_product.variants -%}
              {%- if qb_variant.metafields.shappify_qb.qb_parent == vwqbrk_variant.id or qb_variant.metafields.shappify_csp.csp_base == vwqbrk_base_variant.id or qb_variant.id == vwqbrk_base_variant.id -%}
                {%- if qb_variant.metafields.shappify_csp.csp_tag == blank or qb_variant.metafields.shappify_csp.csp_tag == vwqbrk_variant_customer_tag -%}
                  {%- if not_first_tag -%},{%- endif -%}{%- assign not_first_tag = true -%}
                  {%- unless qb_variant.price == vwqbrk_variant.price -%}{%- assign qb_price_varies = true -%}{%- endunless -%}
                  \"{{- qb_variant.metafields.shappify_qb.qb_qty | default: qb_variant.metafields.shappify_csp.csp_qty | default: 1 -}}\": {\"id\":{{- qb_variant.id -}},\"price\":{{- qb_variant.price -}}}
                {%- endif -%}
              {%- endif -%}
            {%- endfor -%}
            }
            {%- if qb_price_varies -%}
              ,\"qb_price_varies\": {{- qb_price_varies | json -}}
              ,\"grid\": {{- vwqbrk_variant.metafields.shappify_qb.pricing_html | default: vwqbrk_variant.metafields.shappify_csp.pricing_html | json -}}
            {%- endif -%}
          }
        {%- endif -%}
        {%- comment -%} END OF QB SPECIAL HANDLING {%- endcomment -%}

        {%- comment -%} SPECIAL HANDLING FOR RO {%- endcomment -%}
        {%- if variant_has_ro -%}
          ,\"ro_lookup\":{{- vwqbrk_variant.metafields.vwqbrk_rp | json | remove: 'rp_' -}}
        {%- endif -%}
        {%- comment -%} END OF RO SPECIAL HANDLING {%- endcomment -%}

        {%- comment -%} SPECIAL HANDLING FOR BUNDLES {%- endcomment -%}
        {%- if variant_has_bdl -%}
          ,\"bdl_lookup\":{
          {%- for bdl_variant in base_product.variants -%}
            {%- unless vwqbrk_variant.id == bdl_variant.metafields.shappify_bundle.bundle_parent -%}{%- continue -%}{%- endunless -%}
            \"id\":{{- bdl_variant.id -}},
            \"price\":{{- bdl_variant.price | json -}},
            \"bundle_group\":{{- bdl_variant.metafields.shappify_bundle.bundle_group -}}
            {%- break -%}
          {%- endfor -%}
          }
        {%- endif -%}
        {%- comment -%} END OF BUNDLES SPECIAL HANDLING {%- endcomment -%}
      {% endcomment %}
      }
      {%- endif -%}

";
      $content_html = array(
            "asset" => array(
                "key" => "snippets/vwqbrk-variant.liquid",
                "value" =>  $content_html_value
            )
        );

      $putForm = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $content_html], TRUE);
      return true;
   }
   public function qbrkProduct($themeId,$shop)
   {
     $year = getYear();
      $content_html_value = "{%- comment -%}
      VWQBRK-PRODUCT.LIQUID
      Last updated: 2018-Oct-16

      Sets all the appropriate liquid variables for Vwqbrk Apps that affect the product.
      Creates an updated JSON object that takes all appropriate apps into account. Can mimic all three types of product objects that Shopify uses.
      When installing, use {%- include 'vwqbrk-product', output: 'json' -%} to replace {{ product | json }} in the theme's liquid code.
      Alternatively, use {%- include 'vwqbrk-product', output: 'json', escape: true -%} to replace {{ product | json | escape }} in the theme's liquid code.

      FLAGS:
      output:              'none' | 'default' | 'script' | 'json'                   Controls how much data is printed
      endpoint:            'js' | 'json' | false (default)                          Prints 'layout none' to create an AJAX endpoint. Resulting object will be formatted to match either the '.js' or '.json' style of output. If set to a truth-y value other than 'json' will act like a '.js' endpoint.
      hide_action:         'header' | 'error' | 'break' | 'skip' | 'none' (default) Determines what happens if the product is hidden
      sort_by:             {string} | null (default)                                If set, attempts to sort variants by the provided field
      sort_order:          'desc' | 'asc' (default)                                 If set to 'desc' (descending), reverses the variant sort
      customer_tag:        {string} | null (default)                                If set, forces vwqbrk-product to calculate as though the customer had the specified tag
      quick_price:         true | false (default)                                   If true, uses the metafields set by the CSP/QB apps to get the prices. Output must be 'none' to be allowed
      additional_includes: {string} | null (default)                                If set, includes the additional products after setting the initial vwqbrk_product liquid variables
      variant_includes:    {string} | null (default)                                Additional include files to be passed on to vwqbrk-variant (comma-delimited)
      escape:              {bool} | false (default)                                 If set, forces vwqbrk-product to escape its json output

      REQUIRED: vwqbrk-variant.liquid is needed for full product handling.

      OPTIONAL: vwqbrk-product-error.liquid - If this snippet exists, it will be used to display content other than 'Product not available'
      to the customer if the hide_action is either 'break' or 'error'.
      A vwqbrk-product-error snippet can access:
      product: The liquid variable representing the product that is hidden
      reason:  Why the product is hidden. Possible values are:
      'customer-hide-tag' | 'motivator-hidden-product' | 'options-hidden-product' | 'duplicate-and-hide' | 'other'
      {%- endcomment -%}

      {%- comment -%}
      ============================================================================================================
      ASSIGN LIQUID VARIABLES
      ============================================================================================================
      {%- endcomment -%}

      {%- assign vwqbrk_product = vwqbrk-product | default: product -%}
      {%- assign vwqbrk_price = vwqbrk_product.price -%}
      {%- assign vwqbrk_price_min = vwqbrk_product.price_min -%}
      {%- assign vwqbrk_price_max = vwqbrk_product.price_max -%}
      {%- assign vwqbrk_price_varies = vwqbrk_product.price_varies -%}
      {%- assign vwqbrk_compare_at_price = vwqbrk_product.compare_at_price -%}
      {%- assign vwqbrk_compare_at_price_min = vwqbrk_product.compare_at_price_min -%}
      {%- assign vwqbrk_compare_at_price_max = vwqbrk_product.compare_at_price_max -%}
      {%- assign vwqbrk_compare_at_price_varies = vwqbrk_product.compare_at_price_varies -%}
      {%- assign vwqbrk_selected_or_first_available_variant = vwqbrk_product.selected_or_first_available_variant | default: vwqbrk_product.variants.first | default: vwqbrk_product.variants[0] -%}

      {%- if product or vwqbrk-product -%}
          {%- assign vwqbrk_apps_installed = shop | map: 'metafields' | map: 'vwqbrk_apps_installed' | first -%}

          {%- comment -%}Assign flags to their default values if not set {%- endcomment -%}
          {%- assign escape_output = escape | default: false -%}
          {%- assign vwqbrk_product_output = output | default: 'default' -%}
          {%- assign vwqbrk_product_endpoint = endpoint | default: false -%}
          {%- if vwqbrk_product_endpoint -%}{%- assign vwqbrk_product_output = 'json' -%}{%- endif -%}

          {%- assign vwqbrk_product_hide_action = hide_action | default: 'none' -%}
          {%- assign vwqbrk_product_sort_by = sort_by | default: nil -%}
          {%- assign vwqbrk_product_sort_order = sort_order | default: 'asc' -%}
          {%- assign vwqbrk_product_quick_price = quick_price | default: false -%}

          {%- if vwqbrk_product_hide_action == 'skip' and output == blank -%}
              {%- assign product_metafield_check = vwqbrk_product.variants | map: 'metafields' | map: 'shappify_csp' | map: 'csp_tag' | uniq -%}
              {%- if product_metafield_check.size > 1 or product_metafield_check.first != blank -%}
                  {%- assign has_csp = true -%}
              {%- else -%}
                  {%- assign has_csp = false -%}
              {%- endif -%}
              {%- if quick_price == blank and shop.metafields.shop_csp_tag_group.shop_csp_tag and has_csp -%}
                  {%- assign vwqbrk_product_quick_price = true -%}
              {%- endif -%}
          {%- endif -%}

          {%- if vwqbrk_apps_installed contains 'Quantity Breaks' or vwqbrk_apps_installed contains 'Customer Pricing' or vwqbrk_apps_installed contains 'Product Bundles' or vwqbrk_apps_installed contains 'The Motivator' -%}
              {%- unless csp_customer_tag -%}
                  {%- if customer.tags and shop.metafields.shop_csp_tag_group.shop_csp_tag -%}
                      {%- assign all_shop_tags = shop.metafields.shop_csp_tag_group.shop_csp_tag | append: ',default' | split: ',' -%}
                      {%- for customer_tag in customer.tags -%}
                          {%- if all_shop_tags contains customer_tag -%}
                              {%- assign csp_customer_tag = customer_tag -%}
                          {%- endif -%}
                      {%- endfor -%}
                  {%- endif -%}
                  {%- assign vwqbrk_product_customer_tag = customer_tag | default: csp_customer_tag | default: 'default' -%}
              {%- endunless -%}

              {%- if vwqbrk_product_output == 'json' and vwqbrk_product_endpoint -%}{%- layout none -%}{%- endif -%}

              {%- assign variant_list = vwqbrk_product.variants -%}
              {%- if vwqbrk_product_sort_by != blank -%}{%- assign variant_list = variant_list | sort: vwqbrk_product_sort_by -%}{%- endif -%}
              {%- if vwqbrk_product_sort_order == 'desc' or vwqbrk_product_sort_order == 'descending' -%}{%- assign variant_list = variant_list | reverse -%}{%- endif -%}
              {%- assign variant_list = variant_list | default: vwqbrk_product.variants -%}

              {%- if vwqbrk_product_output == 'json' -%}
                  {%- assign requires_variant_loop = true -%}
                  {%- elsif vwqbrk_product_quick_price and vwqbrk_product_output == 'none' -%}
                  {%- assign requires_variant_loop = false -%}
              {%- else -%}
                  {%- assign requires_variant_loop = vwqbrk_product.metafields.shappify_bundle | default: vwqbrk_product.metafields.shappify_csp | default: vwqbrk_product.metafields.shappify_qb | default: shop.metafields.shop_csp_tag_group | default: shop.metafields.vwqbrk_measurement | default: shop.metafields.vwqbrk_rp | default: false -%}
              {%- endif -%}

              {%- capture vwqbrk_bundles_widget -%}
                  <div class=\"vwqbrk-bundle\" data-product-id=\"{{ product.id }}\"></div>
              {%- endcapture -%}

              {%- assign product_has_btm = false -%}
              {%- assign product_has_csp = false -%}
              {%- assign product_has_qb = false -%}
              {%- assign product_has_ro = false -%}
              {%- assign product_has_bdl = false -%}

              {%- assign vwqbrk_hidden_product = false -%}
              {%- assign vwqbrk_trigger_break = false -%}

              {%- if requires_variant_loop -%}
                  {%- comment -%}INTIALIZE VARIABLES, CLEAR OLD VALUES {%- endcomment -%}
                  {%- assign vwqbrk_price_min = 1000000000000000000 -%}               {%- comment -%}Starting the count at Shopify's max allowed value {%- endcomment -%}
                  {%- assign vwqbrk_price_max = 0 -%}
                  {%- assign vwqbrk_price = vwqbrk_price_min -%}
                  {%- assign vwqbrk_price_varies = false -%}

                  {%- assign vwqbrk_compare_at_price_min = 1000000000000000000  -%}   {%- comment -%}Starting the count at Shopify's max allowed value {%- endcomment -%}
                  {%- assign vwqbrk_compare_at_price_max = 0 -%}
                  {%- assign vwqbrk_compare_at_price = vwqbrk_compare_at_price_min -%}
                  {%- assign vwqbrk_compare_at_price_varies = false -%}

                  {%- assign vwqbrk_selected_or_first_available_variant = \"\" -%}
                  {%- assign vwqbrk_variants_size = 0 -%}

                  {%- assign options1 = nil -%}
                  {%- assign options2 = nil -%}
                  {%- assign options3 = nil -%}

                  {%- assign vwqbrk_product_available = false -%}

                  {%- comment -%}SET LIQUID PRODUCT VARIABLES DERIVED FROM VARIANT VALUES {%- endcomment -%}

                  {%- assign variant_output_json = '' -%}
                  {%- for variant in variant_list -%}
                      {%- capture vwqbrk_variant_check -%}
                          {%- include 'vwqbrk-variant' with variant, output: 'json', hide_action: 'skip', base_product: vwqbrk_product, customer_tag: vwqbrk_product_customer_tag, price_style: vwqbrk_product_endpoint -%}
                      {%- endcapture -%}

                      {%- unless vwqbrk_product_output == 'none' -%}
                          {%- if vwqbrk_variant_check contains 'Liquid error' -%}
                              {%- assign variant_output_json = variant_list | json -%}
                              {%- break -%}
                          {%- endif -%}
                      {%- endunless -%}

                      {%- if variant_output_json.size > 1 -%}{%- assign variant_output_json = variant_output_json | append: ',' -%}{%- endif -%}
                      {%- assign variant_output_json = variant_output_json | append: vwqbrk_variant_check -%}

                      {%- if vwqbrk_variant_price < vwqbrk_price_min -%}{%- assign vwqbrk_price_min = vwqbrk_variant_price -%}{%- endif -%}
                      {%- if vwqbrk_variant_price > vwqbrk_price_max -%}{%- assign vwqbrk_price_max = vwqbrk_variant_price -%}{%- endif -%}
                      {%- if vwqbrk_price_max != vwqbrk_price_min -%}{%- assign vwqbrk_price_varies = true -%}{%- endif -%}
                      {%- assign vwqbrk_price = vwqbrk_price_min -%}

                      {%- if variant.compare_at_price < vwqbrk_compare_at_price_min -%}{%- assign vwqbrk_compare_at_price_min = variant.compare_at_price -%}{%- endif -%}
                      {%- if variant.compare_at_price > vwqbrk_compare_at_price_max -%}{%- assign vwqbrk_compare_at_price_max = variant.compare_at_price -%}{%- endif -%}
                      {%- if vwqbrk_compare_at_price_max != vwqbrk_compare_at_price_min -%}{%- assign vwqbrk_compare_at_price_varies = true -%}{%- endif -%}
                      {%- assign vwqbrk_compare_at_price = vwqbrk_compare_at_price_min -%}

                      {%- if variant.id == vwqbrk_product.selected_or_first_available_variant.id -%}{%- assign vwqbrk_selected_or_first_available_variant = variant -%}{%- endif -%}
                      {%- if vwqbrk_selected_or_first_available_variant == \"\" -%}{%- assign vwqbrk_selected_or_first_available_variant = variant -%}{%- endif -%}
                      {%- if vwqbrk_selected_or_first_available_variant.available == false and variant.available == true -%}{%- assign vwqbrk_selected_or_first_available_variant = variant -%}{%- endif -%}
                      {%- assign vwqbrk_variants_size = vwqbrk_variants_size | plus: 1 -%}

                      {%- unless options1 contains option1_clean_name or option1_clean_name == blank -%}
                      {%- unless options1 == blank -%}{%- assign options1 = options1 | join: '~~' | append: '~~' -%}{%- endunless -%}
                      {%- assign options1 = options1 | append: option1_clean_name | split: '~~' -%}
                      {%- endunless -%}

                      {%- unless options2 contains option2_clean_name or option2_clean_name == blank -%}
                      {%- unless options2 == blank -%}{%- assign options2 = options2 | join: '~~' | append: '~~' -%}{%- endunless -%}
                      {%- assign options2 = options2 | append: option2_clean_name | split: '~~' -%}
                      {%- endunless -%}

                      {%- unless options3 contains option3_clean_name or option3_clean_name == blank -%}
                      {%- unless options3 == blank -%}{%- assign options3 = options3 | join: '~~' | append: '~~' -%}{%- endunless -%}
                      {%- assign options3 = options3 | append: option3_clean_name | split: '~~' -%}
                      {%- endunless -%}

                      {%- assign vwqbrk_product_available = vwqbrk_product_available | default: vwqbrk_variant_available -%}
                      {%- assign product_has_btm = variant_has_btm | default: product_has_btm -%}
                      {%- assign product_has_csp = variant_has_csp | default: product_has_csp -%}
                      {%- assign product_has_qb = variant_has_qb | default: product_has_qb -%}
                      {%- assign product_has_ro = variant_has_ro | default: product_has_ro -%}
                      {%- assign product_has_bdl = variant_has_bdl | default: product_has_bdl -%}

                  {%- endfor -%}

                  {%- if variant_output_json.first != '[' -%}
                      {%- assign variant_output_json = '[' | append: variant_output_json | append: ']' -%}
                  {%- endif -%}

                  {%- comment -%}Failsafe: This will set all the Vwqbrk prices to \"NaN\" (Not A Number) in the unexpected case where all variants are supposed to be hidden from the customer {%- endcomment -%}
                  {%- if vwqbrk_variants_size == 0 -%}{%- assign vwqbrk_price_min = \"NaN\" -%}{%- assign vwqbrk_price_max = \"NaN\" -%}{%- assign vwqbrk_price = \"NaN\" -%}{%- assign vwqbrk_compare_at_price_min = \"NaN\" -%}{%- assign vwqbrk_compare_at_price_max = \"NaN\" -%}{%- assign vwqbrk_compare_at_price = \"NaN\" -%}{%- endif -%}

                  {%- comment -%}Failsafe: This will set all the Vwqbrk compare_at prices to the default compare_at_prices when 'compare_at' is not found {%- endcomment -%}
                  {%- if vwqbrk_compare_at_price_min > vwqbrk_compare_at_price_max -%}{%- assign vwqbrk_compare_at_price_min = vwqbrk_product.compare_at_price_min -%}{%- assign vwqbrk_compare_at_price_max = vwqbrk_product.compare_at_price_max -%}{%- assign vwqbrk_compare_at_price = vwqbrk_product.compare_at_price -%}{%- endif -%}

                  {%- comment -%}Failsafe: If no valid variants exist, fail back to product.selected_or_first_available_variant after all {%- endcomment -%}
                  {%- if vwqbrk_selected_or_first_available_variant == \"\" -%}{%- assign vwqbrk_selected_or_first_available_variant = product.selected_or_first_available_variant -%}{%- endif -%}

              {%- else -%}

                  {%- if vwqbrk_product_quick_price -%}
                      {%- assign money_prefix = shop.money_format | split: '{{' | first -%}
                      {%- assign money_suffix = shop.money_format | split: '}}' | last -%}
                      {%- assign high_tag = vwqbrk_product_customer_tag | append: '_price_high' -%}
                      {%- assign vwqbrk_price_min = vwqbrk_product.metafields.shappify_csp[vwqbrk_product_customer_tag] | default: vwqbrk_product.metafields.shappify_qb.qb_min | default: vwqbrk_product.price | remove: money_prefix | remove: money_suffix | remove: '.' | remove: ',' | remove: ' ' | times: 1 -%}
                      {%- assign vwqbrk_price_max = vwqbrk_product.metafields.shappify_csp[high_tag] | default: vwqbrk_product.price_max  | remove: money_prefix | remove: money_suffix | remove: '.' | remove: ',' | remove: ' ' | times: 1 -%}
                      {%- assign vwqbrk_price = vwqbrk_price_min -%}
                      {%- if vwqbrk_price_max == vwqbrk_price_min -%}
                          {%- assign vwqbrk_price_varies = false -%}
                      {%- else -%}
                          {%- assign vwqbrk_price_varies = true -%}
                      {%- endif -%}
                  {%- else -%}
                      {%- assign vwqbrk_price_min = vwqbrk_product.price_min -%}
                      {%- assign vwqbrk_price_max = vwqbrk_product.price_max -%}
                      {%- assign vwqbrk_price = vwqbrk_product.price -%}
                      {%- assign vwqbrk_price_varies = vwqbrk_product.price_varies -%}
                  {%- endif -%}


                  {%- assign vwqbrk_compare_at_price_min = vwqbrk_product.compare_at_price_min  -%}
                  {%- assign vwqbrk_compare_at_price_max = vwqbrk_product.compare_at_price_max -%}
                  {%- assign vwqbrk_compare_at_price = vwqbrk_product.compare_at_price -%}
                  {%- assign vwqbrk_compare_at_price_varies = vwqbrk_product.compare_at_price_varies -%}

                  {%- assign vwqbrk_selected_or_first_available_variant = vwqbrk_product.selected_or_first_available_variant -%}
                  {%- assign vwqbrk_variants_size = vwqbrk_product.variants.size -%}

                  {%- assign options1 = vwqbrk_product.options[0].values -%}
                  {%- assign options2 = vwqbrk_product.options[1].values -%}
                  {%- assign options3 = vwqbrk_product.options[2].values -%}

                  {%- assign vwqbrk_product_available = false -%}
                  {%- assign variant_output_json = variant_list | json -%}
              {%- endif -%}

              {%- if vwqbrk_product_endpoint == 'json' -%}
                  {%- assign cents = vwqbrk_price | modulo: 100 | prepend: '00' | slice: -2, 2 -%}
                  {%- assign dollars = vwqbrk_price | times: 0.01 | floor -%}
                  {%- assign vwqbrk_price = dollars | append: '.' | append: cents -%}

                  {%- assign cents = vwqbrk_price_min | modulo: 100 | prepend: '00' | slice: -2, 2 -%}
                  {%- assign dollars = vwqbrk_price_min | times: 0.01 | floor -%}
                  {%- assign vwqbrk_price_min = dollars | append: '.' | append: cents -%}

                  {%- assign cents = vwqbrk_price_max | modulo: 100 | prepend: '00' | slice: -2, 2 -%}
                  {%- assign dollars = vwqbrk_price_max | times: 0.01 | floor -%}
                  {%- assign vwqbrk_price_max = dollars | append: '.' | append: cents -%}

                  {%- assign cents = vwqbrk_compare_at_price | modulo: 100 | prepend: '00' | slice: -2, 2 -%}
                  {%- assign dollars = vwqbrk_compare_at_price | times: 0.01 | floor -%}
                  {%- assign vwqbrk_compare_at_price = dollars | append: '.' | append: cents -%}

                  {%- assign cents = vwqbrk_compare_at_price_min | modulo: 100 | prepend: '00' | slice: -2, 2 -%}
                  {%- assign dollars = vwqbrk_compare_at_price_min | times: 0.01 | floor -%}
                  {%- assign vwqbrk_compare_at_price_min = dollars | append: '.' | append: cents -%}

                  {%- assign cents = vwqbrk_compare_at_price_max | modulo: 100 | prepend: '00' | slice: -2, 2 -%}
                  {%- assign dollars = vwqbrk_compare_at_price_max | times: 0.01 | floor -%}
                  {%- assign vwqbrk_compare_at_price_max = dollars | append: '.' | append: cents -%}
              {%- endif -%}

          {%- endif -%}

          {%- comment -%}
          ============================================================================================================
          HANDLE HIDDEN PRODUCTS
          ============================================================================================================
          {%- endcomment -%}

          {%- comment -%}CHECK FOR CSP VISIBILITY {%- endcomment -%}
          {%- assign csp_hide_tag = false -%}
          {%- assign hide_check = vwqbrk_product_customer_tag | append: '-HIDE' -%}
          {%- if vwqbrk_product.tags contains hide_check -%}{%- assign csp_hide_tag = true -%}{%- endif -%}
          {%- comment -%}END OF CSP CHECK {%- endcomment -%}

          {%- unless vwqbrk_product.id == blank -%}
              {%- if csp_hide_tag == true or vwqbrk_product.type == 'OPTIONS_HIDDEN_PRODUCT' or vwqbrk_product.type == 'MOTIVATOR_HIDDEN_PRODUCT' or vwqbrk_product.metafields.inventory.ShappifyHidden == \"true\" -%}
                  {%- assign vwqbrk_hidden_product = true -%}

                  {%- comment -%}What is the reason for the hidden product? {%- endcomment -%}
                  {%- if csp_hide_tag == true -%}                                          {%- assign reason = 'customer-hide-tag' -%}
                      {%- elsif vwqbrk_product.type == 'MOTIVATOR_HIDDEN_PRODUCT' -%}            {%- assign reason = 'motivator-hidden-product' -%}
                      {%- elsif vwqbrk_product.type == 'OPTIONS_HIDDEN_PRODUCT' -%}              {%- assign reason = 'options-hidden-product' -%}
                      {%- elsif vwqbrk_product.metafields.inventory.ShappifyHidden == \"true\" -%} {%- assign reason = 'duplicate-and-hide' -%}
                  {%- else -%}                                                             {%- assign reason = 'other' -%}
                  {%- endif -%}

                  {%- capture hidden_product_output -%}
                  {%- case vwqbrk_product_hide_action -%}
                  {%- when 'break' -%}
                  {%- capture error_page_check -%}{%- include 'vwqbrk-product-error' with reason, product: vwqbrk_product -%}{%- endcapture -%}
                  {%- unless error_page_check contains 'Liquid error' -%}
                  {{- error_page_check -}}
              {%- else -%}
                  <p class='vwqbrk_not_available'>Product is not available</p>
                  {%- endunless -%}
                  {%- assign vwqbrk_trigger_break = true -%}

                  {%- when 'error' -%}
                  {%- include 'vwqbrk-product-error' with reason, product: vwqbrk_product -%}
                  {%- assign vwqbrk_trigger_break = true -%}

                  {%- when 'skip' -%}
                  {%- continue -%}

                  {%- when 'header' -%}
                  {%- if template == 'product' -%}<meta name=\"robots\" content=\"noindex\">{%- endif -%}
                  {%- endcase -%}
                  {%- endcapture%}
              {%- endif -%}
          {%- endunless -%}

          {%- comment -%}
          ============================================================================================================
          MIN/MAX QUANTITY
          ============================================================================================================
          {%- endcomment -%}

          {%- if vwqbrk_apps_installed contains 'Customer Pricing' or vwqbrk_apps_installed contains 'Quantity Breaks' -%}

              {%- assign vwqbrk_product_min = false -%}
              {%- assign vwqbrk_product_max = false -%}
              {%- for tag in vwqbrk_product.tags -%}
                  {%- assign lowercase_tag = tag | downcase | replace: 'min ', 'min_' | replace: 'min-', 'min_' | replace: 'max ', 'max_' | replace: 'max-', 'max_' -%}
                  {%- assign lowercase_customer_tag = vwqbrk_product_customer_tag | downcase -%}
                  {%- if lowercase_tag contains 'min_' -%}
                      {%- assign tag_info = lowercase_tag | split: 'min_' -%}
                      {%- assign cust_tag = tag_info.first | strip -%}
                      {%- if tag_info.first == blank or cust_tag == lowercase_customer_tag -%}
                          {%- assign vwqbrk_product_min = tag_info | last | times: 1 %}
                      {%- endif -%}
                      {%- elsif lowercase_tag contains 'max_' -%}
                      {%- assign tag_info = lowercase_tag | split: 'max_' -%}
                      {%- assign cust_tag = tag_info.first | strip -%}
                      {%- if tag_info.first == blank or cust_tag == lowercase_customer_tag -%}
                          {%- assign vwqbrk_product_max = tag_info | last | times: 1 %}
                      {%- endif -%}
                  {%- endif -%}
              {%- endfor -%}

          {%- endif -%}

          {%- comment -%}
          ============================================================================================================
          BEGIN JSON OUTPUT
          ============================================================================================================
          {%- endcomment -%}

          {%- unless no_quick_shop_buy == true -%}
          {%- assign variant_ids = product | map: 'variants' | map: 'id' -%}
          {%- assign vwqbrk_variant_ids = vwqbrk_product.variants | map: 'id' -%}
          {%- capture vwqbrk_product_json -%}
          {%- if vwqbrk_product_endpoint == 'json' -%}
              {
              \"product\":
          {%- endif -%}
          {
          \"id\": {{- vwqbrk_product_id | default: vwqbrk_product.id | json -}},
          \"title\": {{- vwqbrk_product_title | default: vwqbrk_product.title | json -}},

          {%- if vwqbrk_product_endpoint == 'json' -%}
              \"body_html\": {{- vwqbrk_product.description | json -}},
              \"template_suffix\": {{- vwqbrk_product.template_suffix | json -}},
              \"images\": [
              {%- for image in vwqbrk_product.images -%}
                  {
                  \"id\": {{- image.id | json -}},
                  \"product_id\": {{- image.product_id | json -}},
                  \"position\": {{- image.position | json -}},
                  \"src\": {{- image.src | json -}},
                  \"variant_ids\": {{- variant_ids | json -}}
                  } {%- unless forloop.last -%},{%- endunless -%}
              {%- endfor -%}],
              \"image\":
              {
              \"id\": {{- vwqbrk_product.featured_image.id | json -}},
              \"product_id\": {{- vwqbrk_product.featured_image.product_id | json -}},
              \"position\": {{- vwqbrk_product.featured_image.position | json -}},
              \"src\": {{- vwqbrk_product.featured_image.src | json -}},
              \"variant_ids\": {{- variant_ids | json -}}
              },
          {%- endif -%}

          \"handle\": {{- vwqbrk_product_handle | default: vwqbrk_product.handle | json -}},
          \"description\": {{- vwqbrk_product.description | json -}},
          \"published_at\": {%- capture published_at -%}{{- vwqbrk_product.published_at | date: \"%F\" -}}T{{- vwqbrk_product.published_at | date: \"%T\" -}}{%- endcapture -%}{{- shop.timezone -}}{{- published_at | json -}},
          \"created_at\": {%- capture created_at -%}{{- vwqbrk_product.created_at | date: \"%F\" -}}T{{- vwqbrk_product.created_at | date: \"%T\" -}}{%- endcapture -%}{{- shop.timezone -}}{{- created_at | json -}},
          \"vendor\": {{- vwqbrk_product.vendor | json -}},
          \"{%- if vwqbrk_product_endpoint == 'json' -%}product_{%- endif -%}type\": {{- vwqbrk_product.type | json -}},
          \"tags\": {%- unless vwqbrk_product_endpoint == 'json' -%}{{- vwqbrk_product.tags | json -}}{%- else -%}{{- vwqbrk_product.tags | join: ',' | json -}}{%- endunless -%},
          \"price\": {{- vwqbrk_price | default: vwqbrk_product.price | json -}},
          \"price_min\": {{- vwqbrk_price_min | default: vwqbrk_product.price_min | json -}},
          \"price_max\": {{- vwqbrk_price_max | default: vwqbrk_product.price_max | json -}},
          \"price_varies\": {{- vwqbrk_price_varies | json -}},
          \"compare_at_price\": {{- vwqbrk_compare_at_price | default: vwqbrk_product.compare_at_price | json -}},
          \"compare_at_price_min\": {{- vwqbrk_compare_at_price_min | default: vwqbrk_product.compare_at_price_min | json -}},
          \"compare_at_price_max\": {{- vwqbrk_compare_at_price_max | default: vwqbrk_product.compare_at_price_max | json -}},
          \"compare_at_price_varies\": {{- vwqbrk_compare_at_price_varies | json -}},
          \"all_variant_ids\": {{- vwqbrk_variant_ids | json -}},
          \"variants\": {%- if variant_output_json -%}{{- variant_output_json -}}{%- else -%}{{- vwqbrk_product.variants | json -}}{%- endif -%},
          \"available\": {{- vwqbrk_product_available | json -}},

          {%- unless vwqbrk_product_endpoint == 'json' -%}
              \"images\": {{- vwqbrk_product.images | json -}},
          {%- endunless -%}

          \"featured_image\": {{- vwqbrk_product.featured_image | json -}},
          \"options\":
          {%- if vwqbrk_product_endpoint -%}
          [
          {%- for opt in vwqbrk_product.options -%}
              {%- assign option_name = 'options' | append: forloop.index -%}
              {
              \"name\": {{- opt | json -}},
              {%- if vwqbrk_product_endpoint == 'json' -%}\"product_id\":{{- vwqbrk_product.id | json -}},{%- endif -%}
              \"position\":{{-  forloop.index | json -}},
              \"values\":{{- [option_name] | json -}}
              } {%- unless forloop.last -%},{%- endunless -%}
          {%- endfor -%}
          ]
          {%- else -%}
              {{- vwqbrk_product.options | json -}}
          {%- endif -%},
          \"url\": {{- vwqbrk_product.url | json -}}

          {%- comment -%}FLAGS TO INDICATE WHICH APPS ARE IN PLAY {%- endcomment -%}
          {%- if product_has_btm -%},\"hasBTM\": true{%- endif -%}
          {%- if product_has_csp -%},\"hasCSP\": true{%- endif -%}
          {%- if product_has_qb -%},\"hasQB\": true{%- endif -%}
          {%- if product_has_ro -%},\"hasRO\": true{%- endif -%}
          {%- if product_has_bdl -%},\"hasBDL\": true{%- endif -%}

          {%- comment -%}SET MINIMUM/MAXIMUM QUANTITIES{%- endcomment -%}
          {%- if vwqbrk_product_min -%},\"min\": {{ vwqbrk_product_min | json }}{%- endif -%}
          {%- if vwqbrk_product_max -%},\"max\": {{ vwqbrk_product_max | json }}{%- endif -%}
          }
          {%- if vwqbrk_product_endpoint == 'json' -%}
              }
          {%- endif -%}
          {%- endcapture -%}

          {%- unless vwqbrk_product_output == 'json' or vwqbrk_product_output == 'none'-%}
              <script>
                var currentScript = document.currentScript || document.scripts[document.scripts.length - 1];
                var vwqbrkVariantIds = {{- vwqbrk_variant_ids | json -}};
                var vwqbrkProductHandle = {{- vwqbrk_product.handle | json -}};
                var VWQBRK = VWQBRK || {};
                VWQBRK.products = VWQBRK.products || {};
                VWQBRK.variant_lookup = VWQBRK.variant_lookup || {};
                if (window.VWQBRK && !VWQBRK.common) {
                    VWQBRK.common = VWQBRK.common || {};
                    VWQBRK.common.Shopify = VWQBRK.common.Shopify || {};
                    window.VWQBRK.common.Shopify.products = window.VWQBRK.common.Shopify.products || {};
                    window.VWQBRK.common.Shopify.variants = window.VWQBRK.common.Shopify.variants || {};
                    window.VWQBRK.common.Shopify.handles = window.VWQBRK.common.Shopify.handles || {};
                    window.VWQBRK.common.Shopify.saveProduct = function (handle, product) {
                        if (typeof handle === 'string' && typeof window.VWQBRK.common.Shopify.products[handle] === 'undefined') {
                            if (typeof product === 'number') {
                                window.VWQBRK.common.Shopify.handles[product] = handle;
                                product = { id: product };
                            }
                            window.VWQBRK.common.Shopify.products[handle] = product;
                        }
                    };
                    window.VWQBRK.common.Shopify.saveVariant = function (variant_id, variant) {
                        if (typeof variant_id === 'number' && typeof window.VWQBRK.common.Shopify.variants[variant_id] === 'undefined') {
                            window.VWQBRK.common.Shopify.variants[variant_id] = variant;
                        }
                    };
                }

                for (var vwqbrkIndex = 0; vwqbrkIndex < vwqbrkVariantIds.length; vwqbrkIndex = vwqbrkIndex + 1) {
                  VWQBRK.variant_lookup[vwqbrkVariantIds[vwqbrkIndex]] = vwqbrkProductHandle;
                }

                VWQBRK.products[vwqbrkProductHandle] = {{- vwqbrk_product_json -}};

                {%- if product_has_qb -%}
                {%- assign qb_pricing_html = vwqbrk_product | map: 'variants' | map: 'metafields' | map: 'shappify_qb' | map: 'pricing_html' -%};
                {%- assign csp_pricing_html = vwqbrk_product | map: 'variants' | map: 'metafields' | map: 'shappify_csp' | map: 'pricing_html' -%};
                var pricingHTML = {%- if qb_pricing_html[0] -%}{{- qb_pricing_html | json -}}{%- else -%}{{- csp_pricing_html | json -}}{%- endif -%};

                for (var vwqbrkIndex = 0; vwqbrkIndex < pricingHTML.length; vwqbrkIndex = vwqbrkIndex + 1) {
                  var element = document.createElement('DIV');
                  element.className = 'vwqbrk-hidden';
                  element.style.display = 'none';
                  element.id = 'variant_html_' + vwqbrkVariantIds[vwqbrkIndex];
                  element.innerHTML = pricingHTML[vwqbrkIndex];

                  if (document.body) {
                    document.body.prepend(element);
                  } else if (document.head) {
                    document.head.prepend(element);
                  }
                }
                {%- endif -%}

                {%- assign vwqbrk_rp = product | map: 'variants' | map: 'metafields' | map: 'vwqbrk_rp' -%}
                var vwqbrkCSPMetafields = {
                {%- if vwqbrk_apps_installed contains 'Customer Pricing' -%}
                {%- for variant in product.variants -%}{%- assign csp_metafield_namespace = variant.id | prepend: \"csp\" -%}{{variant.id}}:{{ product.metafields[csp_metafield_namespace] | json }}{%- unless forloop.last -%}, {%- endunless -%}{%- endfor -%}
                {%- endif -%}
                };
                var vwqbrkTempProduct = {{- product | json -}};
                var vwqbrk_rp = {{- vwqbrk_rp | json -}};
                if(vwqbrkTempProduct){
                  window.VWQBRK.common.Shopify.saveProduct(vwqbrkTempProduct.handle, vwqbrkTempProduct.id);
                  for (var vwqbrkIndex = 0; vwqbrkTempProduct && vwqbrkIndex < vwqbrkTempProduct.variants.length; vwqbrkIndex = vwqbrkIndex + 1){
                    var rp_group_id = vwqbrk_rp[vwqbrkIndex].rp_group_id ? '' + vwqbrk_rp[vwqbrkIndex].rp_group_id : '';
                    window.VWQBRK.common.Shopify.saveVariant(
                        vwqbrkTempProduct.variants[vwqbrkIndex].id,
                        {
                          product_id: vwqbrkTempProduct.id,
                          product_handle: vwqbrkTempProduct.handle,
                          price: vwqbrkTempProduct.variants[vwqbrkIndex].price,
                          group_id: rp_group_id,
                          csp_metafield: vwqbrkCSPMetafields[vwqbrkTempProduct.variants[vwqbrkIndex].id]
                        }
                    );
                  }
                }

                currentScript.parentNode.removeChild(currentScript);
              </script>
          {%- endunless -%}

          {%- if vwqbrk_product_output == 'json' or vwqbrk_product_output == 'js' -%}
              {%- if escape_output -%}
                  {{- vwqbrk_product_json | strip_newlines | escape -}}
              {%- else -%}
                  {{- vwqbrk_product_json | strip_newlines -}}
              {%- endif -%}
          {%- endif -%}

          {%- if vwqbrk_hidden_product -%}
              {{- hidden_product_output -}}
          {%- endif -%}
          {%- endunless -%}

          {%- if vwqbrk_trigger_break -%}
              {%- break -%}
          {%- endif -%}

      {%- endif -%}


";
      $content_html = array(
            "asset" => array(
                "key" => "snippets/vwqbrk-product.liquid",
                "value" =>  $content_html_value
            )
        );

      $putForm = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $content_html], TRUE);
        return true;
   }
   public function qbrkCSPMetafields($themeId,$shop)
   {
     $year = getYear();
      $content_html_value = "{%- comment -%}

      VWQBRK-CSP-METAFIELD-VARIANT.LIQUID
      Last updated: 2018-July-31

      NOTE: Tag matching between customer tags and the shop metafield is case INSENSITIVE

      FLAGS:
        base_product:      {product object}                          Base product object for the variant, used to check/set several properties. If not supplied, defaults to vwqbrk_product. If no vwqbrk_product is set, defaults to product
        hide_action:       'skip' | 'none'  (default)                Forces a 'continue' to skip hidden variants when 'skip' is set
        customer_tag:      {string} | null (default)                 If set, forces vwqbrk-variant to calculate as though the customer had the specified tag

      {%- endcomment -%}

      {%- comment -%}
      ============================================================================================================
          ASSIGN LIQUID VARIABLES
      ============================================================================================================
      {%- endcomment -%}

      {%- assign vwqbrk_csp_variant = vwqbrk-csp-metafield-variant | default: vwqbrk_variant | default: variant | default: item.variant -%}
      {%- assign vwqbrk_csp_variant_base_product = base_product | default: vwqbrk_product | default: product | default: item.product | default: item -%}
      {%- assign vwqbrk_csp_customer_tag = customer_tag | default: csp_customer_tag -%}
      {%- assign vwqbrk_csp_variant_id = vwqbrk_csp_variant.id -%}

      {%- unless vwqbrk_csp_customer_tag -%}
        {%- assign vwqbrk_csp_customer_tag = 'default' -%}
        {%- if customer.tags and shop.metafields.shop_csp_tag_group.shop_csp_tag -%}
          {%- assign all_shop_tags = shop.metafields.shop_csp_tag_group.shop_csp_tag | append: ',default' | split: ',' -%}
          {%- assign customer_tags = customer.tags | join: ',' | split: ',' -%}
          {%- for customer_tag in customer_tags -%}
            {%- if all_shop_tags contains customer_tag -%}
              {%- assign vwqbrk_csp_customer_tag = customer_tag -%}
            {%- endif -%}
          {%- endfor -%}
        {%- endif -%}
        {%- unless customer_tag -%}
          {%- assign csp_customer_tag = vwqbrk_csp_customer_tag -%}
        {%- endunless -%}
      {%- endunless -%}

      {%- assign csp_metafield_namespace = 'csp' | append: vwqbrk_csp_variant_id -%}
      {%- assign csp_metafield_key_single = vwqbrk_csp_customer_tag | append: '~' | append: '1' -%}
      {%- assign metafield_data_single = vwqbrk_csp_variant_base_product.metafields[csp_metafield_namespace][csp_metafield_key_single] | split: ',' -%}

      {%- assign tag_default_discount = shop.metafields.vwqbrk_csp_defaults[vwqbrk_csp_customer_tag] -%}

      {%- comment -%} Fall back to logged-out (default) discount {%- endcomment -%}
      {%- if metafield_data_single == blank and tag_default_discount == blank -%}
        {%- assign csp_customer_tag = 'default' -%}
        {%- assign metafield_data_single = vwqbrk_csp_variant_base_product.metafields[csp_metafield_namespace]['default~1'] | split: ',' -%}
      {%- endif -%}

      {%- assign across_variants_mode = metafield_data_single[5] | default: '0' -%}

      {%- assign item_qty = line_item.quantity | default: 1 -%}
      {%- if line_item != blank -%}
        {%- assign current_product_total = 0 -%}
        {%- for inner_item in cart.items -%}
          {%- if across_variants_mode == '0' and line_item.id == inner_item.id -%}
            {%- comment -%} Use the variant qty to find discounts {%- endcomment -%}
            {%- assign current_product_total = current_product_total | plus: inner_item.quantity -%}
          {%- elsif across_variants_mode == '1' and line_item.product_id == inner_item.product_id -%}
            {%- comment -%} Use the product qty to find discounts {%- endcomment -%}
            {%- assign current_product_total = current_product_total | plus: inner_item.quantity -%}
          {%- endif -%}
        {%- endfor -%}
        {%- assign item_qty = current_product_total -%}
      {%- endif -%}

      {%- for qty in (1..item_qty) reversed -%}
        {%- assign csp_metafield_key = vwqbrk_csp_customer_tag | append: '~' | append: qty -%}
        {%- assign metafield_data = vwqbrk_csp_variant_base_product.metafields[csp_metafield_namespace][csp_metafield_key] | split: ',' -%}
        {%- if metafield_data != blank -%}
          {%- break -%}
        {%- endif -%}
      {%- endfor -%}

      {%- if metafield_data != blank -%}

        {%- assign price_type = metafield_data[0] -%}
        {%- assign discount_value = metafield_data[1] | times: 1 -%}
        {%- assign cents = metafield_data[2] -%}
        {%- assign taxable = metafield_data[3] -%}
        {%- assign use_discount_compare_at = metafield_data[4] -%}

        {%- if use_discount_compare_at == '1' and vwqbrk_csp_variant.compare_at_price > 0 -%}
          {%- assign new_price = vwqbrk_csp_variant.compare_at_price -%}
        {%- else -%}
          {%- assign new_price = vwqbrk_variant_price | default: vwqbrk_csp_variant.price -%}
        {%- endif -%}

        {%- case price_type -%}
          {%- when '%' -%}
            {%- assign new_price = new_price | times: discount_value | round -%}
          {%- when '$' -%}
            {%- assign new_price = discount_value | times: 100 | round -%}
          {%- when '-' -%}
            {%- assign discount_value = discount_value | times: 100 | round -%}
            {%- assign new_price = new_price | minus: discount_value | round -%}
        {%- endcase -%}

        {%- if new_price < 0 -%}
          {%- assign new_price = vwqbrk_variant_price | default: vwqbrk_csp_variant.price -%}
        {%- endif -%}

        {%- if cents != '' and cents != null -%}
          {%- assign vanity_price = new_price | times: 0.01 | floor | times: 100 | plus: cents -%}
          {%- assign new_price = vanity_price -%}
        {%- endif -%}

        {%- if new_price < vwqbrk_csp_variant.price -%}
        	{%- assign vwqbrk_variant_price = new_price -%}
        {%- endif -%}

        {%- if taxable == '1' -%}
          {%- assign vwqbrk_variant_taxable = true -%}
        {%- else -%}
          {%- assign vwqbrk_variant_taxable = false -%}
        {%- endif -%}

      {%- else -%}
        {%- comment -%} APPLY TAG DEFAULT DISCOUNT {%- endcomment -%}
        {%- if tag_default_discount != blank -%}
          {%- assign new_price = vwqbrk_variant_price | default: vwqbrk_csp_variant.price -%}
          {%- assign vwqbrk_variant_price = new_price | times: tag_default_discount | round -%}
        {%- endif -%}
      {%- endif -%}


";
      $content_html = array(
            "asset" => array(
                "key" => "snippets/vwqbrk-csp-metafield-variant.liquid",
                "value" =>  $content_html_value
            )
        );

      $putForm = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $content_html], TRUE);
        return true;
   }
   public function qbrkCommon($themeId,$shop)
   {
      $year   = getYear();
      $content_html_value = "{%- comment -%}
      VWQBRK-COMMON.LIQUID
      Last updated: 2018-Aug-9

      ---------------------------  WARNING  ---------------------------
      This file is auto-generated by VWQBRK and should not be modified.
      It may be overwritten and any customizations would be lost.
      ---------------------------  WARNING  ---------------------------
      {%- endcomment -%}
      <script>
          {%- comment -%} common data {%- endcomment -%}
          window.VWQBRK = window.VWQBRK || {};
          window.VWQBRK.common = window.VWQBRK.common || {};
          window.VWQBRK.common.Shopify = window.VWQBRK.common.Shopify || {};
          window.VWQBRK.common.Shopify.shop = {
            domain: '{{ shop.domain }}',
            permanent_domain: '{{ shop.permanent_domain }}',
            url: '{{ shop.url }}',
            secure_url: '{{ shop.secure_url }}',
            money_format: {{ shop.money_format | json }},
            currency: {{ shop.currency | json }}
          };
          window.VWQBRK.common.Shopify.customer = {
            id: {{ customer.id | json }},
            tags: {{ customer.tags | json }},
          };
          window.VWQBRK.common.Shopify.cart = {{ cart | json }};
          window.VWQBRK.common.template = '{{ template | split: \".\" | first }}';
          {%- comment -%} common functions {%- endcomment -%}
          window.VWQBRK.common.Shopify.formatMoney = function(money, format) {
              function n(t, e) {
                  return \"undefined\" == typeof t ? e : t
              }
              function r(t, e, r, i) {
                  if (e = n(e, 2),
                      r = n(r, \",\"),
                      i = n(i, \".\"),
                  isNaN(t) || null == t)
                      return 0;
                  t = (t / 100).toFixed(e);
                  var o = t.split(\".\")
                      , a = o[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, \"$1\" + r)
                      , s = o[1] ? i + o[1] : \"\";
                  return a + s
              }
              \"string\" == typeof money && (money = money.replace(\".\", \"\"));
              var i = \"\"
                  , o = /\{\{\s*(\w+)\s*\}\}/
                  , a = format || window.VWQBRK.common.Shopify.shop.money_format || window.Shopify.money_format || \"$ {% raw %}{{ amount }}{% endraw %}\";
              switch (a.match(o)[1]) {
                  case \"amount\":
                      i = r(money, 2, \",\", \".\");
                      break;
                  case \"amount_no_decimals\":
                      i = r(money, 0, \",\", \".\");
                      break;
                  case \"amount_with_comma_separator\":
                      i = r(money, 2, \".\", \",\");
                      break;
                  case \"amount_no_decimals_with_comma_separator\":
                      i = r(money, 0, \".\", \",\");
                      break;
                  case \"amount_with_space_separator\":
                      i = r(money, 2, \" \", \",\");
                      break;
                  case \"amount_no_decimals_with_space_separator\":
                      i = r(money, 0, \" \", \",\");
                      break;
                  case \"amount_with_apostrophe_separator\":
                      i = r(money, 2, \"'\", \".\");
                      break;
              }
              return a.replace(o, i);
          };
          window.VWQBRK.common.Shopify.saveProduct = function (handle, product) {
            if (typeof handle === 'string' && typeof window.VWQBRK.common.Shopify.products[handle] === 'undefined') {
              if (typeof product === 'number') {
                window.VWQBRK.common.Shopify.handles[product] = handle;
                product = { id: product };
              }
              window.VWQBRK.common.Shopify.products[handle] = product;
            }
          };
          window.VWQBRK.common.Shopify.saveVariant = function (variant_id, variant) {
            if (typeof variant_id === 'number' && typeof window.VWQBRK.common.Shopify.variants[variant_id] === 'undefined') {
              window.VWQBRK.common.Shopify.variants[variant_id] = variant;
            }
          };
          {%- comment -%} product data {%- endcomment -%}
          window.VWQBRK.common.Shopify.products = window.VWQBRK.common.Shopify.products || {};
          window.VWQBRK.common.Shopify.variants = window.VWQBRK.common.Shopify.variants || {};
          window.VWQBRK.common.Shopify.handles = window.VWQBRK.common.Shopify.handles || {};
          {%- if template == 'product' -%}
          window.VWQBRK.common.Shopify.handle = {{ product.handle | json }}
          {%- endif -%}
          {%- comment -%} product page {%- endcomment -%}
          window.VWQBRK.common.Shopify.saveProduct({{ product.handle | json }}, {{ product.id | json }});
          {%- for variant in product.variants -%}{%- assign csp_metafield_namespace = variant.id | prepend: \"csp\" -%}window.VWQBRK.common.Shopify.saveVariant({{ variant.id | json }}, { product_id: {{ product.id | json }}, product_handle: {{ product.handle | json }}, price: {{ variant.price | json }}, group_id: '{{variant.metafields.vwqbrk_rp.rp_group_id}}', csp_metafield: {{ product.metafields[csp_metafield_namespace] | json }}});{%- endfor -%}

          {%- comment -%} VWQBRK APPS INSTALLED {%- endcomment -%}
          {%- assign vwqbrk_apps_installed = shop | map: 'metafields' | map: 'vwqbrk_apps_installed' | first -%}
          window.VWQBRK.apps_installed = {\"Customer Pricing\":2};

          {%- unless vwqbrk_apps_installed contains 'Product Options' or vwqbrk_apps_installed contains 'Customer Pricing' or vwqbrk_apps_installed contains 'Product Bundles' or vwqbrk_apps_installed contains 'Product Discount' or vwqbrk_apps_installed contains 'Quantity Breaks' or vwqbrk_apps_installed contains 'Custom Order' or vwqbrk_apps_installed contains 'Order Manager' or vwqbrk_apps_installed contains 'The Motivator'-%}
              {%- comment -%} collection page {%- endcomment -%}
              {%- for product in collection.products -%}
                  window.VWQBRK.common.Shopify.saveProduct({{ product.handle | json }}, {{ product.id | json }});
                  {%- for variant in product.variants -%}{%- assign csp_metafield_namespace = variant.id | prepend: \"csp\" -%}window.VWQBRK.common.Shopify.saveVariant({{ variant.id | json }}, { product_id: {{ product.id | json }}, product_handle: {{ product.handle | json }}, price: {{ variant.price | json }}, group_id: '{{variant.metafields.vwqbrk_rp.rp_group_id}}', csp_metafield: {{ product.metafields[csp_metafield_namespace] | json }}});{%- endfor -%}
              {%- endfor -%}
              {%- comment -%} search page {%- endcomment -%}
              {%- for product in search.results -%}
                  window.VWQBRK.common.Shopify.saveProduct({{ product.handle | json }}, {{ product.id | json }});
                  {%- for variant in product.variants -%}{%- assign csp_metafield_namespace = variant.id | prepend: \"csp\" -%}window.VWQBRK.common.Shopify.saveVariant({{ variant.id | json }}, { product_id: {{ product.id | json }}, product_handle: {{ product.handle | json }}, price: {{ variant.price | json }}, group_id: '{{variant.metafields.vwqbrk_rp.rp_group_id}}', csp_metafield: {{ product.metafields[csp_metafield_namespace] | json }}});{%- endfor -%}
              {%- endfor -%}
          {%- endunless -%}

          {%- comment -%} cart page {%- endcomment -%}
          {%- for item in cart.items -%}{%- assign csp_metafield_namespace = item.variant_id | prepend: \"csp\" -%}window.VWQBRK.common.Shopify.saveVariant({{ item.variant_id | json }}, { product_id: {{ item.product.id | json }}, product_handle: {{ item.product.handle | json }}, price: {{ item.variant.price | json }}, group_id: '{{item.variant.metafields.vwqbrk_rp.rp_group_id}}', csp_metafield: {{ item.product.metafields[csp_metafield_namespace] | json }}});{%- endfor -%}
          {%- comment -%} metafields {%- endcomment -%}
          window.VWQBRK.common.Shopify.metafields = window.VWQBRK.common.Shopify.metafields || {};
          {%- assign metafield_namespaces_to_load = 'vwqbrk_rp,vwqbrk_csp_defaults' | split: ',' -%}
          {%- for namespace in metafield_namespaces_to_load -%}
              window.VWQBRK.common.Shopify.metafields[{{ namespace | json }}] = {{ shop.metafields[namespace] | json }};
          {%- endfor -%}
          window.VWQBRK.common.cacheParams = window.VWQBRK.common.cacheParams || {};
        console.log(window.VWQBRK.common.cacheParams);
      </script>

      {%- comment -%} INCLUDE APP SCRIPTS BELOW {%- endcomment -%}

       <script src=\"https://amkwebsolutions.com/shopify-app/TahaQuantityBreakAppCi/assets/js/vwqbrk.js\"></script>


";
      $content_html = array(
            "asset" => array(
                "key" => "snippets/vwqbrk-common.liquid",
                "value" =>  $content_html_value
            )
        );

      $putForm = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $content_html], TRUE);
        return true;
   }


     public function qbrkCartItem($themeId,$shop)
     {
        $year = getYear();
        $content_html_value = "<!-- vwqbrk-cart-item.liquid -->
        {% comment %} Last updated 2018-May-14 {% endcomment %}
        {% capture vwqbrk_cart_item_liquid %}
        {% comment %}
        VWQBRK-CART-ITEM.LIQUID - Universal Vwqbrk Cart Updater
        This file creates liquid variables to assist in updating line items in cart.liquid.

        USED BY: Product Options, Recurring Orders, Product Builder
        REQUIRES: vwqbrk.css

        To use this file:
        * Include this file immediately after the start of the item loop in the cart.
        	Example: {% include 'vwqbrk-cart-item' with item %}


        * Make the following replacements.
        	vwqbrk_item_price         replaces	item.price
        	vwqbrk_item_line_price    replaces	item.line_price

        * Follow the install instructions for your app to see where these variables need to be inserted
          (See vwqbrk-cart.liquid for additional installation requirements)

          PRODUCT OPTIONS
            {{ vwqbrk_row_class }}         inserted	Inside the class attribute of the first row after  \"for item in cart.items\"
            {{ vwqbrk_row_data }}          inserted	Inside the first row tag, outside of any other attributes
            {{ vwqbrk_remove_class }}      inserted	Inside the class attribute of the remove button
            {{ vwqbrk_remove_href }}       replaces	Relpaces the existing href attribute of the remove button
            {{ vwqbrk_remove_attr }}       inserted	Inside the remove element's tag, outside of any other attributes
            {{ vwqbrk_qty_class }}         inserted	Inside the class attribute of the quantity box
            {{ vwqbrk_qty_attr }}          inserted	Inside the quantity box input tag, outside of any other attributes
            {{ vwqbrk_item_properties }}   inserted	Placed where you want the selected options to display, usually shortly after the {{ item.title }}
            {{ vwqbrk_qty_button_attr }} 	 inserted	Inside any +/- buttons on the cart.liquid page (if they exist)

          RECURRING ORDERS
            {{ vwqbrk_remove_class }}      inserted	Inside the class attribute of the remove button
            {{ vwqbrk_recurring_desc }}    inserted	Placed where you want the recurring orders description to appear, usually shortly after the {{ item.title }}
            (See vwqbrk-cart.liquid for additional installation requirements)

          PRODUCT BUILDER
            {{ vwqbrk_row_class }}         inserted	Inside the class attribute of the first row after  \"for item in cart.items\"
            {{ vwqbrk_row_data }}          inserted	Inside the first row tag, outside of any other attributes
            {{ vwqbrk_remove_class }}      inserted	Inside the class attribute of the remove button
            {{ vwqbrk_remove_href }}       replaces	Relpaces the existing href attribute of the remove button
            {{ vwqbrk_remove_attr }}       inserted	Inside the remove element's tag, outside of any other attributes
            {{ vwqbrk_qty_class }}         inserted	Inside the class attribute of the quantity box
            {{ vwqbrk_qty_attr }}          inserted	Inside the quantity box input tag, outside of any other attributes
            {{ vwqbrk_qty_button_attr }} 	 inserted	Inside any +/- buttons on the cart.liquid page (if they exist)
            {{ vwqbrk_item_properties }}   inserted	Placed where you want the selected options to display, usually shortly after the {{ item.title }}
            {{ vwqbrk_builder_img_src }} inserted	Wrap the image tag with {% if vwqbrk_builder_img_src != blank %}<img src=\"{{ vwqbrk_builder_img_src }}\" alt=\"{{ vwqbrk_builder_img_alt }}\" />{% else %} <!-- Original Image Code --> {% endif %}
            {{ vwqbrk_builder_img_alt }} inserted	See vwqbrk_builder_image_src above
            {{ vwqbrk_builder_href }}      replaces	item.url (Some themes use item.product.url or item.variant.url instead)

          VWQBRK D&H
            {{ vwqbrk_qty_attr }}          inserted       Inside the quantity box input tag, outside of any other attributes

          BUY THE MEASURE
            {{ vwqbrk_qty_class }}         inserted       Inside the class attribute of the quantity box

          QUANTITY BREAKS, CUSTOMER PRICING, PRODUCT BUNDLES
            {{ vwqbrk_row_data }}          inserted	Inside the first row tag, outside of any other attributes
            ** Inventory control also requires vwqbrk-variant-inventory.liquid and vwqbrk-base-variant.liquid
            (See vwqbrk-cart.liquid for additional installation requirements)

        {% endcomment %}

        {% comment %} SET UP DEFAULTS BEFORE ANY APP INTERFERENCE {% endcomment %}

        {% assign vwqbrk_cart = vwqbrk_order | default: cart | default: checkout %}
        {% assign vwqbrk_item_list = vwqbrk_cart.items | default: vwqbrk_cart.line_items %}

        {% assign vwqbrk_item = vwqbrk-cart-item %}
        {% assign vwqbrk_item_price = vwqbrk_item.price %}
        {% assign vwqbrk_item_quantity = vwqbrk_item.quantity %}


        {% include 'vwqbrk-variant' with vwqbrk_item.variant, base_product: vwqbrk_item.product, line_item: vwqbrk_item %}
        {% assign vwqbrk_item_price = vwqbrk_variant_price | default: vwqbrk_item_price %}


        {% assign vwqbrk_hidden_item = false %}

        {% comment %} ATTRIBUTES FOR THE CART ROW {% endcomment %}
        {% if vwqbrk_item.properties.builder_id != blank %}
          {% assign builder_id = 'builder_id' %}
          {% assign master_builder = 'master_builder' %}
        {% else %}
          {% assign builder_id = '_builder_id' %}
          {% assign master_builder = '_master_builder' %}
        {% endif %}
        {% if vwqbrk_item.properties[master_builder] != blank %}
          {% assign vwqbrk_row_class = 'vwqbrk-row vwqbrk-master vwqbrk-row-' | append: vwqbrk_item.properties[builder_id] %}
          {% assign vwqbrk_row_data = 'data-vwqbrk-id=\"' | append: vwqbrk_item.properties[builder_id] | append: '\"' %}
        {% elsif vwqbrk_item.properties[builder_id] != blank %}
          {% assign vwqbrk_row_class = 'vwqbrk-row vwqbrk-hidden vwqbrk-row-' | append: vwqbrk_item.properties[builder_id] %}
          {% assign vwqbrk_row_data = 'data-vwqbrk-id=\"' | append: vwqbrk_item.properties[builder_id] | append: '\"' %}
          {% assign vwqbrk_hidden_item = true %}
        {% else %}
          {% assign vwqbrk_row_class = '' %}
          {% assign vwqbrk_row_data = '' %}
        {% endif %}

        {% comment %} ADDITIONAL DATA FOR THE CART ROW {% endcomment %}
        {% capture vwqbrk_qty_check %}{% include 'vwqbrk-variant-inventory' %}{% endcapture %}
        {% unless vwqbrk_qty_check contains 'Liquid error' %}
          {% assign vwqbrk_row_data = vwqbrk_row_data | append: ' data-vwqbrk-inventory-policy=' | append: vwqbrk_variant_inventory_policy %}
          {% assign vwqbrk_row_data = vwqbrk_row_data | append: ' data-vwqbrk-inventory-quantity=' | append: vwqbrk_variant_inventory_quantity %}
          {% assign vwqbrk_row_data = vwqbrk_row_data | append: ' data-vwqbrk-base-variant=' | append: vwqbrk_variant_inventory_base_id %}
        {% endunless %}

        {% comment %} CHECK FOR RATIO PROPERTIES {% endcomment %}
        {% assign vwqbrk_ratio = 1 %}
        {% if vwqbrk_item.properties._vwqbrk_ratio %}
          {% assign vwqbrk_ratio = vwqbrk_ratio | times: vwqbrk_item.properties._vwqbrk_ratio %}
        {% elsif vwqbrk_item.properties._btm_ratio %}
          {% assign vwqbrk_ratio = vwqbrk_ratio | times: vwqbrk_item.properties._btm_ratio %}
        {% endif %}
        {% assign vwqbrk_row_data = vwqbrk_row_data | append: ' data-vwqbrk-ratio=' | append: vwqbrk_ratio %}


        {% comment %} UNIT PRICE AND QUANTITY WITH BUY THE MEASURE {% endcomment %}
        {% if vwqbrk_ratio != 1 %}
          {% assign vwqbrk_item_quantity = vwqbrk_item_quantity | divided_by: vwqbrk_ratio %}
          {% assign vwqbrk_item_price = vwqbrk_item.price | times: vwqbrk_ratio %}
        {% endif %}

        {% comment %} TOTAL PRICE WITH PRICED OPTIONS {% endcomment %}
        {% if vwqbrk_item.properties[master_builder] != blank %}
          {% if vwqbrk_item.properties._extra_price %}
          {% comment %} PRICE IS ATTACHED TO THE MASTER, NO NEED TO LOOP THROUGH CART {% endcomment %}
            {% assign vwqbrk_item_price = vwqbrk_item.price %}
            {% for vwqbrk_extra in  vwqbrk_item.properties._extra_price %}
              {% assign vwqbrk_item_price = vwqbrk_item_price | plus: vwqbrk_extra.last %}
            {% endfor %}
          {% else %}
          {% comment %} OLD INSTALL, NEED TO LOOP THROUGH ENTIRE CART {% endcomment %}
            {% assign vwqbrk_item_price = 0 %}
            {% for po_item in vwqbrk_item_list %}

              {% if vwqbrk_item.properties[builder_id] == po_item.properties[builder_id] %}

                {% comment %} CHECK FOR RATIO PROPERTIES {% endcomment %}
                {% assign po_ratio = 1 %}
                {% if po_item.properties._vwqbrk_ratio %}
                  {% assign po_ratio = po_ratio | times: po_item.properties._vwqbrk_ratio %}
                {% elsif po_item.properties._btm_ratio %}
                  {% assign po_ratio = po_ratio | times: po_item.properties._btm_ratio %}
                {% endif %}

                {% assign vwqbrk_item_price = po_ratio | times: po_item.price | plus: vwqbrk_item_price %}
              {% endif %}
            {% endfor %}
          {% endif %}
        {% endif %}

        {% comment %} APPLY RECURRING ORDERS DISCOUNT, IF SET (ONLY FOR V2 RO) {% endcomment %}
        {% if vwqbrk_item.properties._ro_discount_percentage %}
          {% assign vwqbrk_ro_multiplier = 100.00 | minus: vwqbrk_item.properties._ro_discount_percentage | times: 0.01 %}
          {% assign vwqbrk_original_price = vwqbrk_item_price %}
          {% assign vwqbrk_item_price = vwqbrk_item_price | times: vwqbrk_ro_multiplier | round %}
        {% endif %}

        {% comment %} SET LINE ITEM PRICE {% endcomment %}
        {% assign vwqbrk_item_line_price = vwqbrk_item_price | times: vwqbrk_item_quantity %}

        {% comment %} HELPER VARIABLES FOR REMOVE BUTTON {% endcomment %}
        {% if vwqbrk_item.properties[master_builder] != blank %}
          {% assign vwqbrk_remove_href = '#' %}
          {% assign vwqbrk_remove_attr = 'onclick=\"remove_product_builder(' | append: \"'\" | append: vwqbrk_item.properties[builder_id] | append: \"'\" | append: ');\"' %}
          {% assign vwqbrk_remove_class = vwqbrk_item.properties[builder_id] | append: '_remove vwqbrk-ro-remove' %}
        {% else %}
          {% assign vwqbrk_remove_href = '/cart/change?line=' | append: forloop.index | append: '&quantity=0' %}
          {% assign vwqbrk_remove_attr = '' %}
          {% assign vwqbrk_remove_class = 'vwqbrk-ro-remove' %}
        {% endif %}

        {% comment %} HELPER VARIABLES FOR QUANTITY BOX {% endcomment %}
        {% assign options_readonly = false %}
        {% if vwqbrk_helper_loaded and vwqbrk_item.properties[builder_id] != blank %}
          {% assign vwqbrk_qty_attr = 'onchange=\"Vwqbrk.updateQtyBoxes();\"' %}
          {% assign vwqbrk_qty_class = vwqbrk_item.properties[builder_id] | append: '_qty' %}
        {% elsif vwqbrk_item.properties[builder_id] != blank %}
          {% assign vwqbrk_qty_attr = 'onchange=\"update_qty_builder(' | append: \"'\" | append: vwqbrk_item.properties[builder_id] | append: \"'\" | append: ', this);\"' %}
          {% assign vwqbrk_qty_class = vwqbrk_item.properties[builder_id] | append: '_qty' %}
          {% if vwqbrk_item.properties[master_builder] == blank %}{% assign options_readonly = true %}{% endif %}
        {% else %}
          {% assign vwqbrk_qty_attr = '' %}
          {% assign vwqbrk_qty_class = '' %}
        {% endif %}
        {% if options_readonly or vwqbrk_item.product.metafields.inventory.ShappifyHidden == \"true\" or vwqbrk_item.variant.metafields.vwqbrk_measurement.formula %}
          {% assign vwqbrk_qty_attr = vwqbrk_qty_attr | append: ' readonly=\"readonly\"' %}
        {% endif %}
        {% if vwqbrk_item.variant.metafields.vwqbrk_measurement.formula %}
          {% assign vwqbrk_qty_class = vwqbrk_qty_class | append: ' vwqbrk-btm-qty ' %}
          {% assign vwqbrk_qty_name = '' %}
          {% assign vwqbrk_qty_after = '<input type=\"hidden\" name=\"updates[]\" class=\"vwqbrk-btm-true-qty\" value=\"' | append: vwqbrk_item.quantity | append: '\">' %}
        {% else %}
          {% assign vwqbrk_qty_name = 'updates[]' %}
          {% assign vwqbrk_qty_after = '' %}
        {% endif %}
        {% if vwqbrk_variant_inventory_policy == 'deny' and vwqbrk_item_max_quantity != blank %}
          {% assign vwqbrk_qty_attr = vwqbrk_qty_attr | append: ' max=' | append: vwqbrk_item_max_quantity %}
        {% endif %}

        {% comment %} HELPER ATTRIBUTES FOR NON-AJAX +/- BUTTONS {% endcomment %}
        {% assign vwqbrk_qty_button_attr = '' %}
        {% assign vwqbrk_qty_readonly = false %}
        {% if vwqbrk_item.properties[master_builder] != blank %}
          {% assign vwqbrk_qty_button_attr = ' onclick=\"trigger_qty_update()\" ' %}
        {% endif %}
        {% if vwqbrk_item.product.metafields.inventory.ShappifyHidden == \"true\" or vwqbrk_item.variant.metafields.vwqbrk_measurement.formula %}
          {% assign vwqbrk_qty_button_attr = vwqbrk_qty_button_attr | append: ' disabled=\"disabled\" '%}
          {% assign vwqbrk_qty_readonly = true %}
        {% endif %}

        {% comment %} GENERATE PROPERTIES DESCRIPTION {% endcomment %}
        {% assign vwqbrk_builder_product = false %}
        {% capture vwqbrk_item_properties %}
          {% capture custom_properties_display_check %}{% include 'vwqbrk-item-properties' with vwqbrk_item %}{% endcapture %}
          {% unless custom_properties_display_check contains 'Liquid error' %}
            {{ custom_properties_display_check }}
          {% else %}
        	<div class=\"vwqbrk-properties vwqbrk-properties-{{ vwqbrk_item.properties[builder_id] }}\">
              {% for p in vwqbrk_item.properties %}
                  {% assign underscore_hidden = false %}
                  {% assign first_char = p.first | slice: 0 %}
                  {% assign second_char = p.first | slice: 1 %}
                  {% if first_char == \"_\" and second_char != \"_\" %}
                      {% assign underscore_hidden = true %}
                  {% endif %}

                  {% comment %} CHECK FOR ALL THE REASONS WE MIGHT HIDE THIS PROPERTY FROM THE DISPLAY {% endcomment %}
                  {% if p.first == 'total_recurrences' or p.first == \"frequency_type_text\" or p.first == \"frequency_type\" or p.first == \"frequency_num\" or p.first == \"builder_id\" or p.first == \"builder_info\" or p.first == \"master_builder\" or p.first == \"group_id\" or p.first == \"discounted_price\" or p.first == \"is_prepaid\" or underscore_hidden == true or p.last == blank %}
                    {% if p.first contains \"builder_info\" %}
                        {% assign vwqbrk_builder_product = true %}
                        {% if p.first == 'builder_info' %}
                          {% assign builder_info = 'builder_info' %}
                        {% else %}
                          {% assign builder_info = '_builder_info' %}
                        {% endif %}
                    {% endif %}
                    {% continue %}
                  {% endif %}
                  {% assign option_title = p.first %}
                  <div class='vwqbrk_option_line'><span class=\"vwqbrk_option_title\">{{ p.first | replace: '__', '' | replace: '&amp;', '&' }}</span><span class=\"vwqbrk_option_seperator\">: </span>

                  {% comment %} DISPLAY UPLOAD LINKS AS LINKS, EVERYTHING ELSE AS TEXT{% endcomment %}
                  {% if p.last contains '/uploads/' %}
                  	<span class=\"vwqbrk_option_value\"><a class=\"lightbox\" href=\"{{ p.last }}\">Uploaded File</a></span>
                  {% else %}
                  	<span class=\"vwqbrk_option_value\" >{{ p.last | replace: '&amp;', '&' | replace: '&lt;', '<' | replace: '&gt;', '>'  }}</span>
                  {% endif %}
                  </div>
              {% endfor %}
        	</div>
        	{% if vwqbrk_item.properties[builder_id] != blank %}
        		<div id=\"vwqbrk-item-{{ vwqbrk_item.properties[builder_id]}}\" data-is-builder=\"{{ vwqbrk_builder_product }}\" data-handle=\"{{ vwqbrk_item.product.handle }}\" data-variant-id=\"{{ vwqbrk_item.variant.id }}\" class=\"vwqbrk-edit-item\" data-index=\"{{ forloop.index }}\"></div>
        	{% endif %}
          {% endunless %}
        {% endcapture %}

        {% comment %} GENERATE RECURRING ORDER VARIABLES FOR CUSTOM DISPLAY {% endcomment %}
        {% assign vwqbrk_recurring_frequency_num = vwqbrk_item.properties.frequency_num %}
        {% assign vwqbrk_recurring_frequency_text = vwqbrk_item.properties.frequency_type_text %}
        {% assign vwqbrk_recurring_savings = vwqbrk_original_price | minus: vwqbrk_item_price %}

        {% comment %} GENERATE RECURRING ORDER DESCRIPTION {% endcomment %}
        {% assign vwqbrk_is_recurring = false %}
        {% capture vwqbrk_recurring_desc %}
          {% if vwqbrk_item.properties.frequency_type and vwqbrk_item.properties.frequency_num and vwqbrk_item.properties.frequency_type_text  %}
            {% assign vwqbrk_is_recurring = true %}
            {% capture custom_recurring_desc_check %}{% include 'vwqbrk-recurring-desc' with vwqbrk_item %}{% endcapture %}
            {% unless custom_recurring_desc_check contains 'Liquid error' %}
              {{ custom_recurring_desc_check }}
            {% else %}
        		{% unless vwqbrk_item.properties._convertible_discount_percent%}
        			<div class = \"vwqbrk_recurring_desc\">
        				<span class=\"vwqbrk_ro_every\">Every </span>
        				<span class=\"vwqbrk_ro_frequency_num\">{{ vwqbrk_item.properties.frequency_num}} </span>
        				<span class=\"vwqbrk_ro_frequency_type_text\">{{ vwqbrk_item.properties.frequency_type_text }} </span>
        				{% if vwqbrk_item.properties.discounted_price %}<span class=\"discounted_price_in_cart\">{{ vwqbrk_item_price | money }}</span><span class=\"vwqbrk_ro_each\"> each</span>{% endif %}
        				{% if vwqbrk_item.properties._secondary_discount_percent %}
        				  {% assign vwqbrk_ro_secondary_discount_multiplier = 100.00 | minus: vwqbrk_item.properties._secondary_discount_percent | times: 0.01 %}
        				  {% assign vwqbrk_ro_secondary_discount_price = vwqbrk_item.price | times: vwqbrk_ro_secondary_discount_multiplier %}
        				  <br>
        				  {% if vwqbrk_item.properties._secondary_discount_required_orders == '1' %}
        					{% if vwqbrk_ro_secondary_discount_price < vwqbrk_item.price %}
        						<span class=\"vwqbrk_ro_is_discount\">Discounted price </span>
        					{% else %}
        						<span class=\"vwqbrk_ro_no_discount\">Price </span>
        					{% endif %}
        					<span class=\"vwqbrk_ro_price_after_first\">after first order </span>
        					<span class=\"vwqbrk_ro_secondary_discount_price\">{{vwqbrk_ro_secondary_discount_price | money}}</span>
        				  {% else %}
        					{% if vwqbrk_ro_secondary_discount_price < vwqbrk_item.price %}
        						<span class=\"vwqbrk_ro_is_discount\">Discounted price </span>
        					{% else %}
        						<span class=\"vwqbrk_ro_no_discount\">Price </span>
        					{% endif %}
        					<span class=\"vwqbrk_ro_price_after_multiple\">after </span>
        					<span class=\"vwqbrk_ro_secondary_discount_required_orders\">{{vwqbrk_item.properties._secondary_discount_required_orders}} </span>
        					<span class=\"vwqbrk_ro_secondary_discount_orders\">orders: </span>
        					<span class=\"vwqbrk_ro_secondary_discount_price\">{{vwqbrk_ro_secondary_discount_price | money}}</span>
        				  {% endif %}
        				{% endif %}
        			</div>
        		{% endunless %}
        		{% if vwqbrk_item.properties._convertible_discount_percent %}
        			{% assign vwqbrk_ro_convertible_multiplier = 100.00 | minus: vwqbrk_item.properties._convertible_discount_percent | times: 0.01 %}
        			{% assign vwqbrk_ro_convertible_product_price = all_products[vwqbrk_item.properties._convertible_product_handle].price %}
        			{% assign vwqbrk_ro_convertible_title = all_products[vwqbrk_item.properties._convertible_product_handle].title %}
        			{% assign vwqbrk_ro_convertible_variant_id = vwqbrk_item.properties._convertible_variant_id | times: 1 %}
        			{% for var in all_products[vwqbrk_item.properties._convertible_product_handle].variants %}
        			  {% if var.id == vwqbrk_ro_convertible_variant_id %}
        				{% assign vwqbrk_ro_convertible_product_price = var.price %}
        				{% if var.title != 'Default Title' %}
        					{% assign vwqbrk_ro_convertible_title = vwqbrk_ro_convertible_title | append: ' - ' | append: var.title %}
        				{% endif %}
        			  {% endif %}
        			{% endfor %}
        			{% assign vwqbrk_ro_convertible_discount_price = vwqbrk_ro_convertible_product_price | times: vwqbrk_ro_convertible_multiplier %}
        			<span class=\"vwqbrk_ro_conversion\">Converts to: </span>
        			<span class=\"vwqbrk_ro_convert_initial_product\">{{vwqbrk_ro_convertible_title}} </span>
        			<span class=\"converted_discounted_price_in_cart\">{{ vwqbrk_ro_convertible_discount_price | money }}</span>
        			<br>
        			<span class=\"vwqbrk_ro_deliver_every\">Deliver every </span>
        			<span class=\"vwqbrk_ro_frequency_num\">{{ vwqbrk_item.properties.frequency_num}} </span>
        			<span class=\"vwqbrk_ro_frequency_type_text\">{{ vwqbrk_item.properties.frequency_type_text }}</span>
        			<br>
        		{% endif%}
        		{% if vwqbrk_item.properties.total_recurrences %}
        			<span class=\"vwqbrk_ro_total_recurrences_label\">Your subscription will last for {{ vwqbrk_item.properties.total_recurrences }} shipments</span>
        		{% endif %}
            {% endunless %}
          {% endif %}

          {% comment %} GENERATE HIDDEN INPUT FIELDS FOR RO PRODUCTS {% endcomment %}
          {% if vwqbrk_item.properties.frequency_type and vwqbrk_item.properties.frequency_num and vwqbrk_item.properties.frequency_type_text  %}
        		<input type=\"hidden\" name=\"{{ forloop.index0 }}[number]\" value=\"{{ vwqbrk_item.properties.frequency_num }}\" />
        		<input type=\"hidden\" name=\"{{ forloop.index0 }}[type_id]\" value=\"{{ vwqbrk_item.properties.frequency_type }}\" />
          {% endif %}

          {% comment %} GENERATE REMAINING HIDDEN INPUT FIELDS FOR ALL ITEMS {% endcomment %}
            <input type=\"hidden\" name=\"product_id[{{ forloop.index0 }}]\" value=\"{{ vwqbrk_item.product.id }}\">
            <input type=\"hidden\" name=\"variant_id[{{ forloop.index0 }}]\" value=\"{{ vwqbrk_item.variant.id }}\">
            <input type=\"hidden\" name=\"quantity[{{ forloop.index0 }}]\" value=\"{{ vwqbrk_item.quantity }}\">
        {% endcapture %}

        {% comment %} EXPOSE DATA FOR RO CONVERTIBLE ITEM {% endcomment %}
        {% if vwqbrk_item.properties._convertible_product_handle != blank %}
            <script>
                VWQBRK = VWQBRK || {};
                VWQBRK.recurring_orders = VWQBRK.recurring_orders || {};
                VWQBRK.recurring_orders.convertible_products = VWQBRK.recurring_orders.convertible_products || {};
                VWQBRK.recurring_orders.convertible_products['{{vwqbrk_item.properties._convertible_product_handle}}'] = {{ all_products[vwqbrk_item.properties._convertible_product_handle] | json }};
            </script>
        {% endif %}

        {% comment %} GENERATE VWQBRK DESCRIPTION {% endcomment %}
        {% capture vwqbrk_desc %}
            <span class=\"vwqbrk-cart-item\" data-product-id=\"{{vwqbrk_item.id}}-{{forloop.index0}}\"></span>
        {% endcapture %}

        {% comment %} GENERATE VARIABLES FOR BUILDER {% endcomment %}
        {% if vwqbrk_builder_product %}
          {% assign builder_info = vwqbrk_item.properties[builder_info] | split: '~~' %}
          {% assign vwqbrk_builder_img_alt = builder_info[0] %}
          {% assign vwqbrk_builder_img_src = builder_info[1] %}
          {% assign vwqbrk_builder_href = '/apps/productbuilder/' | append: builder_info[2] %}
        {% else %}
          {% assign vwqbrk_builder_img_alt = false %}
          {% assign vwqbrk_builder_img_src = false %}
          {% assign vwqbrk_builder_href = vwqbrk_item.product.url %}
        {% endif %}

        {% comment %} ALIASES FOR PRODUCT OPTIONS VARIABLES FOR QUICK-INSTALL {% endcomment %}
        {% assign vwqbrkoptions_step3 = vwqbrk_row_class %}
        {% assign vwqbrkoptions_step4 = vwqbrk_row_data %}
        {% assign vwqbrkoptions_step6 = vwqbrk_item_properties %}
        {% assign vwqbrkoptions_step7 = vwqbrk_qty_class %}
        {% assign vwqbrkoptions_step8 = vwqbrk_qty_attr %}
        {% assign vwqbrkoptions_step9 = vwqbrk_remove_href %}
        {% assign vwqbrkoptions_step10 = vwqbrk_remove_class %}
        {% assign vwqbrkoptions_step11 = vwqbrk_remove_attr %}
        {% assign vwqbrkoptions_step12 = vwqbrk_item_price | money %}
        {% assign vwqbrkoptions_step13 = vwqbrk_item_line_price | money %}

        {% endcapture %}{{ vwqbrk_cart_item_liquid | strip_newlines }}

  ";
        $content_html = array(
              "asset" => array(
                  "key" => "snippets/vwqbrk-cart-item.liquid",
                  "value" =>  $content_html_value
              )
          );

        $putForm = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $content_html], TRUE);
          return true;
     }
   public function qbrkCommonTheme($themeId,$shop)
   {
       $year   = getYear();
       $shopAccess = getShop_accessToken_byShop($shop);
       $this->load->library('Shopify', $shopAccess);
       $include_file = "{% include 'vwqbrk-common' %}";

       sleep(1);
       $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=layout/theme.liquid'], TRUE);
       $theme_liquid = $getThemeLiquid->asset->value;

       if (strpos($theme_liquid, $include_file) === false) {
         $bodytagpos = strpos($theme_liquid, '</head>');
         $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

         // Taking backup of original theme.liquid file
         $backup_html = array(
           "asset" => array(
             "key" => "layout/VW_THEME_BKP_theme.liquid",
             "value" =>  $theme_liquid
           )
         );


         $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

         // Including our snippet in theme.liquid file
         $new_html = array(
           "asset" => array(
             "key" => "layout/theme.liquid",
             "value" => $new_theme_str
           )
         );

         sleep(1);
         $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
   }
   return true;
 }

   public function qbrkProductTheme($themeId,$shop)
   {
       $year   = getYear();
       $shopAccess = getShop_accessToken_byShop($shop);
       $this->load->library('Shopify', $shopAccess);
       $include_file = "{% include 'vwqbrk-product' with product, hide_action: 'break' %}{% if vwqbrk_hidden_product %}{% break %}{%endif %}";

       sleep(1);
       $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/product.liquid'], TRUE);
       $theme_liquid = $getThemeLiquid->asset->value;

       if (strpos($theme_liquid, $include_file) === false) {
         // $bodytagpos = strpos($theme_liquid, '</head>');
         $new_theme_str = substr_replace($theme_liquid, $include_file, 0, 0);

         // Taking backup of original theme.liquid file
         $backup_html = array(
           "asset" => array(
             "key" => "templates/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
             "value" =>  $theme_liquid
           )
         );


         $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

         // Including our snippet in theme.liquid file
         $new_html = array(
           "asset" => array(
             "key" => "templates/product.liquid",
             "value" => $new_theme_str
           )
         );

         sleep(1);
         $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
   }
   return true;
  }
   public function vwqbrkCartTheme($themeId,$shop)
   {
       $year   = getYear();
       $shopAccess = getShop_accessToken_byShop($shop);
       $this->load->library('Shopify', $shopAccess);
       $include_file = "{% include 'vwqbrk-cart' %}";

       sleep(1);
       $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
       $theme_liquid = $getThemeLiquid->asset->value;

       if (strpos($theme_liquid, $include_file) === false) {
         $bodytagpos = strpos($theme_liquid, "{% section 'cart-template' %}");
         $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

         // Taking backup of original liquid file
         $backup_html = array(
           "asset" => array(
             "key" => "templates/VW_CART_BKP_theme.liquid",
             "value" =>  $theme_liquid
           )
         );


         $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

         // Including our snippet in liquid file
         $new_html = array(
           "asset" => array(
             "key" => "templates/cart.liquid",
             "value" => $new_theme_str
           )
         );

         sleep(1);
         $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);

   }
   return true;
 }

 public function qbrkCartItemTheme($themeId,$shop)
 {
   // try {
       $year   = getYear();
       $shopAccess = getShop_accessToken_byShop($shop);
       $this->load->library('Shopify', $shopAccess);
       $include_file = "{%- include 'vwqbrk-cart-item' with item -%}";

       sleep(1);
       $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/cart-template.liquid'], TRUE);
       $theme_liquid = $getThemeLiquid->asset->value;


       $forLoopString = '';
       if (strpos($theme_liquid, '{%- for item in cart.items -%}') !== false) {
         $forLoopString = '{%- for item in cart.items -%}';
       } elseif (strpos($theme_liquid, '{% for item in cart.items %}') !== false) {
         $forLoopString = '{% for item in cart.items %}';
       }

       if (strpos($theme_liquid, $include_file) === false) {
         $bodytagpos    = strpos($theme_liquid, $forLoopString);
         $bodytagpos    = $bodytagpos + strlen($forLoopString);

         $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

         // Taking backup of original liquid file
         $backup_html = array(
           "asset" => array(
             "key" => "sections/VW_CART_TEMPLATE_BKP_theme.liquid",
             "value" =>  $theme_liquid
           )
         );

         $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

         // Including our snippet in theme.liquid file
         $new_html = array(
           "asset" => array(
             "key" => "sections/cart-template.liquid",
             "value" => $new_theme_str
           )
         );

         sleep(1);
         $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
       }
    return true;

    // } catch (\Exception $e) {
    //   return false;
    // }
 }

 public function qbrkCartItemAltTheme($themeId,$shop)
 {
    // try {
          $year   = getYear();
          $shopAccess = getShop_accessToken_byShop($shop);
          $this->load->library('Shopify', $shopAccess);
          $include_file = "{%- include 'vwqbrk-cart-item' with item -%}";

          sleep(1);
          $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=templates/cart.liquid'], TRUE);
          $theme_liquid = $getThemeLiquid->asset->value;

          if (strpos($theme_liquid, $include_file) === false) {
            $bodytagpos    = strpos($theme_liquid, '{% for item in cart.items %}');
            $bodytagpos    = $bodytagpos + strlen('{% for item in cart.items %}');

            $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

            // Taking backup of original liquid file
            $backup_html = array(
              "asset" => array(
                "key" => "templates/VW_CART_BKP_theme.liquid",
                "value" =>  $theme_liquid
              )
            );

            $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

            // Including our snippet in theme.liquid file
            $new_html = array(
              "asset" => array(
                "key" => "templates/cart.liquid",
                "value" => $new_theme_str
              )
            );

            sleep(1);
            $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
       }
      return true;
    // } catch (\Exception $e) {
    //     return false;
    // }

 }

 public function qbrkVariantTheme($themeId,$shop)
 {
     $year   = getYear();
     $shopAccess = getShop_accessToken_byShop($shop);
     $this->load->library('Shopify', $shopAccess);
     $include_file = "{% include 'vwqbrk-variant' with variant, hide_action: 'skip' %}";

     sleep(1);
     $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
     $theme_liquid = $getThemeLiquid->asset->value;

     if (strpos($theme_liquid, $include_file) === false) {
       $bodytagpos    = strpos($theme_liquid, '{% for variant in product.variants %}');
       $bodytagpos    = $bodytagpos + strlen('{% for variant in product.variants %}');

       $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

       // Taking backup of original liquid file
       $backup_html = array(
         "asset" => array(
           "key" => "sections/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
           "value" =>  $theme_liquid
         )
       );


       $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

       // Including our snippet in theme.liquid file
       $new_html = array(
         "asset" => array(
           "key" => "sections/product-template.liquid",
           "value" => $new_theme_str
         )
       );

       sleep(1);
       $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
 }
 return true;

 }
 public function qbrkVariantDivTheme($themeId,$shop)
 {
     $year   = getYear();
     $shopAccess = getShop_accessToken_byShop($shop);
     $this->load->library('Shopify', $shopAccess);
     $include_file = '<div class="vwqbrk_qb_grid" data-variant-id="{{ product.selected_or_first_available_variant.id }}"></div>';

     sleep(1);
     $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
     $theme_liquid = $getThemeLiquid->asset->value;

     if (strpos($theme_liquid, $include_file) === false) {
       $bodytagpos    = strpos($theme_liquid, '{% if section.settings.show_quantity_selector %}');
       // $bodytagpos    = $bodytagpos + strlen('{% if section.settings.show_quantity_selector %}');

       $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

       // Taking backup of original liquid file
       $backup_html = array(
         "asset" => array(
           "key" => "sections/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
           "value" =>  $theme_liquid
         )
       );


       $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

       // Including our snippet in theme.liquid file
       $new_html = array(
         "asset" => array(
           "key" => "sections/product-template.liquid",
           "value" => $new_theme_str
         )
       );

       sleep(1);
       $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
 }


 return true;

 }
 public function qbrkVariantDivBrooklynTheme($themeId,$shop)
 {
     $year   = getYear();
     $shopAccess = getShop_accessToken_byShop($shop);
     $this->load->library('Shopify', $shopAccess);
     $include_file = '<div class="vwqbrk_qb_grid" data-variant-id="{{ product.selected_or_first_available_variant.id }}"></div>';

     $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
     $theme_liquid = $getThemeLiquid->asset->value;

     if (strpos($theme_liquid, $include_file) === false) {
       $bodytagpos    = strpos($theme_liquid, '<div class="product-single__add-to-cart{% if section.settings.add_to_cart_button_size == "large" %} product-single__add-to-cart--full-width{% endif %}">');
       // $bodytagpos    = $bodytagpos + strlen('{% if section.settings.show_quantity_selector %}');

       $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

       // Taking backup of original liquid file
       $backup_html = array(
         "asset" => array(
           "key" => "sections/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
           "value" =>  $theme_liquid
         )
       );

       $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

       // Including our snippet in theme.liquid file
       $new_html = array(
         "asset" => array(
           "key" => "sections/product-template.liquid",
           "value" => $new_theme_str
         )
       );

       $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
 }


 return true;

 }
 public function qbrkVariantDivMinimalTheme($themeId,$shop)
 {
     $year   = getYear();
     $shopAccess = getShop_accessToken_byShop($shop);
     $this->load->library('Shopify', $shopAccess);
     $include_file = '<div class="vwqbrk_qb_grid" data-variant-id="{{ product.selected_or_first_available_variant.id }}"></div>';

     $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
     $theme_liquid = $getThemeLiquid->asset->value;

     if (strpos($theme_liquid, $include_file) === false) {
       $bodytagpos    = strpos($theme_liquid, '<button type="submit" name="add" id="AddToCart" class="btn {{ btn_class }}{% if section.settings.enable_payment_button %} btn--secondary{% endif %}">');
       // $bodytagpos    = $bodytagpos + strlen('{% if section.settings.show_quantity_selector %}');

       $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

       // Taking backup of original liquid file
       $backup_html = array(
         "asset" => array(
           "key" => "sections/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
           "value" =>  $theme_liquid
         )
       );

       $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

       // Including our snippet in theme.liquid file
       $new_html = array(
         "asset" => array(
           "key" => "sections/product-template.liquid",
           "value" => $new_theme_str
         )
       );

       $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
 }


 return true;

 }
 public function qbrkVariantDivSupplyTheme($themeId,$shop)
 {
     $year   = getYear();
     $shopAccess = getShop_accessToken_byShop($shop);
     $this->load->library('Shopify', $shopAccess);
     $include_file = '<div class="vwqbrk_qb_grid" data-variant-id="{{ product.selected_or_first_available_variant.id }}"></div>';

     $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
     $theme_liquid = $getThemeLiquid->asset->value;

     if (strpos($theme_liquid, $include_file) === false) {
       $bodytagpos    = strpos($theme_liquid, '<div class="payment-buttons payment-buttons--{{ section.settings.add_to_cart_button_size }}">');
       // $bodytagpos    = $bodytagpos + strlen('{% if section.settings.show_quantity_selector %}');

       $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

       // Taking backup of original liquid file
       $backup_html = array(
         "asset" => array(
           "key" => "sections/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
           "value" =>  $theme_liquid
         )
       );

       $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

       // Including our snippet in theme.liquid file
       $new_html = array(
         "asset" => array(
           "key" => "sections/product-template.liquid",
           "value" => $new_theme_str
         )
       );

       $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
 }


 return true;

 }
 public function qbrkVariantDivSimpleTheme($themeId,$shop)
 {
     $year   = getYear();
     $shopAccess = getShop_accessToken_byShop($shop);
     $this->load->library('Shopify', $shopAccess);
     $include_file = '<div class="vwqbrk_qb_grid" data-variant-id="{{ product.selected_or_first_available_variant.id }}"></div>';

     $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
     $theme_liquid = $getThemeLiquid->asset->value;

     if (strpos($theme_liquid, $include_file) === false) {
       $bodytagpos    = strpos($theme_liquid, '{% if section.settings.product_quantity_enable %}');
       // $bodytagpos    = $bodytagpos + strlen('{% if section.settings.show_quantity_selector %}');

       $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

       // Taking backup of original liquid file
       $backup_html = array(
         "asset" => array(
           "key" => "sections/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
           "value" =>  $theme_liquid
         )
       );

       $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

       // Including our snippet in theme.liquid file
       $new_html = array(
         "asset" => array(
           "key" => "sections/product-template.liquid",
           "value" => $new_theme_str
         )
       );

       $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
 }


 return true;

 }

 public function qbrkVariantDivHomesolovelyTheme($themeId,$shop)
 {
     $year   = getYear();
     $shopAccess = getShop_accessToken_byShop($shop);
     $this->load->library('Shopify', $shopAccess);
     $include_file = '<div class="vwqbrk_qb_grid" data-variant-id="{{ product.selected_or_first_available_variant.id }}"></div>';

     $getThemeLiquid = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json?asset[key]=sections/product-template.liquid'], TRUE);
     $theme_liquid = $getThemeLiquid->asset->value;

     if (strpos($theme_liquid, $include_file) === false) {
       $bodytagpos    = strpos($theme_liquid, '<div class="fix_add_button">');
       // $bodytagpos    = $bodytagpos + strlen('{% if section.settings.show_quantity_selector %}');

       $new_theme_str = substr_replace($theme_liquid, $include_file, $bodytagpos, 0);

       // Taking backup of original liquid file
       $backup_html = array(
         "asset" => array(
           "key" => "sections/VW_PRODUCT_TEMPLATE_BKP_theme.liquid",
           "value" =>  $theme_liquid
         )
       );

       $backup_theme_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $backup_html], TRUE);

       // Including our snippet in theme.liquid file
       $new_html = array(
         "asset" => array(
           "key" => "sections/product-template.liquid",
           "value" => $new_theme_str
         )
       );

       $include_snippet_liquid = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/'.$year.'/themes/' . $themeId . '/assets.json', 'DATA' => $new_html], TRUE);
 }


 return true;

 }

 public function sample()
 {
   $this->load->view('sample');
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



}
