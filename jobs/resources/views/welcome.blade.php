@extends('layout.app')
@section('content')
<div class="bv-container" id="CreatePageMenus">
    <div>
        <header class="bv-page__header">
            <div class="bv-page__header-content">
                <h1 class="bv-page__title">Product Pricing Groups</h1>
                <p class="bv-page__description">A pricing group is where you set up your bulk discounts.</p>
            </div>
            <div class="bv-page__header-actions">
              <a href="#"  style="display:none;" class="bv-link support-link" target="_blank" rel="noopener noreferrer" data-bold-component-id="support-text-button">Visit Support Page</a>
                <button class="bv-button bv-button--primary OpenCreateDiv" >
                  <span class="bv-button__text">Create Product Pricing Group</span>
                  <span class="bv-loading-spinner bv-button__spinner"></span>
                </button>
            </div>
        </header>

        @if($discount_set)
        <section class="bv-page__segment">
        	<div class="bv-page__segment-content">
        		<div class="bv-card bv-card--is-sectioned">
        			<div class="bv-card__content">
        			<div class="bv-card__section">
        				<table class="table comfortable entity-list groups-list">
        					<thead class="groups-list__header">
        						<tr>
        							<th class="groups-list__header-name">Name</th>
        							<th class="groups-list__header-name">Products</th>
        							<th class="groups-list__header-delete">Delete</th>
        						</tr>
        					</thead>
        					<tbody>
                  @foreach ($discount_set as $discountSet)
        						<tr class="groups-list__row" data-bold-component-id="group-list-page-group-row">
        							<td class="groups-list__row-name">
        								<div class="cursor-pointer float-left">{{$discountSet->set_name}}</div><span class="sync-status-groups"></span>
        							</td>
        							<td >
                        <a rel="tooltip"  title="Preview currently selected products"  style="cursor:pointer;" data-setId="{{$discountSet->id}}"  class="btn preview-btn showProdutcs">
                          <i class="fa fa-search" aria-hidden="true"></i>
                        </a>
        							</td>
        							<td class="groups-list__row-delete" data-bold-component-id="Test group-delete">
        								<button class="bv-button deleteGroup" data-setId="{{$discountSet->id}}" type="button" data-bold-component-id="delete-group-button" ><span class="bv-button__text"><span class="bv-icon"><svg class="bv-icon__icon" viewBox="0 0 24 24"><path class="bv-icon__path" fill="currentColor" d="M15.8051936,19.2158689 L15.8051936,9.12546464 C15.8051936,8.4765729 15.2979051,7.9497499 14.6730742,7.9497499 C14.0473596,7.9497499 13.5400711,8.4765729 13.5400711,9.12546464 L13.5400711,19.2158689 C13.5400711,19.8656785 14.0473596,20.3915837 14.6730742,20.3915837 C15.2979051,20.3915837 15.8051936,19.8656785 15.8051936,19.2158689 Z M10.4592218,19.2158689 L10.4592218,9.12546464 C10.4592218,8.4765729 9.9519334,7.9497499 9.32710252,7.9497499 C8.70138786,7.9497499 8.1949832,8.4765729 8.1949832,9.12546464 L8.1949832,19.2158689 C8.1949832,19.8656785 8.70138786,20.3915837 9.32710252,20.3915837 C9.9519334,20.3915837 10.4592218,19.8656785 10.4592218,19.2158689 Z M4.07481124,6.36303979 L3.93287653,6.36303979 C2.68904116,6.36303979 2.68904116,4.52741958 3.93287653,4.52741958 L7.59149064,4.52741958 L7.59149064,1.91781011 C7.59149064,1.41091758 8.00915369,1 8.52436717,1 L15.3966231,1 C15.9118366,1 16.3294996,1.41091758 16.3294996,1.91781011 L16.3294996,4.52741958 L20.0671235,4.52741958 C21.3109588,4.52741958 21.3109588,6.36303979 20.0671235,6.36303979 L19.9253655,6.36303979 L19.9253655,21.6232848 C19.9253655,22.3841494 19.3314669,23 18.5996989,23 L5.40047789,23 C4.66782612,23 4.07481124,22.3841494 4.07481124,21.6232848 L4.07481124,6.36303979 L4.07481124,6.36303979 Z M14.4637466,4.52741958 L14.4637466,2.83562021 L9.4572437,2.83562021 L9.4572437,4.52741958 L14.4637466,4.52741958 L14.4637466,4.52741958 Z"></path></svg></span></span><span class="bv-loading-spinner bv-button__spinner"></span>
        								</button>
        							</td>
        						</tr>
                  @endforeach
	               </tbody>
        				</table>
        			</div>
        		</div>
        	</div>
        	</div>
        </section>
        @else
        <section class="bv-page__segment">
            <div class="bv-page__segment-content">
                <div class="bv-card bv-card--is-sectioned">
                    <div class="bv-card__content">
                        <p>Looks like you do not have any groups yet. <a class="OpenCreateDiv" style="cursor:pointer">Click here</a> to create a new Product Pricing Group.</p>
                    </div>
                </div>
            </div>
        </section>
        @endif
    </div>
