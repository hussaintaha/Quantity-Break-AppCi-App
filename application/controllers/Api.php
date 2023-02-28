<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

class Api extends CI_Controller {
  public function __construct() {
    parent::__construct(); //Do your magic here
    $this->load->database();
    $this->load->helper('url');
    $this->load->helper('global_helper');
    $this->load->helper('date');
    $this->load->model('Home_model');
  }

  public function index() {
    echo "string";
  }

  public function enabled() {
    if (isset($_GET['enabled'])) {
      // code...
    }
    header('Content-Type: application/json');
    echo json_encode(true);
  }

  public function storefront_config() {
    header('Content-Type: application/json');
    echo '{"is_qb_enabled":true,"grid_template":"{{#has_qty_breaks}}\n\u003Ctable class=\u0027shappify_qb_grid\u0027\u003E\r\n\u003Cthead\u003E\r\n\t\u003Ctr\u003E\r\n\t\t\u003Cth\u003EQty\u003C\/th\u003E\r\n\t\t\u003Cth\u003EPrice\u003C\/th\u003E\r\n\t\u003C\/tr\u003E\r\n\u003C\/thead\u003E\r\n\u003Ctbody\u003E\r\n{{#qty_breaks}}\r\n\t\u003Ctr\u003E\r\n\t\t\u003Ctd\u003E{{qty}}\u003C\/td\u003E\r\n\t\t\u003Ctd\u003E{{{price}}}\u003C\/td\u003E\r\n\t\u003C\/tr\u003E\r\n{{\/qty_breaks}}\r\n\u003C\/tbody\u003E\r\n\u003C\/table\u003E\n{{\/has_qty_breaks}}","grid_style":"\u003Cstyle\u003Etable.shappify_qb_grid{ width:auto; } div.bold_qb_grid{ width: 100%;}\u003C\/style\u003E","is_ys_banner_enabled":true,"ys_banner_style":"\u003Cstyle\u003E.bold_csp_qb_savings{color:#114760;background-color:#CDE8F4;border:#A4CBDD;margin:0px;padding:10px;font-size:12px;}\u003C\/style\u003E","banner_template":"You will save {{saved}} by buying bulk"}';
  }

  public function pricerules_rulesets() {
    // echo "<pre>";
    // print_r($_GET);
    // exit;
    $rulesets = array();
    if (isset($_GET['products']) && !empty($_GET['products'])) {


      $product_ids = explode(',', $_GET['products']);
      foreach ($product_ids as $key => $product_id) {

        $discounts = $this->Home_model->getProductDiscountByPid($product_id);
        if (!$discounts) {
          continue;
        }

        $rules = array();
        // get rules
        foreach ($discounts as $key => $discount) {
          array_push($rules, [
            "type" => "DISCOUNT",
            "conditions" => [
              "0" => [
                "type" => "QTY_BY_PRODUCT",
                "operator" => ">=",
                "value" => (int)$discount->qty
              ]
            ],
            "actions" => [
              "0" => [
                "type" => $this->Home_model->GetDiscountTypeById($discount->discount_type),
                "value" => (int)("-".$discount->discount)
              ]
            ]
          ]);

          array_push($rules, [
            "type" => "DISPLAY",
            "conditions" => [],
            "actions" => [
              "0" => [
                "type" => "DISPLAY_QTY_BREAK",
                "percent" => (int)$discount->discount,
                "qty" => (int)$discount->qty
              ]
            ]
          ]);
        }

        // create rulesets
        array_push($rulesets, [
          "id" => (int)$discounts[0]->set_id,
          "app_slug" => "csp",
          "public_name" => "",
          "sync_percent" => 100,
          "priority" => 100,
          "expiry_date" => null,
          "rules" => $rules,
          "product_selection" => [
            "type" => "SHOPIFY_PRODUCT_SEARCH",
            "products" => [
              "0" => [
                "product_id" => $discounts[0]->p_id
              ]
            ]
          ]
        ]);
      }
    }
    // print_r($rulesets);
    header('Content-Type: application/json');
    echo '{"rulesets":'.json_encode($rulesets).', "config": {}}';
  }
}
