
<div id="dialog-root"></div>
<div id="popover-root"></div>
<div id="portal-root"></div>
<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

  <div class="Polaris-FooterHelp">

    <div class="Polaris-FooterHelp__Content">

      <div class="Polaris-FooterHelp__Icon"><span class="Polaris-Icon Polaris-Icon--colorTeal Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">

            <circle cx="10" cy="10" r="9" fill="currentColor"></circle>

            <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4a1 1 0 1 0 0 2 1 1 0 1 0 0-2m0-10C8.346 4 7 5.346 7 7a1 1 0 1 0 2 0 1.001 1.001 0 1 1 1.591.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path>

          </svg></span></div>

      <div class="Polaris-FooterHelp__Text">Learn more about <a class="Polaris-Link" href="https://help.shopify.com/manual/orders/fulfill-orders" data-polaris-unstyled="true">fulfilling orders</a></div>

    </div>

  </div>

</div>
<div class="contact" >
  <a href="<?=base_url().'Home/feedback?shop='.$_GET['shop'] ;?>"><i class="fas fa-comment" style="color:white;font-size:25px"></i></a>
</div>
<!-- @if(config('shopify-app.appbridge_enabled')) -->
<script src="https://unpkg.com/@shopify/app-bridge"></script>
<script>
    var shop      ='<?php echo $_GET['shop'];?>';
    var prev_jobs ='{{$prevJobs}}';
    var AppBridge = window['app-bridge'];
    var createApp = AppBridge.default;
    var app = createApp({
        apiKey: '<?php echo $this->config->item('shopify_api_key'); ?>',
        shopOrigin: '<?php echo $_GET['shop'];?>',
        forceRedirect: true,
    });
    const actions = window['app-bridge'].actions;
    var Button    = actions.Button;
    var Modal     = actions.Modal;
    var TitleBar  = actions.TitleBar;
    var Redirect  = actions.Redirect;
    var Loading   = actions.Redirect;
    var laravelAppURL = '<?php echo base_url();?>';

</script>
<!-- @include('shopify-app::partials.flash_messages') -->
<script src="<?= base_url().'assets/js/jquery-3.4.1.min.js'; ?>" ></script>
<script src="<?= base_url().'assets/js/pagination.js'; ?>" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
//custome js
function RemoveTr(element) {
    $(element).closest("tr").remove()
}
function RemoveFromList(prd_id) {
  $('#tr_'+prd_id).remove();
  $('.prc'+prd_id).remove();
}

