<?php #dd($d_rules); ?>
<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

  <div class="Polaris-Page" style="padding: 0;">

    <div class="Polaris-Page-Header Polaris-Page-Header--separator Polaris-Page-Header--mobileView" style="padding: 0;border: none;">

      <div class="Polaris-Page-Header__MainContent">

        <div class="Polaris-Page-Header__TitleActionMenuWrapper">

          <div>

            <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">

              <div class="Polaris-Header-Title">

                <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">Product Pricing Groups</h3>
                <p>A pricing group is where you set up your bulk discounts.</p>
              </div>
              <div>
                <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;text-align: right;">
                  <button type="button" class="Polaris-Button Polaris-Button--primary OpenCreateDiv">
                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Create Product Pricing Group</span></span>
                  </button>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>

    </div>

    <div class="Polaris-Page__Content">

      <div class="Polaris-Layout">

        <div class="Polaris-Layout__AnnotatedSection">
          <div class="Polaris-Layout__AnnotationWrapper">

            <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

              <div class="">

                <div class="Polaris-Page__Content">

                  <div class="">
                    <form method="post" id="EditProductPricingGroup" >
                    <div class="bv-container" id="NewPricingGroup" >
                        <header class="bv-page__header">
                            <div class="bv-page__header-content">
                                <h1>Create Product Pricing Group</h1>
                                <a href="<?= base_url().'Home/welcome?shop='.$_GET['shop'] ?>"></a>
                            </div>
                        </header>
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
                                                <label for="bevyField1" class="bv-field__label">Internal Name</label>
                                                <div class="bv-input">
                                                    <input id="bevyField1" class="bv-input__input-element " name="name" type="text" maxlength="50" data-bold-component-id="group-internal-name" value="<?= $groupName->set_name ?>" required>
                                                </div>
                                                <div class="bv-field__help-text">This field is for internal use only so you can easily identify your groups.</div>
                                            </div>
                                        </div>

                                        <div class="bv-grid__column bv-grid__column--half">
                                            <div class="bv-field bv-field--with-select">
                                                <label for="bevyField2" class="bv-field__label">Calculation Type</label>
                                                <div class="bv-select bv-select--has-value">
                                                    <select id="bevyField2" name="price_type" class="bv-select__select-element" data-bold-component-id="group-calculation-type">
                                                      <?php
                                                      $d_prices = $d_prices[0];
                                                      foreach ($d as $rule) { ?>
                                                          <option value="<?= $rule->value ?>" <?php echo $rule->id == $dis_type? 'selected':'' ?> ><?= $rule->price_type ?></option>
                                                       <?php } ?>
                                                    </select>
                                                    <span class="bv-icon bv-select__icon">
                                                        <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                            <path class="bv-icon__path" fill="currentColor" d="M3.75261265,6.34153452 C3.38894463,5.92588561 2.75718344,5.88374677 2.34153452,6.24741478 C1.92588561,6.6110828 1.88374677,7.24284399 2.24741478,7.65849291 L11.2524148,18.2364929 C11.6508167,18.6918404 12.3591606,18.6918563 12.757583,18.2365268 L21.763583,7.6585268 C22.1272697,7.24289426 22.0851593,6.61113117 21.6695268,6.24744443 C21.2538943,5.8837577 20.6221312,5.9258681 20.2584444,6.34150064 L12.0050479,16.0594019 L3.75261265,6.34153452 Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="bv-field__help-text">This field is for setting the type of discount you want.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bv-grid">
                                        <div class="bv-grid__column bv-grid__column--half">
                                            <div class="bv-field bv-field--with-checkbox-field">
                                                <div class="bv-checkbox-field">
                                                    <span class="bv-checkbox bv-checkbox-field__checkbox">
                                                        <input type="checkbox" class="bv-checkbox__input" id="bevyField3" name="override_cents" data-bold-component-id="group-override-cents" value="">
                                                        <span class="bv-checkbox__box">
                                                            <span class="bv-icon bv-checkbox__icon">
                                                                <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                                    <path class="bv-icon__path" fill="currentColor" d="M9.5,16.3786797 L4.56066017,11.4393398 C3.97487373,10.8535534 3.02512627,10.8535534 2.43933983,11.4393398 C1.85355339,12.0251263 1.85355339,12.9748737 2.43933983,13.5606602 L8.43933983,19.5606602 C9.02512627,20.1464466 9.97487373,20.1464466 10.5606602,19.5606602 L22.5606602,7.56066017 C23.1464466,6.97487373 23.1464466,6.02512627 22.5606602,5.43933983 C21.9748737,4.85355339 21.0251263,4.85355339 20.4393398,5.43933983 L9.5,16.3786797 Z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </span>
                                                    <label for="bevyField3" class="bv-checkbox-field__label">Override Cents</label>
                                                </div>
                                                <div class="bv-field__help-text">Replaces the cents of the discounted price with the submitted value.</div>
                                            </div>
                                        </div>
                                        <div class="bv-grid__column">
                                            <div class="bv-field bv-field--with-radio-field">
                                                <div class="bv-radio-field">
                                                    <span class="bv-radio bv-radio--is-checked bv-radio-field__radio">
                                                    <input type="radio" id="bevyField4" name="apply_setting" checked="checked" class="bv-radio__input" value="0">
                                                    <span class="bv-radio__box"></span>
                                                    </span>
                                                    <label for="bevyField4" class="bv-radio-field__label">Apply Customer Quantity Pricing per individual variants</label>
                                                </div>
                                                <div class="bv-field__help-text">Custom pricing will apply to specific variants (i.e. Buy 5 of the same Large Red shirt to get price break)</div>
                                            </div>
                                            <div class="bv-field bv-field--with-radio-field">
                                                <div class="bv-radio-field">
                                                    <span class="bv-radio bv-radio-field__radio">
                                                    <input type="radio" id="bevyField5"  name="apply_setting" class="bv-radio__input" value="1">
                                                    <span class="bv-radio__box">
                                                    </span>
                                                    </span>
                                                    <label for="bevyField5" class="bv-radio-field__label">Apply Customer Quantity Pricing per product</label>
                                                </div>
                                                <div class="bv-field__help-text">Custom pricing will apply to all variants in a product (i.e. Buy ANY 5 shirts (any size, any colour) to receive price break)</div>
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
                                          <button type="button" class="bv-button prod-selector-button" id="select_products"><span class="bv-button__text">
                                            Select Products</span><span class="bv-loading-spinner bv-button__spinner"></span></button>
                                          </div>
                                        <div id="selected_products">
                                        </div>
                                        <br/>
                                        <br/>
                                        <h2>Selected Products</h2>
                                        <div style="overflow-y: scroll;max-height: 200px;">
                                            <table id="selectedTable" class="table with-row-borders">
                                            <thead>
                                                <tr>
                                                  <th class="name-column" >Image</th>
                                                  <th class="name-column" >Title</th>
                                                  <th class="name-column" >Price</th>
                                                  <th class="name-column" >Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php foreach ($product as $p) { ?>
                                              <tr id="tr_<?= $p->p_id ?>">
                                              <td><img height="50px" src="<?= $p->image ?>" alt="<?= $p->title ?>"></td>
                                              <td><?= $p->title ?></td>
                                              <td><?= $p->price ?></td>
                                              <td><input type="button" onclick="RemoveFromList(<?= $p->p_id ?>)" style="cursor:pointer;" value="X" ></td>
                                              <input type="hidden" class="attr_<?= $p->p_id ?>  sl_prd prc<?= $p->p_id ?>"  name="<?= $p->p_id ?>image" value="<?= $p->image ?>">
                                              <input type="hidden" class="attr_<?= $p->p_id ?>  sl_prd prc<?= $p->p_id ?>"  name="<?= $p->p_id ?>title" value="<?= $p->title ?>">
                                              <input type="hidden" class="attr_<?= $p->p_id ?> sl_prd prc<?= $p->p_id ?>"  name="<?= $p->p_id ?>price" value="<?= $p->price ?>">
                                              <input type="hidden" class="<?= $p->p_id ?>  sl_prd prc<?= $p->p_id ?>"  name="selected_products[]" value="<?= $p->p_id ?>">
                                              <input type="hidden" class="<?= $p->p_id ?>  sl_prd prc<?= $p->p_id ?>"  name="<?= $p->p_id ?>[]" value="">
                                              </tr>
                                            <?php  } ?>
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
                                                    <?php foreach ($set_price as $set_price): ?>
                                                      <tr class="">
                                                        <td class="tag-level-table__qty-cell ">
                                                        <label><input name="pb_quantity[]" class="pb_quantity" type="number" min="2" step="any"  value="<?= $set_price->qty ?>">+</label>
                                                        </td>
                                                        <td class="tag-level-table__tag-level-cell ">
                                                          <label>
                                                          <input name="pb_quantity_price[]" class="pb_quantity_price" type="number" min="0" step="any" value="<?= $set_price->discount_price ?>">
                                                          </label>
                                                        </td>
                                                        <td class="tag-level-table__delete-qty-btn">
                                                          <button class="bv-button remove_tr" onclick="RemoveTr(this)">
                                                            <span class="bv-button__text">
                                                            <span class="bv-icon"><svg class="bv-icon__icon" viewBox="0 0 24 24"><path class="bv-icon__path" fill="currentColor" d="M11.5,10.3786797 L4.56066017,3.43933983 C3.97487373,2.85355339 3.02512627,2.85355339 2.43933983,3.43933983 C1.85355339,4.02512627 1.85355339,4.97487373 2.43933983,5.56066017 L9.37867966,12.5 L2.43933983,19.4393398 C1.85355339,20.0251263 1.85355339,20.9748737 2.43933983,21.5606602 C3.02512627,22.1464466 3.97487373,22.1464466 4.56066017,21.5606602 L11.5,14.6213203 L18.4393398,21.5606602 C19.0251263,22.1464466 19.9748737,22.1464466 20.5606602,21.5606602 C21.1464466,20.9748737 21.1464466,20.0251263 20.5606602,19.4393398 L13.6213203,12.5 L20.5606602,5.56066017 C21.1464466,4.97487373 21.1464466,4.02512627 20.5606602,3.43933983 C19.9748737,2.85355339 19.0251263,2.85355339 18.4393398,3.43933983 L11.5,10.3786797 Z"></path></svg></span></span>
                                                            <span class="bv-loading-spinner bv-button__spinner"></span></button>
                                                          </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="tag-level-table__add-qty-btn">
                                                            <button class="bv-button bv-button--primary add_discount" type="button" >
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
                                            <div class="bv-field bv-field--with-select">
                                                <label for="bevyField6" class="bv-field__label">Select a grid style*</label>
                                                <div class="bv-select bv-select--has-value">
                                                    <select id="bevyField6" name="custom_display" class="bv-select__select-element">
                                                        <option value="1" <?php echo $getGridName->grid_style == 1 ? 'selected': '' ?>>Detailed Grid</option>
                                                        <option value="2" <?php echo $getGridName->grid_style == 2 ? 'selected': '' ?>>Basic Grid</option>
                                                        <option value="3" <?php echo $getGridName->grid_style == 3 ? 'selected': '' ?>>Grid Range</option>
                                                        <option value="5" <?php echo $getGridName->grid_style == 4 ? 'selected': '' ?>>Detailed Grid Percent</option>
                                                        <option value="6" <?php echo $getGridName->grid_style == 5 ? 'selected': '' ?>>Percent Grid</option>
                                                    </select>
                                                    <span class="bv-icon bv-select__icon">
                                                        <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                            <path class="bv-icon__path" fill="currentColor" d="M3.75261265,6.34153452 C3.38894463,5.92588561 2.75718344,5.88374677 2.34153452,6.24741478 C1.92588561,6.6110828 1.88374677,7.24284399 2.24741478,7.65849291 L11.2524148,18.2364929 C11.6508167,18.6918404 12.3591606,18.6918563 12.757583,18.2365268 L21.763583,7.6585268 C22.1272697,7.24289426 22.0851593,6.61113117 21.6695268,6.24744443 C21.2538943,5.8837577 20.6221312,5.9258681 20.2584444,6.34150064 L12.0050479,16.0594019 L3.75261265,6.34153452 Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="qb-displays__customize">
                                            <div class="qb-displays__customize__edit hide">
                                                <div class="qb-displays__customize__edit__toolbar"></div>
                                            </div>
                                            <div class="qb-displays__customize__preview">
                                                <h3 class="mb1">Grid Preview</h3>
                                                <div class="qb-displays__customize__preview__box" id="tbl_prev">
                                                    <table class="shappify_qb_grid">
                                                        <thead><tr><th>Qty</th><th>Price</th></tr></thead>
                                                        <tbody>
                                                          <tr><td>Buy 1</td><td>Rs. 100.00 ea</td></tr>
                                                            <tr><td>Buy 50</td><td>Rs. 95.00 ea</td></tr>
                                                            <tr><td>Buy 100</td><td>Rs. 90.00 ea</td></tr>
                                                            <tr><td>Buy 1000</td><td>Rs. 85.00 ea</td></tr>
                                                        </tbody>
                                                    </table>
                                                <table  style="display:none"; class="shappify_qb_grid 1">  <thead>   <tr>    <th>Qty</th>    <th>Price</th>   </tr>  </thead>  <tbody>     <tr>    <td>Buy 1</td>    <td>Rs. 100.00 ea</td>   </tr>     <tr>    <td>Buy 50</td>    <td>Rs. 95.00 ea</td>   </tr>     <tr>    <td>Buy 100</td>    <td>Rs. 90.00 ea</td>   </tr>     <tr>    <td>Buy 1000</td>    <td>Rs. 85.00 ea</td>   </tr>    </tbody>  </table>
                                                <table style="display:none"; class="shappify_qb_grid 2">  <thead>   <tr>    <th>Qty</th>    <th>Price</th>   </tr>  </thead>  <tbody>     <tr>    <td>1</td>    <td>Rs. 100.00</td>   </tr>     <tr>    <td>50</td>    <td>Rs. 95.00</td>   </tr>     <tr>    <td>100</td>    <td>Rs. 90.00</td>   </tr>     <tr>    <td>1000</td>    <td>Rs. 85.00</td>   </tr>    </tbody>  </table>
                                                <table style="display:none"; class="shappify_qb_grid 3">  <thead>   <tr>    <th>Minimum Qty</th>    <th>Maximum Qty</th>    <th>Price</th>   </tr>  </thead>  <tbody>     <tr>    <td>1</td>    <td>49</td>    <td>Rs. 100.00</td>   </tr>     <tr>    <td>50</td>    <td>99</td>    <td>Rs. 95.00</td>   </tr>     <tr>    <td>100</td>    <td>999</td>    <td>Rs. 90.00</td>   </tr>     <tr>    <td>1000</td>    <td>+</td>    <td>Rs. 85.00</td>   </tr>    </tbody>  </table>
                                                <table style="display:none"; class="shappify_qb_grid 4">  <thead>   <tr>    <th>Qty</th>    <th>Price</th>    <th>Discount</th>   </tr>  </thead>  <tbody>     <tr>    <td>Buy 1</td>    <td>Rs. 100.00 ea</td>    <td>0% Off</td>   </tr>     <tr>    <td>Buy 50</td>    <td>Rs. 95.00 ea</td>    <td>5% Off</td>   </tr>     <tr>    <td>Buy 100</td>    <td>Rs. 90.00 ea</td>    <td>10% Off</td>   </tr>     <tr>    <td>Buy 1000</td>    <td>Rs. 85.00 ea</td>    <td>15% Off</td>   </tr>    </tbody>  </table>
                                                <table style="display:none"; class="shappify_qb_grid 5">  <thead>   <tr>    <th>Qty</th>    <th>Discount</th>   </tr>  </thead>  <tbody>     <tr>    <td>Buy 1</td>    <td>0% Off</td>   </tr>     <tr>    <td>Buy 50</td>    <td>5% Off</td>   </tr>     <tr>    <td>Buy 100</td>    <td>10% Off</td>   </tr>     <tr>    <td>Buy 1000</td>    <td>15% Off</td>   </tr>    </tbody>  </table>
                                                <table style="display:none"; class="shappify_qb_grid 6"> <thead>      <tr>          <th>Qty</th>          <th>Price</th>      </tr>  </thead>  <tbody>        <tr>          <td>1 - 49</td>          <td>Rs. 100.00</td>      </tr>        <tr>          <td>50 - 99</td>          <td>Rs. 95.00</td>      </tr>        <tr>          <td>100 - 999</td>          <td>Rs. 90.00</td>      </tr>        <tr>          <td>1000 - +</td>          <td>Rs. 85.00</td>      </tr>    </tbody>  </table>
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
                                                        <input id="toggleField0" type="checkbox" name="status" data-bold-component-id="group-status-toggle" value="false" <?php echo $groupName->status ? 'checked' : '' ?>>Group Status
                                                        <div class="toggle-field-switch"></div>
                                                        <p class="bv-field__help-text">Group will sync after save.</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="bv-grid__column bv-grid__column--half">
                                                <!-- <button class="bv-button bv-button--primary group-page-actions__save-btn" data-bold-component-id="group-save-button">
                                                <span class="bv-button__text">Save</span>

                                                <span class="bv-loading-spinner bv-button__spinner">
                                                </span>
                                                </button> -->
                                                <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                                                  <button type="submit" class="Polaris-Button Polaris-Button--primary" id="ProductPricingGroup" data-bold-component-id="group-save-button">
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
                    </form>
                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>
