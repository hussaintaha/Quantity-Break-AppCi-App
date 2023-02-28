<?php
// dd($d_prices);
// dd($discount_set);
// dd($previousCount);
?>

<div style="min-height: 500px;"  id="CreatePageMenus" >
  <div style="--top-bar-background:#357997; --top-bar-color:rgb(255, 255, 255); --top-bar-border:rgb(196, 205, 213); --top-bar-background-lighter:hsla(198, 33%, 55%, 1); --p-frame-offset:0px;">
    <div class="" data-polaris-layer="true" data-has-navigation="true">
      <!-- table start -->
      <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

        <!-- <div class="Polaris-Page"> -->
        <div>
          <!-- <div class="Polaris-Page-Header Polaris-Page-Header--mobileView"> -->
            <div>
            <div class="Polaris-Page-Header__MainContent">

              <div class="Polaris-Page-Header__TitleActionMenuWrapper">

                <div>

                  <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">

                    <div class="Polaris-Header-Title">

                      <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge margin-5" >Product Pricing Groups</h1>
                      <small class="color-gray">A pricing group is where you set up your bulk discounts.</small>

                    </div>
                    <div style="margin-top:10px">
                      <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeSlim OpenCreateDiv" class="welcomPagge">
                        <span class="Polaris-Button__Content">
                          <span class="Polaris-Button__Text">Create product price group</span>
                        </span>
                      </button>
                    </div>
                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="Polaris-Page__Content">

            <div class="Polaris-Card">

              <div class="">

                <div class="Polaris-DataTable__Navigation"><button type="button" class="Polaris-Button Polaris-Button--disabled Polaris-Button--plain Polaris-Button--iconOnly" disabled="" aria-label="Scroll table left one column"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">

                            <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>

                          </svg></span></span></span></button><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Scroll table right one column"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">

                            <path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16" fill-rule="evenodd"></path>

                          </svg></span></span></span></button></div>

                  <div class="Polaris-DataTable">

                    <div class="Polaris-DataTable__ScrollContainer">
                     <?php if($discount_set) { ?>
                      <table class="Polaris-DataTable__Table">

                        <thead>

                          <tr>

                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--header" scope="col">Name</th>
                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--header" scope="col">Edit</th>

                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Products</th>

                            <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Delete</th>
                          </tr>

                        </thead>

                        <tbody>

                            <?php
                            if($discount_set > 0){
                            foreach ($discount_set as $discountSet) {  ?>
                            <tr class="Polaris-DataTable__TableRow">

                              <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row"><?= $discountSet->set_name ?></th>
                              <td><a rel="tooltip"  title="Edit currently selected products"  style="cursor:pointer;" href="<?= base_url().'Home/editGroup?shop='.$_GET['shop'].'&set_id='.$discountSet->id ?>"  class="btn preview-btn">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                              </a></td>
                              <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                <a rel="tooltip"  title="Preview currently selected products"  style="cursor:pointer;" data-setId="<?= $discountSet->id ?>"  class="btn preview-btn showProdutcs">
                                  <i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                              </td>

                              <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                <button class="Polaris-Button Polaris-Button--sizeSlim deleteGroup" data-setId="<?= $discountSet->id ?>" type="button" data-bold-component-id="delete-group-button" >
                                  <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                              </td>

                            </tr>
                          <?php } }  ?>

                        </tbody>

                      </table>
                    <?php }else {  ?>
                        <section class="bv-page__segment">
                            <div class="bv-page__segment-content">
                                <div class="bv-card bv-card--is-sectioned">
                                    <div class="bv-card__content">
                                        <p>Looks like you do not have any groups yet. <a class="OpenCreateDiv" style="cursor:pointer">Click here</a> to create a new Product Pricing Group.</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                      <?php } ?>
                    </div>

                  </div>

              </div>
              <!-- div for table ends -->
            </div>

          </div>

        </div>

      </div>
      <!-- table ends -->
    </div>
  </div>
