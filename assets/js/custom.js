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
    })
    $("#select_products,.close,.close_modal").click(function() {
        $("#myModal").toggle()
        if($("#myModal").is(":visible")){
            getFind_productData();
        }
    })
    $('#product-selector-search-button').on('click', function() {
        getFind_productData();
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

    function getFind_productData() {
        var url = ' + <?php echo base_url(); ?> + ';
        var title = $('#find_product_title').val();
        var getProductURL = url +"Home/GetProducts?shop="+shop+"&title="+title;
        $('.product-selector-paginationss').pagination({
            dataSource: getProductURL,
            locator: 'data',
            classPrefix: 'nav-item',
            activeClassName: 'nav-stub',
            disableClassName: 'nav-stub',
            ulClassName: 'pagination',
            totalNumberLocator: function(response) {
                return Math.floor(Math.random() * (1000 - 100)) + 100;
            },
            pageSize: 50,
            ajax: {
                beforeSend: function() {
                    $('#product-selector-selectable-entity-list').html('Loading data from '+shop+'  .....');
                }
            },
            callback: function(data, pagination) {
                if (data) {
                    var html = generate_product_list_html(data);
                } else {
                    var html = 'No record found';
                }
                $('#product-selector-selectable-entity-list').html(html);
                product_item_selector_item();
            }
        });
    }

    function product_item_selector_item() {
          $(".select_item_product_qb").on('click', function(e) {
           var p_id = $(this).attr('data-product-id'),p_price=$(this).find('.item-price').html(),p_title = $(this).find('.item-title').html(),p_image=$(this).find('.item-image').attr('src');
            if ($(this).hasClass("selected")) {
                $(this).removeClass('selected');
                $("#selected_products").find('.'+p_id).remove();
            } else {
                $(this).addClass('selected');
                if ($("#selected_products").find('.' +p_id).length <= 0) {
                    var table_html="";
                    table_html +='<tr id="tr_' +p_id+ '">';
                    table_html +='<td><img height="50px" src="'+p_image+'"></td>'
                    table_html +='<td>'+p_title+'</td>'
                    table_html +='<td>'+p_price+'</td>'
                    table_html +='<td><input type="button" onclick="RemoveFromList('+p_id+')" style="cursor:pointer;" value="X" ></td>';
                    table_html +='</tr>';
                    $("#selectedTable tbody").append(table_html);
                    var append_txb = "";
                    append_txb+='<input type="hidden" class="attr_'+p_id +' sl_prd prc'+p_id+'"  name="'+p_id+'image" value="'+p_image+ '">';
                    append_txb+='<input type="hidden" class="attr_'+p_id +' sl_prd prc'+p_id+'"  name="'+p_id+'title" value="'+p_title+'">';
                    append_txb+='<input type="hidden" class="attr_'+p_id+' sl_prd prc'+p_id+'"  name="'+p_id+'price" value="'+p_price+'">';
                    append_txb+='<input type="hidden" class="' +p_id+ '  sl_prd prc'+p_id+'"  name="selected_products[]" value="'+p_id+'">';
                    var variants = $(this).attr('variant_ids').split(',');
                    $(variants).each(function(ind, variant) {
                      append_txb+='<input type="hidden" class="'+p_id+'  sl_prd prc'+p_id+'"  name="'+p_id+'[]" value="'+variant+'">';
                    })
                    $("#selected_products").append(append_txb);
                }
            }
        });
    }
    $("#reset_selection").click(function(){
        $(".select_item_product_qb").removeClass('selected');
        $('.sl_prd').remove();
    });

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
          $(".loading").show();
        $.ajax({
            "type":"POST",
            "url": <?= base_url() ?>+"Home/SaveData?shop="+shop,
            "data":payload,
            "dataType":'json',
            "success":function(data){
                $(".loading").hide();
                alert(data.msg);
               location.reload();
            }
        });

    });

    $('.showProdutcs').click(function(){
      var setId = $(this).data('setid');
      var SearrchUrl = <?= base_url() ?>+'Home/GetDiscountSetProducts?shop='+shop+'&set_id='+setId;

      var Popupoptions = {
                title: 'Subscription Produtcs',
                url: SearrchUrl,
                size: Modal.Size.Auto,
                footer: {
                  buttons: {
                    primary: okButton,
                    secondary: [cancelButton],
                  },
                },
              };
          var PopupModal = Modal.create(app, Popupoptions);
          PopupModal.dispatch(Modal.Action.OPEN);
          okButton.subscribe(Button.Action.CLICK, () => {
              PopupModal.dispatch(Modal.Action.CLOSE);
          });
          cancelButton.subscribe(Button.Action.CLICK, () => {
                PopupModal.dispatch(Modal.Action.CLOSE);
          });

    });

    function delete_group(set_id){
      var loading = Loading.create(app);
      var okButton = Button.create(app, {label: 'Ok'});
      var cancelButton = Button.create(app, {label: 'Cancel'});
          var newModalOptions = {
            title: 'Sure To delete',
            message: 'Are you sure to Delete This Group Of discounts?',
            footer: {
              buttons: {
                primary: okButton,
                secondary: [cancelButton],
              },
            },
          };
      var DeleteModal = Modal.create(app, newModalOptions);
      DeleteModal.dispatch(Modal.Action.OPEN);
      okButton.subscribe(Button.Action.CLICK, () => {
          DeleteModal.dispatch(Modal.Action.CLOSE);
          loading.dispatch(Loading.Action.START);
          $(".loading").show();
            $.ajax({
                "type":"POST",
                "url": <?= base_url() ?>+"Home/DeleteDiscountSet",
                "data": {"_token": csrfToken,"set_id": set_id,"shop":shop},
                "dataType":'json',
                "success":function(data){
                    $(".loading").hide();
                  alert(data.msg);
                   location.reload();
                }
            });
      });
      cancelButton.subscribe(Button.Action.CLICK, () => {
            DeleteModal.dispatch(Modal.Action.CLOSE);
      });
    }
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

});
