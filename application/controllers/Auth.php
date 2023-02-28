<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
class Auth extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('AuthModel');
    }

    //App Install View Page
    public function Install_login() {
      $this->load->view('auth/appinstall');
    }

    public function access() {
      $shop = $this->input->get('shop');
      if ($shop != '') {
        if ($this->db->table_exists('shopify_stores') === TRUE) {
          $this->auth($shop);
        } else {
          $this->CreateTable($shop);
        }
      } else {
        echo 'Unauthorized Access!';
  			exit;
      }
    }

    public function CreateTable($shop='')
    {
      $query = "CREATE TABLE `shopify_stores` (
        `id` int(11) NOT NULL,
        `token` varchar(100) DEFAULT NULL,
        `shop` varchar(100) DEFAULT NULL,
        `store_id` int(11) DEFAULT NULL,
        `domain` varchar(100) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `active` tinyint(1) NOT NULL DEFAULT '1',
        `code` text,
        `hmac` text,
        `charge_id` varchar(100) DEFAULT NULL,
        `plan_id` int(11) NOT NULL
      )";
      $ok = $this->db->query($query);
      if($ok)
      {
        $query1="ALTER TABLE `shopify_stores`
                    ADD PRIMARY KEY (`id`)";
        $ok1 = $this->db->query($query1);
        if($ok1)
        {
          $query2 = "ALTER TABLE `shopify_stores` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";
          $ok2 = $this->db->query($query2);
        }
      }
      $this->auth($shop);
    }

    public function auth($shop)
    {

        $data = array(
            'API_KEY' => $this->config->item('shopify_api_key'),
            'API_SECRET' => $this->config->item('shopify_secret'),
            'SHOP_DOMAIN' => $shop,
            'ACCESS_TOKEN' => ''
        );

        $this->load->library('Shopify', $data); //load shopify library and pass values in constructor

        $scopes = array(
            'read_content', 'write_content', 'write_products',
            'read_products',  'read_product_listings', 'read_orders',
            'write_orders', 'read_themes', 'write_themes','read_customers', 'write_customers',
            'read_script_tags', 'write_script_tags'
        );
        $redirect_url = $this->config->item('redirect_url'); //redirect url specified in app setting at shopify
        $paramsforInstallURL = array(
            'scopes' => $scopes,
            'redirect' => $redirect_url
        );

        $permission_url = $this->shopify->installURL($paramsforInstallURL);

        $this->load->view('auth/escapeIframe', ['installUrl' => $permission_url]);
    }

    public function authCallback()
    {
        $code = $this->input->get('code');
        $shop = $this->input->get('shop');

        if (isset($code)) {
            $data = array(
                'API_KEY' => $this->config->item('shopify_api_key'),
                'API_SECRET' => $this->config->item('shopify_secret'),
                'SHOP_DOMAIN' => $shop,
                'ACCESS_TOKEN' => ''
            );
            $this->load->library('Shopify', $data); //load shopify library and pass values in constructor
        }
        $accessToken = $this->shopify->getAccessToken($code);
        $this->updateAccess_Token($accessToken);
        if ($accessToken != '') {
          $this->charge_exist($shop);
          redirect('Auth/home?shop=' . $shop);
        } else {
          redirect('Auth/Install_login');
        }
        //redirect('https://' . $shop . '/admin/apps');
    }
    public function charge_exist($shop = '') {
  		if (!empty($shop)) {
  			$shop_details = $this->AuthModel->get_shop_details($shop);
  			if ($shop_details) {
  				if (empty($shop_details->charge_id)) {
  					redirect('Auth/CreateCharge?shop=' . $shop);
  				} else {
  					redirect('Auth/GetCharge?shop=' . $shop . '&charge_id=' . $shop_details->charge_id);
  				}
  			} else {
  				redirect('Auth/Install_login');
  			}
  		} else {
  			redirect('Auth/Install_login');
  		}
  	}

    public function CreateCharge() {
      if (isset($_GET['shop']) && !empty($_GET['shop'])) {
        $shop = $_GET['shop'];

        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);
        if (!isset($_GET['price'])) {
          $price = 4.99;
          $plan_id = 0;
          $name = "Basic Plan";
        }else {
          $price = 9.99;
          $plan_id = 1;
          $name = "Premium Plan";
        }
        $data = array(
          "recurring_application_charge" => array(
            "name" => $name,
            "price" => $price,
            "test" => true,
            "return_url" => base_url('Auth/Charge_return_url?shop=' . $shop.'&plan_id='.$plan_id),
            "trial_days" =>7
          ),
        );
        $year = getYear();
        $charge = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/api/'.$year.'/recurring_application_charges.json', 'DATA' => $data], true);
        if ($charge->recurring_application_charge) {
          $charge = $charge->recurring_application_charge;
          $this->load->view('auth/escapeIframe', ['installUrl'=>$charge->confirmation_url]);
          // redirect($charge->confirmation_url);
        } else {
          redirect('Auth/Install_login');
        }
      } else {
        redirect('Auth/Install_login');
      }
    }
    public function GetCharge() {
      $shop = $_GET['shop'];
      $charge_id = $_GET['charge_id'];


      if (!empty($shop)) {
        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);
        $year = getYear();
        $charge = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/'.$year.'/recurring_application_charges/' . $charge_id . '.json'], true);
        if ($charge) {
          $charge = $charge->recurring_application_charge;
          if ($charge->status != 'active') {
            redirect('Auth/CreateCharge?shop=' . $shop);
          } else {
            redirect('Auth/AppLoader?shop=' . $shop);
          }
        }
      }
    }

    public function Charge_return_url() {
      $plan_id = $_GET['plan_id'];
      $shop = $_GET['shop'];
      $charge_id = isset($_GET['charge_id'])? $_GET['charge_id'] : 0 ;
      if (!empty($shop)) {

        $shopAccess = getShop_accessToken_byShop($shop);
        $this->load->library('Shopify', $shopAccess);

        $data = array(
          "recurring_application_charge" => array(
            "id" => $charge_id,
            "status " => "accepted"
          ),
        );
        $year = getYear();
        $charge = $this->shopify->call(['METHOD' => 'POST', 'URL' => '/admin/api/'.$year.'/recurring_application_charges/' . $charge_id . '/activate.json', 'DATA' => $data], true);
        if ($charge) {
          $where = array('shop' => $shop);
          $data1 = array('charge_id' => $charge_id,'plan_id'=>$plan_id);
          $update = $this->AuthModel->UpdateShopDetails($where,$data1);
          if ($update) {
            redirect('Auth/AppLoader?shop=' . $shop);
          } else {
            $charge = $charge->recurring_application_charge;
            $data['installUrl'] = $charge->confirmation_url;
            $this->load->view('auth/escapeIframe', $data);
          }
        } else {
          redirect('Auth/Install_login');
        }
      }
    }
    public function updateAccess_Token($accessToken) {
      if ($_GET['shop'] != '' && $_GET['code'] != '' && $_GET['hmac'] != '') {
        $shopdata = array('shop' => $_GET['shop'], 'code' => $_GET['code'], 'hmac' => $_GET['hmac']);
        $check_shop_exist = $this->AuthModel->check_ShopExist($_GET['shop']);
        if ($check_shop_exist) {
          $this->AuthModel->update_Shop($shopdata, $accessToken);
        } else {
          $this->AuthModel->add_newShop($shopdata, $accessToken);
        }
      }
    }

    public function home() {
      $code = $this->input->get('code');
      $shop = $this->input->get('shop');
      if (empty($shop)) {
        echo 'Unauthorized Access!';
        exit;
      }
      $this->AppLoader($shop);
    }

    public function AppLoader($shop='') {
      $shop = $this->input->get('shop');
      if (empty($shop)) {
        echo 'Unauthorized Access!';
        exit;
      }
      if (isset($shop)) {
        if ($shop != '') {
          $accessData = getShop_accessToken_byShop($shop);
          if (count($accessData) > 0) {
            if ($accessData['ACCESS_TOKEN'] != '') {
              $data['access_token'] = $accessData['ACCESS_TOKEN'];
              // $this->addScript();
              redirect('Home/welcome?shop='.$shop);
            } else {
              redirect('Auth/Install_login');
            }
          } else {
            redirect('Auth/Install_login');
          }
        }
      } else {
        redirect('Auth/Install_login');
      }
    }
    public function addScript() {
    $shop       = $_GET['shop'];
    // echo $_GET['shop'];
    // print_r($shop);
    $shopAccess = getShop_accessToken_byShop($shop);

    $this->load->library('Shopify', $shopAccess);

    // Run themes api in order to get all the themes info installed in the store
    $themes = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/2020-04/themes.json']);

    $themes_array = $themes->themes;

    // Get published theme id
    $theme_id;
    foreach ($themes_array as $theme) {
      if ($theme->role == "main") {
        $theme_id = $theme->id;
      }
    }

    // Get contents of theme.liquid
    $theme_template_contents = $this->shopify->call(['METHOD' => 'GET', 'URL' => '/admin/api/2020-04/themes/'.$theme_id.'/assets.json?asset[key]=layout/theme.liquid'], true);
    $theme_template_contents = $theme_template_contents->asset->value;

    // Custom script
    $custom_script = "{% include 'wish-list-popup' %}";
    if (strpos($theme_template_contents, $custom_script) === false) {
      $bodytagpos = strpos($theme_template_contents, '</body>');
      $new_theme_str = substr_replace($theme_template_contents, $custom_script, $bodytagpos, 0);

      $params = array(
        'asset' => array(
          "key" => "layout/VW_WISHLIST_BKP_theme.liquid",
          "source_key" => "layout/theme.liquid"
        )
      );

      // Run backup api
      $theme_backup = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/2020-04/themes/'.$theme_id.'/assets.json', 'DATA' => $params], true);

      // Including our snippet in theme.liquid file
      $new_html = array(
        "asset" => array(
          "key" => "layout/theme.liquid",
          "value" => $new_theme_str
        )
      );

      // Finally create a button
      $theme_template = $this->shopify->call(['METHOD' => 'PUT', 'URL' => '/admin/api/2020-04/themes/'.$theme_id.'/assets.json', 'DATA' => $params], true);

    }

}

}