</div>


<div style="min-height: 500px;Display:none;"  id="NewPricingGroup">
  <div style="--top-bar-background:#357997; --top-bar-color:rgb(255, 255, 255); --top-bar-border:rgb(196, 205, 213); --top-bar-background-lighter:hsla(198, 33%, 55%, 1); --p-frame-offset:0px;">
    <div class="Polaris-Frame Polaris-Frame--hasNav Polaris-Frame--hasTopBar" data-polaris-layer="true" data-has-navigation="true">

      <!-- div for  form-->
      <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

          <div class="">

            <div class="">

              <div class="Polaris-Page-Header__Navigation">

                <div class="Polaris-Page-Header__BreadcrumbWrapper">

                  <nav role="navigation"><a  id="backBtn" class="Polaris-Breadcrumbs__Breadcrumb" type="button" data-polaris-unstyled="true"><span class="Polaris-Breadcrumbs__ContentWrapper"><span class="Polaris-Breadcrumbs__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">

                              <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>

                            </svg></span></span><span class="Polaris-Breadcrumbs__Content">Back</span></span></a></nav>

                </div>

              </div>

              <div class="Polaris-Page-Header__MainContent">

                <div class="Polaris-Page-Header__TitleActionMenuWrapper">

                  <div>

                    <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">

                      <div class="Polaris-Header-Title">

                        <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Create Product Pricing Group</h1>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

            </div>
              <form method="post" id="ProductPricingGroup" >
            <div class="Polaris-Page__Content">
                <div style="--top-bar-background: #00848e;--top-bar-background-lighter: #1d9ba4;--top-bar-color: #f9fafb;--p-frame-offset: 0px;">
                  <section class="segment with-annotation">
                            <div class="content">
                                <aside class="annotation">
                                    <h2 class="annotated-text-header">Group Options</h2>
                                    <p>Name your group and take care of a few settings.</p>
                                    <a class="btn" target="_blank" href="#">Support</a>
                                </aside>
                                <div class="card annotation-card">
                                    <div class="bv-grid">
                                        <div class="bv-grid__column bv-grid__column--half">
                                            <div class="bv-field bv-field--with-input">
                                              <div class="Polaris-Labelled__LabelWrapper">
                                                 <div class="Polaris-Label"><label id="bevyField1Label" for="bevyField1" class="Polaris-Label__Text">Internal Name</label></div>
                                               </div>
                                               <div class="Polaris-Connected">
                                                 <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                   <div class="Polaris-TextField Polaris-TextField--hasValue"><input id="bevyField1" name="name" class="Polaris-TextField__Input" maxlength="50" data-bold-component-id="group-internal-name" aria-labelledby="bevyField1Label" aria-invalid="false" aria-multiline="false" placeholder="Eg. Summer Collection" required>
                                                     <div class="Polaris-TextField__Backdrop"></div>
                                                   </div>
                                                   <small>This field is for internal use only so you can easily identify your groups.</small>
                                                 </div>
                                               </div>
                                            </div>
                                        </div>
                                        <div class="bv-grid__column bv-grid__column--half">
                                            <div class="bv-field bv-field--with-select">
                                              <div class="">
                                              <div class="Polaris-Labelled__LabelWrapper">
                                                <div class="Polaris-Label"><label id="bevyField2Label" for="bevyField2" class="Polaris-Label__Text">Calculation Type</label></div>
                                              </div>
                                              <div class="Polaris-Select">
                                                <select id="bevyField2" name="price_type" class="Polaris-Select__Input" aria-invalid="false" data-bold-component-id="group-calculation-type">
                                                  <?php
                                                  foreach ($d_prices as $rule) { ?>
                                                      <option value="<?= $rule->value ?>" ><?= $rule->price_type ?></option>
                                                   <?php } ?>
                                                </select>
                                                <div class="Polaris-Select__Content" aria-hidden="true"><span class="Polaris-Select__SelectedOption">Percent Discount</span><span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                        <path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path>
                                                      </svg></span></span></div>
                                                <div class="Polaris-Select__Backdrop"></div>
                                              </div>
                                                <small>This field is for setting the type of discount you want.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bv-grid">
                                        <div class="bv-grid__column">
                                            <div class="bv-field">
                                                <div class="bv-checkbox-field">
                                                    <label class="Polaris-Choice" for="bevyField3">
                                                      <span class="Polaris-Choice__Control"><span class="Polaris-Checkbox">
                                                        <input id="bevyField3" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false"  name="override_cents" data-bold-component-id="group-override-cents" value="">
                                                        <span class="Polaris-Checkbox__Backdrop"></span><span class="Polaris-Checkbox__Icon"><span class="Polaris-Icon">
                                                          <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                              <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                                            </svg></span></span></span></span>
                                                            <span class="Polaris-Choice__Label">Override Cents</span>
                                                    </label>
                                                </div>
                                                <small class="Polaris-Choice__Descriptions">Replaces the cents of the discounted price with the submitted value.</small>
                                            </div>
                                        </div>
                                        <div class="bv-grid__column">
                                            <div class="bv-field">
                                              <div class="Polaris-Stack Polaris-Stack--vertical">
                                                <div class="Polaris-Stack__Item">
                                                  <div><label class="Polaris-Choice" for="bevyField4"><span class="Polaris-Choice__Control"><span class="Polaris-RadioButton">
                                                    <input id="bevyField4"  name="apply_setting" checked="checked"  type="radio" class="Polaris-RadioButton__Input" aria-describedby="bevyField4HelpText" value="0" >
                                                    <span class="Polaris-RadioButton__Backdrop"></span><span class="Polaris-RadioButton__Icon"></span></span></span><span class="Polaris-Choice__Label">
                                                      Apply Customer Quantity Pricing per individual variants</span></label>
                                                    <div class="Polaris-Choice__Descriptions">
                                                      <small id="bevyField4HelpText">Custom pricing will apply to specific variants (i.e. Buy 5 of the same Large Red shirt to get price break)</small>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="Polaris-Stack__Item">
                                                  <div><label class="Polaris-Choice" for="bevyField5"><span class="Polaris-Choice__Control"><span class="Polaris-RadioButton">
                                                    <input id="bevyField5" name="apply_setting" type="radio" class="Polaris-RadioButton__Input" aria-describedby="bevyField5HelpText" value="1"><span class="Polaris-RadioButton__Backdrop"></span><span class="Polaris-RadioButton__Icon"></span></span></span><span class="Polaris-Choice__Label">Apply Customer Quantity Pricing per product</span></label>
                                                    <div class="Polaris-Choice__Descriptions">
                                                      <small id="bevyField5HelpText">Custom pricing will apply to all variants in a product (i.e. Buy ANY 5 shirts (any size, any colour) to receive price break)</small>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="segment with-annotation">
                                  <div class="content">
                                      <aside class="annotation">
                                          <h2 class="annotated-text-header">Select Products</h2>
                                          <p>Choose the products or collections you want to apply your discounts to.</p>
                                      </aside>
                                      <div class="card annotation-card">
                                          <div class="product-selector">
                                              <div>
                                                <button type="button" class="Polaris-Button" id="select_products"><span class="bv-button__text">
                                                  Select Products</span><span class="bv-loading-spinner bv-button__spinner"></span></button>
                                                </div>
                                              <div id="selected_products">
                                              </div>
                                              <h2>Selected Products</h2>
                                              <div style="overflow-y: scroll;max-height: 200px;">
                                                  <table id="selectedTable" class="table with-row-borders">
                                                  <thead>
                                                      <tr>
                                                        <th class="name-column">Image</th>
                                                        <th class="name-column">Title</th>
                                                        <th class="name-column">Price</th>
                                                        <th class="name-column">Remove</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                                </table>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </section>
                              <section class="segment with-annotation">
                            <div class="content">
                                <aside class="annotation">
                                    <h2 class="annotated-text-header">Configure Price Levels</h2>
                                    <p>Choose your quantity breaks</p>
                                </aside>
                                <div class="card annotation-card annotation-card__price-levels">
                                    <div>
                                        <div class="tag-level-table__container">
                                            <table class="table tag-level-table" id="discount_table">
                                                <thead>
                                                    <tr class="tag-level-table__header-row" data-bold-component-id="group-tag-level-table-heading-row">
                                                        <th class="tag-level-table__qty-col">Qty.</th>
                                                        <th>Discount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="">
                                                        <td class="tag-level-table__qty-cell ">
                                                          <label><input name="" type="number" min="0" step="any" disabled="" value="1">+</label>
                                                        </td>
                                                        <td class="tag-level-table__tag-level-cell disabled">
                                                          <label>
                                                            <input name="" type="number" min="0" step="any" placeholder="" data-bold-component-id="group-tag-level-index-0" disabled="" value="">
                                                          </label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="tag-level-table__add-qty-btn">
                                                            <button class="bv-button bv-button--primary add_discount" type="button">
                                                                <span class="bv-button__text">
                                                                    <span class="bv-icon">
                                                                        <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                                            <path class="bv-icon__path" fill="currentColor" d="M10.5,10.5 L3.5,10.5 C2.67157288,10.5 2,11.1715729 2,12 C2,12.8284271 2.67157288,13.5 3.5,13.5 L10.5,13.5 L10.5,20.5 C10.5,21.3284271 11.1715729,22 12,22 C12.8284271,22 13.5,21.3284271 13.5,20.5 L13.5,13.5 L20.5,13.5 C21.3284271,13.5 22,12.8284271 22,12 C22,11.1715729 21.3284271,10.5 20.5,10.5 L13.5,10.5 L13.5,3.5 C13.5,2.67157288 12.8284271,2 12,2 C11.1715729,2 10.5,2.67157288 10.5,3.5 L10.5,10.5 Z"></path>
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                                <span class="bv-loading-spinner bv-button__spinner"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="tag-level-table__message-error" style="display:none"><p><svg class="bv-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M79.9997552,129.802648 C73.7607552,129.802648 68.7027552,124.744648 68.7027552,118.505648 C68.7027552,112.266648 73.7607552,107.208648 79.9997552,107.208648 C86.2387552,107.208648 91.2967552,112.266648 91.2967552,118.505648 C91.2967552,124.744648 86.2387552,129.802648 79.9997552,129.802648 L79.9997552,129.802648 Z M90.0417552,49.4686479 L87.5307552,100.468648 L72.4687552,100.468648 L69.9577552,49.4686479 L90.0417552,49.4686479 Z M158.641755,135.221648 L123.657755,74.6006479 L88.6557552,14.0086479 C84.8047552,7.34964787 75.1917552,7.32064787 71.3427552,13.9806479 L36.3367552,74.5336479 L1.35875525,135.227648 C-2.49724475,141.893648 2.31275525,150.468648 10.0137552,150.468648 L79.9977552,150.468648 L149.985755,150.468648 C157.685755,150.468648 162.496755,141.887648 158.641755,135.221648 L158.641755,135.221648 Z"></path></svg>You must have at least one price level for your group.</p>
                                        </div>
                                        <div class="tag-level-table__message-error1" style="display:none"><p><svg class="bv-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M79.9997552,129.802648 C73.7607552,129.802648 68.7027552,124.744648 68.7027552,118.505648 C68.7027552,112.266648 73.7607552,107.208648 79.9997552,107.208648 C86.2387552,107.208648 91.2967552,112.266648 91.2967552,118.505648 C91.2967552,124.744648 86.2387552,129.802648 79.9997552,129.802648 L79.9997552,129.802648 Z M90.0417552,49.4686479 L87.5307552,100.468648 L72.4687552,100.468648 L69.9577552,49.4686479 L90.0417552,49.4686479 Z M158.641755,135.221648 L123.657755,74.6006479 L88.6557552,14.0086479 C84.8047552,7.34964787 75.1917552,7.32064787 71.3427552,13.9806479 L36.3367552,74.5336479 L1.35875525,135.227648 C-2.49724475,141.893648 2.31275525,150.468648 10.0137552,150.468648 L79.9977552,150.468648 L149.985755,150.468648 C157.685755,150.468648 162.496755,141.887648 158.641755,135.221648 L158.641755,135.221648 Z"></path></svg>Validation error. Please Fill Above field.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="segment with-annotation">
                            <div class="content">
                                <aside class="annotation">
                                    <h2 class="annotated-text-header">Quantity Breaks Grid Style</h2>
                                    <p>These price tables will only appear on products if you have quantity based pricing on this customer price group.</p>
                                </aside>
                                <div class="card annotation-card">
                                    <div class="qb-displays">
                                        <div class="qb-displays__controls">
                                          <div class="Polaris-Labelled__LabelWrapper">
                                              <div class="Polaris-Label"><label id="bevyField6Label" for="bevyField6" class="Polaris-Label__Text">Select a grid style*</label></div>
                                            </div>
                                            <div class="Polaris-Select">
                                              <select id="bevyField6" class="Polaris-Select__Input" aria-invalid="false" name="custom_display">
                                                <option value="1">Detailed Grid</option>
                                                <option value="2">Basic Grid</option>
                                                <option value="3">Grid Range</option>
                                                <option value="5">Detailed Grid Percent</option>
                                                <option value="6">Percent Grid</option>
                                              </select>
                                              <div class="Polaris-Select__Content" aria-hidden="true"><span class="Polaris-Select__SelectedOption">Detailed Grid</span><span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                      <path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path>
                                                    </svg></span></span></div>
                                              <div class="Polaris-Select__Backdrop"></div>
                                            </div>
                                        </div>
                                        <div class="qb-displays__customize">
                                            <div class="qb-displays__customize__edit hide">
                                                <div class="qb-displays__customize__edit__toolbar"></div>
                                            </div>
                                            <div class="qb-displays__customize__preview">
                                                <h3 class="mb1">Grid Preview</h3>
                                                <div class="qb-displays__customize__preview__box" id="tbl_prev">
                                                    <table class="shappify_qb_grid" style="display: none;">
                                                        <thead><tr><th>Qty</th><th>Price</th></tr></thead>
                                                        <tbody>
                                                          <tr><td>Buy 1</td><td>Rs. 100.00 ea</td></tr>
                                                            <tr><td>Buy 50</td><td>Rs. 95.00 ea</td></tr>
                                                            <tr><td>Buy 100</td><td>Rs. 90.00 ea</td></tr>
                                                            <tr><td>Buy 1000</td><td>Rs. 85.00 ea</td></tr>
                                                        </tbody>
                                                    </table>
                                                <table style="display: none;" ;="" class="shappify_qb_grid 1">  <thead>   <tr>    <th>Qty</th>    <th>Price</th>   </tr>  </thead>  <tbody>     <tr>    <td>Buy 1</td>    <td>Rs. 100.00 ea</td>   </tr>     <tr>    <td>Buy 50</td>    <td>Rs. 95.00 ea</td>   </tr>     <tr>    <td>Buy 100</td>    <td>Rs. 90.00 ea</td>   </tr>     <tr>    <td>Buy 1000</td>    <td>Rs. 85.00 ea</td>   </tr>    </tbody>  </table>
                                                <table style="display: none;" ;="" class="shappify_qb_grid 2">  <thead>   <tr>    <th>Qty</th>    <th>Price</th>   </tr>  </thead>  <tbody>     <tr>    <td>1</td>    <td>Rs. 100.00</td>   </tr>     <tr>    <td>50</td>    <td>Rs. 95.00</td>   </tr>     <tr>    <td>100</td>    <td>Rs. 90.00</td>   </tr>     <tr>    <td>1000</td>    <td>Rs. 85.00</td>   </tr>    </tbody>  </table>
                                                <table style="display: none;" ;="" class="shappify_qb_grid 3">  <thead>   <tr>    <th>Minimum Qty</th>    <th>Maximum Qty</th>    <th>Price</th>   </tr>  </thead>  <tbody>     <tr>    <td>1</td>    <td>49</td>    <td>Rs. 100.00</td>   </tr>     <tr>    <td>50</td>    <td>99</td>    <td>Rs. 95.00</td>   </tr>     <tr>    <td>100</td>    <td>999</td>    <td>Rs. 90.00</td>   </tr>     <tr>    <td>1000</td>    <td>+</td>    <td>Rs. 85.00</td>   </tr>    </tbody>  </table>
                                                <table style="display:none" ;="" class="shappify_qb_grid 4">  <thead>   <tr>    <th>Qty</th>    <th>Price</th>    <th>Discount</th>   </tr>  </thead>  <tbody>     <tr>    <td>Buy 1</td>    <td>Rs. 100.00 ea</td>    <td>0% Off</td>   </tr>     <tr>    <td>Buy 50</td>    <td>Rs. 95.00 ea</td>    <td>5% Off</td>   </tr>     <tr>    <td>Buy 100</td>    <td>Rs. 90.00 ea</td>    <td>10% Off</td>   </tr>     <tr>    <td>Buy 1000</td>    <td>Rs. 85.00 ea</td>    <td>15% Off</td>   </tr>    </tbody>  </table>
                                                <table style="display:none" ;="" class="shappify_qb_grid 5">  <thead>   <tr>    <th>Qty</th>    <th>Discount</th>   </tr>  </thead>  <tbody>     <tr>    <td>Buy 1</td>    <td>0% Off</td>   </tr>     <tr>    <td>Buy 50</td>    <td>5% Off</td>   </tr>     <tr>    <td>Buy 100</td>    <td>10% Off</td>   </tr>     <tr>    <td>Buy 1000</td>    <td>15% Off</td>   </tr>    </tbody>  </table>
                                                <table style="" ;="" class="shappify_qb_grid 6"> <thead>      <tr>          <th>Qty</th>          <th>Price</th>      </tr>  </thead>  <tbody>        <tr>          <td>1 - 49</td>          <td>Rs. 100.00</td>      </tr>        <tr>          <td>50 - 99</td>          <td>Rs. 95.00</td>      </tr>        <tr>          <td>100 - 999</td>          <td>Rs. 90.00</td>      </tr>        <tr>          <td>1000 - +</td>          <td>Rs. 85.00</td>      </tr>    </tbody>  </table>
                                                  <style>table.shappify_qb_grid{ width:auto; } div.bold_qb_grid{ width: 100%; }</style>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <aside class="annotation"></aside>
                                <div class="card annotation-card">
                                    <div class="card-section actions">
                                        <div class="bv-grid group-page-actions">
                                            <div class="bv-grid__column bv-grid__column--half">
                                                <div class="field toggle-field with-switch">
                                                    <label for="toggleField0">
                                                        <input id="toggleField0" type="checkbox" name="status" data-bold-component-id="group-status-toggle" value="false">Group Status
                                                        <div class="toggle-field-switch"></div>
                                                        <p class="bv-field__help-text">Group will sync after save.</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="bv-grid__column bv-grid__column--half">
                                                <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                                                  <button type="submit" class="Polaris-Button Polaris-Button--primary" data-bold-component-id="group-save-button" >
                                                    <span class="Polaris-Button__Content">
                                                      <span class="Polaris-Button__Text">Save</span>
                                                    </span>
                                                  </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                </div>
            </div>

          </div>

        </div>
    </div>
  </div>
</div>
</form>
<div class="Polaris-Frame-ToastManager" aria-live="polite"></div>