</div>
<form method="post" id="ProductPricingGroup">
<div class="bv-container" id="NewPricingGroup" style="Display:none;" >
    <header class="bv-page__header">
        <div class="bv-page__header-content">
            <h1 class="bv-page__title">Create Product Pricing Group</h1>
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
                                <input id="bevyField1" class="bv-input__input-element" name="name" type="text" maxlength="50" data-bold-component-id="group-internal-name" value="">
                            </div>
                            <div class="bv-field__help-text">This field is for internal use only so you can easily identify your groups.</div>
                        </div>
                    </div>
                    <div class="bv-grid__column bv-grid__column--half">
                        <div class="bv-field bv-field--with-select">
                            <label for="bevyField2" class="bv-field__label">Calculation Type</label>
                            <div class="bv-select bv-select--has-value">
                                <select id="bevyField2" name="price_type" class="bv-select__select-element" data-bold-component-id="group-calculation-type">
                                    @foreach ($d_rules as $rule)
                                      <option value="{{ $rule->value }}">{{ $rule->price_type }}</option>
                                    @endforeach
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
                      <button type="button" class="bv-button prod-selector-button" id="select_products" ><span class="bv-button__text">
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
                                    <option value="1">Detailed Grid</option>
                                    <option value="2">Basic Grid</option>
                                    <option value="3">Grid Range</option>
                                    <option value="5">Detailed Grid Percent</option>
                                    <option value="6">Percent Grid</option>
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
                                    <input id="toggleField0" type="checkbox" name="status" data-bold-component-id="group-status-toggle" value="false">Group Status
                                    <div class="toggle-field-switch"></div>
                                    <p class="bv-field__help-text">Group will sync after save.</p>
                                </label>
                            </div>
                        </div>
                        <div class="bv-grid__column bv-grid__column--half">
                            <button class="bv-button bv-button--primary group-page-actions__save-btn" data-bold-component-id="group-save-button">
                            <span class="bv-button__text">Save</span>
                            <span class="bv-loading-spinner bv-button__spinner">
                            </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="myModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span  class="close">&times;</span>
                    <h4 class="modal-title">Make a selection</h4>
                </div>
                <div class="modal-body bcr-product-selector">
                  <div class="product-list">
                    <section class="segment">
                      <div class="product-selector-filters">
                        <div id="filterSync" class="field-group">
                          <div class="product-selector-filters__full-width">
                            <div><span class="product-selector-filters__left">Products not showing correctly?<a>Sync with Shopify</a></span><span class="product-selector-filters__right">Last synced Aug 7</span>
                            </div>
                          </div>
                        </div>

                        <div class="field-group" data-bold-component-id="product-selector-search">
                          <label for="search" class="field-group-addon">Search</label>
                          <div role="combobox" aria-haspopup="listbox" aria-owns="react-autowhatever-1" aria-expanded="false" class="search-bar">
                            <input type="text" autocomplete="off" aria-autocomplete="list" aria-controls="react-autowhatever-1" class="input-field data-hj-whitelist" placeholder="Product Name" id="find_product_title" value="">
                            <div id="react-autowhatever-1" role="listbox" class="suggestionsContainer"></div>
                          </div>
                          <button class="btn btn-primary btn-icon" type="button" id="product-selector-search-button">
                            <svg class="boldicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160">
                              <svg class="boldicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160">
                                <path d="M20,54.9997 C20,35.7007 35.701,19.9997 55,19.9997 C74.299,19.9997 90,35.7007 90,54.9997 C90,74.2987 74.299,89.9997 55,89.9997 C35.701,89.9997 20,74.2987 20,54.9997 M156.535,135.3217 L122.677,101.4647 C120.062,98.8487 116.36,97.9947 113.025,98.8827 L100.31,86.1677 C106.417,77.3077 110,66.5737 110,54.9997 C110,24.6237 85.376,-0.0003 55,-0.0003 C24.624,-0.0003 0,24.6237 0,54.9997 C0,85.3757 24.624,109.9997 55,109.9997 C66.574,109.9997 77.308,106.4167 86.168,100.3097 L98.883,113.0247 C97.995,116.3597 98.849,120.0617 101.465,122.6767 L135.323,156.5347 C139.228,160.4407 145.559,160.4407 149.465,156.5347 L156.535,149.4647 C160.441,145.5587 160.441,139.2277 156.535,135.3217"></path>
                              </svg>
                            </svg>
                          </button>
                        </div>
                        <div class="group">
                          <div class="btn-group left">
                            <button class="btn save-store" type="button" data-bold-component-id="product-selector-save-store-button">Save Entire Store</button>
                          </div>
                          <div class="btn-group right">
                            <button class="btn"  type="button" id="reset_selection">Reset Selection</button>
                          </div>
                        </div>
                      </div>
                    </section>
                    <div class="list products-list divided scrollable" id="product-selector-selectable-entity-list" style="height:150px;overflow:scroll;">

                    </div>
                    <div class="">
                      <div class="product-selector-paginationss">

                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="bv-button bv-button--default close_modal"  data-dismiss="modal">Close</button>
                    <button type="button"  style="float: right;" class="bv-button bv-button--primary close_modal" >Make A Selection</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>

@endsection
@section('scripts')
@parent
@if(config('shopify-app.appbridge_enabled'))
<script type="text/javascript">
      var titleBarOptions = {
          title: 'Welcome',
      };
      var myTitleBar = TitleBar.create(app, titleBarOptions);
      var okButton = Button.create(app, {label: 'Ok'});
      var cancelButton = Button.create(app, {label: 'Close'});
</script>
@endif
@endsection