$(document).ready(function() {
    // Create Product Pricing Group show hide
    $('.OpenCreateDiv').click(function() {
        $("#CreatePageMenus").hide();
        $("#NewPricingGroup").show();
    })
    $('.welcomPagge').click(function() {
        $("#CreatePageMenus").show();
        $("#NewPricingGroup").hide();
    })

    $('#backBtn').click(function() {
      $("#CreatePageMenus").show();
      $("#NewPricingGroup").hide();
    })
    //Create Product Pricing Group field product form + -
    $('.add_discount').click(function() {
        var html = "";
        html += '<tr class="">';
        html += '<td class="tag-level-table__qty-cell ">';
        html += '<label><input name="pb_quantity[]" class="pb_quantity" type="number" min="2" step="any"  value="1">+</label>';
        html += '</td>';
        html += '<td class="tag-level-table__tag-level-cell ">';
        html += '<label>';
        html += '<input name="pb_quantity_price[]" class="pb_quantity_price" type="number" min="0" step="any" value="">';
        html += '</label>';
        html += '</td>';
        html += '<td class="tag-level-table__delete-qty-btn">';
        html += '<button class="bv-button remove_tr" onclick="RemoveTr(this)">';
        html += '<span class="bv-button__text">';
        html += '<span class="bv-icon"><svg class="bv-icon__icon" viewBox="0 0 24 24"><path class="bv-icon__path" fill="currentColor" d="M11.5,10.3786797 L4.56066017,3.43933983 C3.97487373,2.85355339 3.02512627,2.85355339 2.43933983,3.43933983 C1.85355339,4.02512627 1.85355339,4.97487373 2.43933983,5.56066017 L9.37867966,12.5 L2.43933983,19.4393398 C1.85355339,20.0251263 1.85355339,20.9748737 2.43933983,21.5606602 C3.02512627,22.1464466 3.97487373,22.1464466 4.56066017,21.5606602 L11.5,14.6213203 L18.4393398,21.5606602 C19.0251263,22.1464466 19.9748737,22.1464466 20.5606602,21.5606602 C21.1464466,20.9748737 21.1464466,20.0251263 20.5606602,19.4393398 L13.6213203,12.5 L20.5606602,5.56066017 C21.1464466,4.97487373 21.1464466,4.02512627 20.5606602,3.43933983 C19.9748737,2.85355339 19.0251263,2.85355339 18.4393398,3.43933983 L11.5,10.3786797 Z"></path></svg></span></span>';
        html += '<span class="bv-loading-spinner bv-button__spinner"></span></button></td>';
        html += '</tr>';
        $("#discount_table tbody").append(html);
    });

    $("#select_products").click(function() {
        OpenProductPicker();
    });

    function generate_product_list_html(productData) {
        var htmm = '';
        productData.forEach(function(item) {
          var variant_array=[];
          item.variants.forEach(function(variant) {
            variant_array.push(variant.id)
          });
          htmm += '<div data-product-id="' + item.id + '"   variant_ids = "'+variant_array.toString()+'" class="list-item product-item select_item_product_qb selector-item clickable" id="product-selector-product-item">';
          htmm += '<div class="list-item-header">';
          htmm += '<div class="list-item-image-container">';
          htmm += '<div class="list-item-image">';
          htmm += '<img  class="item-image" src="' + item.image_url + '" alt="">';
          htmm += '</div>';
          htmm += '</div>';
          htmm += '</div>';
          htmm += '<div class="list-item-body">';
          htmm += '<div class="selector-item-primary-text item-title">' + item.title + '</div>';
          htmm += '<div class="selector-item-secondary-text"></div>';
          htmm += '</div>';
          htmm += '<div class="list-item-foot">';
          htmm += '<div class="selector-item-primary-text item-price">' + item.variants[0].price + '</div>';
          htmm += '<div class="selector-item-secondary-text"></div>';
          htmm += '</div>';
          htmm += '</div>';
        });
        return htmm;
    }

    function generate_product_variant_list_html() {
        var htmm = '';
        productData.forEach(function(item) {
            htmm += '<div class="list-item product-item selector-item clickable">\
            <div class="list-item-header">\
              <div class="list-item-image-container">\
                <div class="list-item-image">\
                  <img src="https://cdn.shopify.com/s/files/1/0253/5695/9853/products/47391_thumb.jpg" alt="">\
                </div>\
              </div>\
            </div>\
            <div class="list-item-body ">\
              <div class="list-item-body">\
                <div class="selector-item-primary-text">1960s Psychedelic CND Costume</div>\
                <div class="selector-item-secondary-text"></div>\
              </div>\
              <div class="list divided variant-list">\
                <div class="list-item product-item variant-item selector-item clickable">\
                  <div class="list-item-header">\
                    <div class="list-item-image-container">\
                      <div class="list-item-image"></div>\
                    </div>\
                  </div>\
                <div class="list-item-body ">\
                  <div class="selector-item-primary-text">47391 L FEMALE</div>\
                  <div class="selector-item-secondary-text"></div>\
                </div>\
                <div class="list-item-foot ">\
                  <div class="selector-item-primary-text">$23.99</div>\
                  <div class="selector-item-secondary-text"></div>\
                </div>\
              </div>\
            </div>\
          </div>';
        });
        return htmm;
    }

    function OpenProductPicker(){
      ShopifyApp.Modal.productPicker( {selectMultiple: true}, function(success, data) {
        if (!success) {
          return;
        }
        if (data.products.length > 0) {
          var selectedProducts = data.products;
          // console.log(selectedProducts);
          CreateProductsHtml(selectedProducts);
        }
        if (data.errors) {
          console.error(data.errors);
        }
      });
    }
    function CreateProductsHtml(products) {
      var html = "";
      var shop = '<?=$_GET['shop'] ?>';
      for (var i = 0; i < products.length; i++) {
        var product = products[i];
        var img = typeof product.image  == 'undefined' ? '<?php echo base_url('assets/img/dummyProduct.png') ?>' :product.image.src;
        var altimg  = typeof product.image  == 'undefined' ? 'dummyImage' : product.image.alt;
        var trId = $('#tr_'+product.id);
        var table_html="";
        if(trId.length == 0)
        {
        table_html +='<tr id="tr_' +product.id+ '">';
        table_html +='<td><img height="50px" src="'+ img +'" alt="'+ altimg +'"></td>'
        table_html +='<td>'+product.title+'</td>'
        table_html +='<td>'+product.variants[0].price+'</td>'
        table_html +='<td><input type="button" onclick="RemoveFromList('+product.id+')" style="cursor:pointer;" value="X" ></td>';
        table_html +='</tr>';
        $("#selectedTable tbody").append(table_html);
        var append_txb = "";
        append_txb+='<input type="hidden" class="attr_'+product.id +' sl_prd prc'+product.id+'"  name="'+product.id+'image" value="'+ img + '">';
        append_txb+='<input type="hidden" class="attr_'+product.id +' sl_prd prc'+product.id+'"  name="'+product.id+'title" value="'+product.title+'">';
        append_txb+='<input type="hidden" class="attr_'+product.id+' sl_prd prc'+product.id+'"  name="'+product.id+'price" value="'+ product.variants[0].price +'">';
        append_txb+='<input type="hidden" class="' +product.id+ '  sl_prd prc'+product.id+'"  name="selected_products[]" value="'+product.id+'">';
        // console.log(product.variants.length);
        for (var j = 0; j < product.variants.length; j++) {
           var varient = product.variants[j];
          append_txb+='<input type="hidden" class="'+product.id+'  sl_prd prc'+product.id+'"  name="'+product.id+'[]" value="'+varient.id+'">';
      }
      $("#selected_products").append(append_txb);
      }
     }
    }


    $("#bevyField6").change(function(){
      $('.shappify_qb_grid').hide();
      $('.'+$(this).val()).show()
    })
    $('#ProductPricingGroup').on('submit', function(e) {
        e.preventDefault();
        var error = 0;
        var groupName = $('#bevyField1').val();
        if (groupName == '') {
            error++;
            addClass_error('#bevyField1');
        } else {
            removeClass_error('#bevyField1');
        }
        var selected_product_length = $('.select_item_product_qb.selected').length;
        if (selected_product_length < 1) {
            error++;
            $('#select_products').addClass('bv-input--alert');
        } else {
            $('#select_products').removeClass('bv-input--alert');
        }
        var length_pb_qty = $('.pb_quantity_price').length;
        if (length_pb_qty > 0) {
            $('.tag-level-table__message-error').hide();
            var field_error = 0;
            $('.pb_quantity_price').each(function(index, value) {
                var thisValue = $(this).val();
                if (thisValue == '') {
                    error++;
                    field_error++;
                }
            });
            $('.pb_quantity').each(function(index, value) {
                var thisValues = $(this).val();
                if (thisValues == '') {
                    error++;
                    field_error++;
                }
            });
            if (field_error) {
                $('.tag-level-table__message-error1').show();
            } else {
                $('.tag-level-table__message-error1').hide();
            }
        } else {
            $('.tag-level-table__message-error').show();
        }
        var payload = $("#ProductPricingGroup").serialize();
           $.LoadingOverlay("show");
        $.ajax({
            "type":"POST",
            "url": '<?php echo base_url(); ?>'+"Home/SaveData?shop="+shop,
            "data":payload,
            "dataType":'json',
            "success":function(data){
               $.LoadingOverlay("hide");
                alert(data.msg);
               location.reload();
            }
        });

    });
    $('#EditProductPricingGroup').on('submit', function(e) {
        e.preventDefault();
        var error = 0;
        var groupName = $('#bevyField1').val();
        if (groupName == '') {
            error++;
            addClass_error('#bevyField1');
        } else {
            removeClass_error('#bevyField1');
        }
        var selected_product_length = $('.select_item_product_qb.selected').length;
        if (selected_product_length < 1) {
            error++;
            $('#select_products').addClass('bv-input--alert');
        } else {
            $('#select_products').removeClass('bv-input--alert');
        }
        var length_pb_qty = $('.pb_quantity_price').length;
        if (length_pb_qty > 0) {
            $('.tag-level-table__message-error').hide();
            var field_error = 0;
            $('.pb_quantity_price').each(function(index, value) {
                var thisValue = $(this).val();
                if (thisValue == '') {
                    error++;
                    field_error++;
                }
            });
            $('.pb_quantity').each(function(index, value) {
                var thisValues = $(this).val();
                if (thisValues == '') {
                    error++;
                    field_error++;
                }
            });
            if (field_error) {
                $('.tag-level-table__message-error1').show();
            } else {
                $('.tag-level-table__message-error1').hide();
            }
        } else {
            $('.tag-level-table__message-error').show();
        }
        var payload = $("#EditProductPricingGroup").serialize();
           $.LoadingOverlay("show");
           var set_id= <?php echo isset($_GET['set_id'])?$_GET['set_id'] : 'NULL'?>;
        $.ajax({
            "type":"POST",
            "url": '<?php echo base_url(); ?>'+"Home/UpdateData?set_id="+ set_id +"&shop="+shop,
            "data":payload,
            "dataType":'json',
            "success":function(data){
                 $.LoadingOverlay("hide");
                 Swal.fire({
                     title: "Discount Sync Request will be edited. ",
                     html: data.msg,
                     showCloseButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'OK',
                     allowOutsideClick: false
                   }).then((result) => {
                     if (result.value) {
                       window.location = '<?php echo base_url(); ?>'+'Home/welcome?shop='+'<?php echo $_GET['shop']  ?>'
                     }
                   });
                 // alert(data.msg);
                 // location.reload();
            }
        });

    });

    $('.showProdutcs').click(function(){
       $.LoadingOverlay("show");
      var setId = $(this).data('setid');
      var SearrchUrl = '<?php echo base_url(); ?>'+'Home/GetDiscountSetProducts?shop='+'<?php echo $_GET['shop']  ?>'+'&set_id='+setId;
      $.ajax({
          "type":"POST",
          "url": SearrchUrl,
          "data": {"set_id": setId,"shop":shop},
          "dataType":'json',
          "success":function(data){
            // console.log(data);
             $.LoadingOverlay("hide");
              Swal.fire({
                  title: "Subscription Products",
                  html: data.msg,
                  showCloseButton: true,
                  // confirmButtonColor: '#3085d6',
                  // cancelButtonColor: '#d33',
                  // confirmButtonText: 'Edit',
                  allowOutsideClick: false
                }).then((result) => {
                  if (result.value) {
                    window.location = '<?php echo base_url(); ?>'+'Home/editGroup?shop='+'<?php echo $_GET['shop']  ?>'+'&set_id='+setId
                  }
                });
          }
      });
    });

    function delete_group(set_id){
      Swal.fire({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this This Group Of discounts!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          showCloseButton: true,
          showCancelButton: true,
          focusConfirm: false,
          allowOutsideClick: false
        })
        .then((willDelete) => {
          if (willDelete) {
           $.LoadingOverlay("show");
              $.ajax({
                  "type":"POST",
                  "url": '<?php echo base_url(); ?>'+"Home/DeleteDiscountSet?shop=" +'<?php echo $_GET['shop'].'&set_id='; ?> ' + set_id,
                  "data": {"set_id": set_id,"shop":shop},
                  "dataType":'json',
                  "success":function(data){
                       $.LoadingOverlay("hide");
                    Swal.fire(data.msg);
                     location.reload();
                  }
              });
              }
          });
        }

      $('#cancelRequest').click(function(){
          Swal.fire({
              title: "Are you sure?",
              text: "Once request is canceled, you will not be able to recover this action!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
              showCloseButton: true,
              showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false
            })
            .then((willDelete) => {
              if (willDelete) {
               $.LoadingOverlay("show");
                  $.ajax({
                      "type":"POST",
                      "url": '<?php echo base_url(); ?>'+"Home/cancelRequest?shop=" +'<?php echo $_GET['shop']; ?> ',
                      "data": {"shop":shop},
                      "dataType":'json',
                      "success":function(data){
                           $.LoadingOverlay("hide");
                           Swal.fire(data.msg);
                           location.reload();
                      }
                  });
                  }
              });
          });

    function addClass_error(className) {
        $(className).parent().addClass('bv-input--alert');
    }

    function removeClass_error(className) {
        $(className).parent().removeClass('bv-input--alert');
    }
    $('.deleteGroup').on('click',function(){
      var set_id = $(this).attr('data-setId');
      delete_group(set_id);
    });

   $('.installBtn').click(function() {
     $.LoadingOverlay("show");
     $.ajax({
         type:"POST",
         url: '<?php echo base_url()."ApiController/install?shop=" ?>'+shop,
         dataType:'json',
         success:function(data){
              // console.log(data);
             $.LoadingOverlay("hide");
             if(data.code == 200)
             {
               Swal.fire('Good job',data.mgs, "success");
             }
             else {
               Swal.fire('Oops', data.mgs,"error");
             }
         }
     });
   });
   $('#createRequest').on('submit', function(e) {
       e.preventDefault();
       var payload = $("#createRequest").serialize();
       console.log(payload);
          $.LoadingOverlay("show");
       $.ajax({
           "type":"POST",
           "url": '<?php echo base_url(); ?>'+"Home/createRequest?shop="+shop,
           "data":payload,
           "dataType":'json',
           success:function(data){
              $.LoadingOverlay("hide");
              Swal.fire({
                  title: data.title,
                  text: data.mgs,
                  icon: data.code == 200 ? "warning" : "danger",
                  buttons: true,
                  dangerMode: false,
                  showCloseButton: true,
                  showCancelButton: true,
                  focusConfirm: false,
                  allowOutsideClick: false
                })
                .then((willDelete) => {
                  if (willDelete) {
                          window.location.href = '<?= base_url()."Home/installationRequest?shop=" ?>' +shop;
                      }
                  });
                }
       });

   });

   $('#feedback').on('submit', function(e) {
       e.preventDefault();
       var payload = $("#feedback").serialize();
          $.LoadingOverlay("show");
       $.ajax({
           "type":"POST",
           "url": '<?php echo base_url(); ?>'+"Home/saveFeedback?shop="+shop,
           "data":payload,
           "dataType":'json',
           success:function(data){
              $.LoadingOverlay("hide");
              Swal.fire({
                  title: data.title,
                  text: data.mgs,
                  icon: data.code == 200 ? "success" : "danger",
                  buttons: true,
                  dangerMode: false,
                  showCloseButton: true,
                  showCancelButton: true,
                  focusConfirm: false,
                  allowOutsideClick: false
                })
                .then((willDelete) => {
                  if (willDelete) {
                          window.location.href = '<?= base_url()."Home/welcome?shop=" ?>' +shop;
                      }
                  });
                }
       });

   });


  $('#theme_id').on('load change', function (e) {
      var optionSelected = $("option:selected", this).text();
      // console.log(optionSelected);
      var valueSelected = this.value;
      var div = $('#themesDiv');
      var html = '<input type="hidden" name="theme_name" value="'+ optionSelected +'">';
      div.append(html);
  });

$('#close').on('click', function (e) {
  $('#bannerDiv').hide();
});

$('#method1').on('click', function (e) {
  $('#discount_method').val(0);
  discountMethod(0)
});

$('#method2').on('click', function (e) {
  $('#discount_method').val(1);
  discountMethod(1)
});

function discountMethod(method)
{
  console.log(method);
  $.LoadingOverlay("show");
$.ajax({
   "type":"POST",
   "url": '<?php echo base_url(); ?>'+"Home/discountMethod?shop="+shop,
   "data": {method: method},
   "dataType":'json',
   success:function(data){
      $.LoadingOverlay("hide");
      Swal.fire({
          title: data.title,
          text: data.mgs,
          icon: data.code == 200 ? "success" : "danger",
          buttons: true,
          dangerMode: false,
          showCloseButton: true,
          showCancelButton: true,
          focusConfirm: false,
          allowOutsideClick: false
        })
        .then((willDelete) => {
          if (willDelete) {
                  window.location.href = '<?= base_url()."Home/generalSetting?shop=" ?>' +shop;
              }
          });
        }
});
}

});


</script>

<script type="text/javascript">
      var titleBarOptions = {
          title: 'Welcome',
      };
      var myTitleBar = TitleBar.create(app, titleBarOptions);
      var okButton = Button.create(app, {label: 'Ok'});
      var cancelButton = Button.create(app, {label: 'Close'});
</script>
</body>
</html>
