<?php
class Home_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    public function GetShopId($shop){
        $shop_id = $this->db->select('id')->where('domain', $shop)->get('shopify_stores')->row()->id;
        return $shop_id;
    }
    public function getShopDetails($shop)
    {
      $shop = $this->db->select('*')->where('domain', $shop)->get('shopify_stores')->row();
      return $shop;
    }

    public function GetPreviousRecords($shop)
    {
      $shop = $this->db->select('*')->where('domain', $shop)->get('shopify_stores')->row();
      return $shop;
    }
    public function getPriceset()
    {
               $this->db->select('*');
      $query = $this->db->get('price_types')->result();
      return $query;
    }

    public function discountSet($shop_id)
    {
      $this->db->select('*');
      $this->db->where('shop_id', $shop_id);
      $query = $this->db->get('tbl_discount_set')->result();
      return $query;
    }

    public function discountSetCount($shop_id)
    {
      $this->db->select('*');
      $this->db->where('shop_id', $shop_id);
      $query = $this->db->get('tbl_discount_set')->num_rows();
      return $query;
    }

    public function productPrizes($variant,$qty)
    {
      $this->db->select('*');
      $this->db->where(['variant_id' => $variant, 'qty' => $qty]);
      $query = $this->db->get('tbl_set_price')->result_array();
      return $query;
   }
   public function productPrizesObjFormat($variant,$qty)
   {
     $this->db->select('*');
     $this->db->where(['variant_id' => $variant, 'qty' => $qty]);
     $query = $this->db->get('tbl_set_price')->result_object();
     return $query;
  }

   public function GetDiscountTypeId($type)
  {
     $this->db->select('id');
     $this->db->where(['value' => $type]);
     $query = $this->db->get('price_types')->row()->id;
     return $query;
  }

  public function GetDiscountTypeById($id) {
    $this->db->where(['id' => $id]);
    $query = $this->db->get('price_types')->row()->type;
    return $query;
  }

  public function GetProductDiscountSet($p_id)
  {
    // dd($p_id);
     $this->db->select('*');
     $this->db->where(['p_id' => $p_id]);
     $query = $this->db->get('tbl_set_price')->result_array();
     return $query;
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

  public function setproducts($set_id)
  {
     $this->db->distinct();
     $this->db->select('p_id');
     $this->db->where(['set_id' => $set_id]);
     $query = $this->db->get('tbl_product_discount')->result();
     return $query;
  }

  public function getProductDiscountByPid($pid) {
    $this->db->select(['set_id', 'p_id', 'qty', 'discount', 'discount_type']);
    $this->db->where(['p_id' => $pid]);
    $query = $this->db->get('tbl_product_discount')->result();
    return $query;
  }

public function productVariants($product)
{
   $this->db->distinct();
   $this->db->select('variant_id');
   $this->db->where(['p_id' => $product]);
   $query = $this->db->get('tbl_set_price')->result();
   return $query;
}

public function discountgroupName($shop_id,$set_id)
{
  $this->db->select('*');
  $this->db->where(['shop_id' => $shop_id,'id'=>$set_id]);
  $query = $this->db->get('tbl_discount_set')->row();
  return $query;
}

public function productInfo($shop_id,$p_id)
{
  $this->db->select('*');
  $this->db->where(['shop_id' => $shop_id,'p_id'=>$p_id]);
  $query = $this->db->get('tbl_product_details')->row();
  return $query;
}

public function getPricesetName($shop_id,$set_id)
{
        $this->db->select('*');
        $this->db->where(['shop_id' => $shop_id,'set_id'=>$set_id]);
        $query = $this->db->get('tbl_set_price')->result();
        return $query;
}

public function getProductIdsName($shop_id,$set_id)
{
        $this->db->distinct();
        $this->db->select('p_id');
        $this->db->where(['shop_id' => $shop_id,'set_id'=>$set_id]);
  $query = $this->db->get('tbl_set_price')->result();
  return $query;
}

public function getGridName($shop_id,$set_id)
{
   $this->db->distinct();
        $this->db->select('grid_style');
        $this->db->where(['shop_id' => $shop_id,'set_id'=>$set_id]);
  $query = $this->db->get('tbl_product_grid')->row();
  return $query;
}

public function getRequestData($shop_id)
{

  $this->db->distinct();
  $this->db->where('shop_id', $shop_id);
  $this->db->where('status !=' , 0);
  $this->db->order_by('send_on',"DESC");
  $this->db->select('*');
  $this->db->limit(1, 0);

  $query =   $this->db->get('installation')->row();
  return $query;
}
public function productDetail($shop_id,$p_id,$set_id)
{
    $query  = "SELECT DISTINCT * FROM `tbl_product_details`
                    LEFT JOIN tbl_product_grid ON tbl_product_grid.p_id = tbl_product_details.p_id WHERE
                    tbl_product_grid.shop_id             = '".$shop_id."' AND
                    tbl_product_grid.set_id              = '".$set_id."'
                    ";
      $products = $this->db->query($query)->result();
      // dd($products);
      foreach ($products as $product) {
      $this->db->select('variant_id');
      $this->db->where('p_id', $product->p_id);
      $variants = $this->db->get('tbl_set_price')->result();
      $product->variants = $variants;
      }

     return $products;
}

public function set_price($shop_id,$p_id,$set_id)
{
  $query  = "SELECT DISTINCT qty,discount_price FROM `tbl_set_price`
                    LEFT JOIN tbl_discount_set ON tbl_set_price.set_id = tbl_discount_set.id WHERE
                    tbl_set_price.shop_id             = '".$shop_id."' AND
                    tbl_discount_set.id              = '".$set_id."'
                    ";
$result = $this->db->query($query)->result();
   return $result;
}

public function discountType($shop_id,$set_id)
{
  // $query  = "SELECT DISTINCT discount_type FROM `tbl_set_price` WHERE shop_id  = '".$shop_id."' AND set_id = '".$set_id."' ";
  // $result = $this->db->query($query)->result();
  // return $result;
  $this->db->distinct();
  $this->db->select('discount_type');
  $this->db->where(['shop_id' => $shop_id,'set_id'=>$set_id]);
  $query = $this->db->get('tbl_set_price')->row()->discount_type;
  return $query;
}

public function discount_method($shop_id)
{
  $this->db->select('discount_method');
  $this->db->where(['id' => $shop_id]);
  $query = $this->db->get('shopify_stores')->row()->discount_method;
  return $query;
}

public function saveFeedback($data)
{
  // $this->db->where('shop_id',$data['shop_id']);
  $data = $this->db->insert('feedback', $data);
  return $data;
}






}
?>
