<?php
  // dd($discount_method);
 ?>
<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

<div>
    <div class="Polaris-Page-Header__TitleActionMenuWrapper">

      <div>

        <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">

          <div class="Polaris-Header-Title" style="padding-bottom: 0.7em;">
            <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge margin-5" >General Settings</h1>
          </div>

        </div>

      </div>

    </div>


  <div class="Polaris-Layout">

    <div class="Polaris-Layout__Section">

      <section class="" style="padding-top:20px;padding-bottom:20px;padding-right:0px;padding-left:0px;border-bottom: 1px solid rgba(0,0,0,.1);">
          <div class="content">
            <div class="Polaris-Card" style="width:100%">
              <div class="Polaris-Card__Header">
                <h2 class="Polaris-Heading">Global Play / Pause</h2>
              </div>
              <div class="Polaris-Card__Section">
                <p>These actions will create batch jobs for the groups affected.</p>
              </div>
              <div class="Polaris-Card__Footer">
                <div class="Polaris-ButtonGroup">
                  <div class="Polaris-ButtonGroup__Item"><button type="button" class="Polaris-Button"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Play All Groups</span></span></button></div>
                </div>
              </div>
            </div>
          </div>
      </section>

    </div>

  </div>
</div>
<div style="padding-top:20px;padding-bottom:20px;padding-right:0px;padding-left:0px;border-bottom: 1px solid rgba(0,0,0,.1);">
  <div class="Polaris-Layout">
    <div class="Polaris-Layout__Section">
      <div class="Polaris-Page-Header__TitleActionMenuWrapper">

        <div>

          <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">

            <div class="Polaris-Header-Title" style="padding-bottom: 0.7em;">

              <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge margin-5">Discount Methods</h1>
              <small class="color-gray">This app can control product pricing using a two different methods. Please select a method. Don't worry you can change this later if you need to.</small>

            </div>

          </div>

        </div>

      </div>
    </div>
  </div>
  <div class="Polaris-Layout">

    <div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf">

      <div class="Polaris-Card">

        <div class="Polaris-Card__Header">

          <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">

            <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">

              <h2 class="Polaris-Heading">Accelerated Method</h2>

            </div>

          </div>

        </div>
        <input type="hidden" name="discount_method" id="discount_method" value="<?= isset($discount_method)? $discount_method : 0 ?>">
        <div class="Polaris-Card__Section"><span class="Polaris-TextStyle--variationSubdued">Discounts using Draft Orders</span></div>

        <div class="Polaris-Card__Section">

          <div class="Polaris-Card__SectionHeader">

            <h3 aria-label="Items" class="Polaris-Subheading">Benefits:</h3>

          </div>

          <div class="Polaris-ResourceList__ResourceListWrapper">

            <ul>
              <li>Less sync time required</li>
              <li>No metafields required</li>
              <li>Less impactful liquid install</li>
              <li>No variants required.</li>
              <li>Faster workflow and performance.</li>
              <li>Less Maintenance.</li>
            </ul>

          </div>

        </div>
        <div class="Polaris-Card__Section">

          <div class="Polaris-ResourceList__ResourceListWrapper">
            <p>We recommend this method if all of the following statements are true:</p>
            <ul><li>Combining discount code discounts with app discounts is not required.</li><li>Shopify Plus cart scripts are not in use.</li></ul>

          </div>

        </div>
        <div class="Polaris-Card__Section">
            <?php if($discount_method == 0 ){ ?>
              <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;"><span class="Polaris-Badge Polaris-Badge--statusInfo"><span class="Polaris-VisuallyHidden">Info</span>Currently you are using this method</span></div>
        <?php }else { ?>
          <button type="button" class="Polaris-Button" id="method1"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">SWITCH TO THIS METHOD</span></span></button>
        <?php } ?>
        </div>
      </div>

    </div>

    <div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf">

      <div class="Polaris-Card">

        <div class="Polaris-Card__Header">

          <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">

            <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">

              <h2 class="Polaris-Heading">Variant Dependent Method</h2>

            </div>

          </div>

        </div>

        <div class="Polaris-Card__Section"><span class="Polaris-TextStyle--variationSubdued">Discounts using product variants</span></div>

        <div class="Polaris-Card__Section">

          <div class="Polaris-Card__SectionHeader">

            <h3 aria-label="Items" class="Polaris-Subheading">Benefits:</h3>

          </div>

          <div class="Polaris-ResourceList__ResourceListWrapper">

            <ul><li>Supports theme settings that hide third-party checkout buttons on checkout</li><li>Discounted products can be combined with discount codes.</li></ul>

          </div>

        </div>


        <div class="Polaris-Card__Section">

          <div class="Polaris-ResourceList__ResourceListWrapper">
            <p>We recommend this method if all of the following statements are true:</p>
            <ul><li>Combining discount code discounts with app discounts is not required.</li><li>Shopify Plus cart scripts are not in use.</li></ul>

          </div>

        </div>
        <div class="Polaris-Card__Section">
          <?php if($discount_method == 1){ ?>
            <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;"><span class="Polaris-Badge Polaris-Badge--statusInfo"><span class="Polaris-VisuallyHidden">Info</span>Currently you are using this method</span></div>
      <?php }else { ?>
        <button type="button" class="Polaris-Button" id="method2"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">SWITCH TO THIS METHOD</span></span></button>
      <?php } ?>

        </div>
      </div>

    </div>

  </div>
</div>

</div>
