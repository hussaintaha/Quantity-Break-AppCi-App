<?php
// dd($install);
?>
<?php if(!empty($install) && $install->status != 0){ ?>
<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;" id="bannerDiv">

  <div class="Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner19Heading" aria-describedby="Banner19Content" style="margin-bottom:15px">

    <div class="Polaris-Banner__Dismiss"><button type="button" id="close" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">

                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>

              </svg></span></span></span></button></div>

    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">

          <circle fill="currentColor" cx="10" cy="10" r="9"></circle>

          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>

        </svg></span></div>

    <div class="Polaris-Banner__ContentWrapper">
      <div class="Polaris-Banner__Heading" id="Banner19Heading">

        <p class="Polaris-Heading">Expert Installation Service</p>

      </div>
      <ul style="list-style:none">
        <li><?php echo !empty($install) && $install->status > 0 ? '<i class="fa fa-check" aria-hidden="true"></i>': '<i class="fa fa-times" aria-hidden="true"></i>' ?> Your shipping label is ready to print. </li>
        <li><?php echo !empty($install) && $install->status > 1 ? '<i class="fa fa-check" aria-hidden="true"></i>': '<i class="fa fa-times" aria-hidden="true"></i>' ?> Create staff account. </li>
        <li><?php echo !empty($install) && $install->status > 2 ? '<i class="fa fa-check" aria-hidden="true"></i>': '<i class="fa fa-times" aria-hidden="true"></i>' ?> Assigning Service. </li>
        <li><?php echo !empty($install) && $install->status > 3 ? '<i class="fa fa-check" aria-hidden="true"></i>': '<i class="fa fa-times" aria-hidden="true"></i>' ?>  Code update in progress. </li>
      </ul>
      <div class="Polaris-Banner__Content">

        <div class="Polaris-Banner__Actions">

          <h3>Requested on: <?= $install->send_on ?></h3>

          <h3>Theme: <?= $install->theme_name ?></h3>
        </div>

      </div>
      <?php if(!empty($install) && $install->status < 3){ ?>

      <div class="Polaris-Banner__Content">

        <div class="Polaris-Banner__Actions">
          <h3>Request on hold. Action required!</h3>

          </p>We have received your install request. To continue with the installation process, please create a staff account for support@vowelweb.com. If you've already created a staff account no further action is required.</p>
        </div>

      </div>
    <?php }?>
      <div class="Polaris-Banner__Content" id="Banner19Content">

        <div class="Polaris-Banner__Actions">

          <div class="Polaris-ButtonGroup">
            <?php if(!empty($install) && $install->status < 3){ ?>
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <a href="<?php echo 'https://'.$_GET['shop']. '/admin/settings/account'?>" class="Polaris-Button Polaris-Button--primary">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Create Staff</span></span>
                </a>
              </div>
            </div>
          <?php } ?>
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <button type="button" class="Polaris-Button Polaris-Button--outline" id="cancelRequest">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Cancel Request</span></span>
                </button>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>

  </div>

</div>
  <?php } ?>
<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

    <div class="Polaris-Page-Header__TitleActionMenuWrapper">

      <div>

        <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">

          <div class="Polaris-Header-Title" style="padding-bottom: 0.7em;">

            <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge margin-5" >Complete Your Installation</h1>
            <small class="color-gray">Your Shopify theme must now be updated with our app's unique code. Please select one of the installation methods below:</small>

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

              <h2 class="Polaris-Heading">Expert Install
              <br>(Free)</h2>

            </div>

            <div class="Polaris-Stack__Item">

              <i class="fas fa-headset" style="font-size: 20px;"></i>

            </div>

          </div>

        </div>

        <div class="Polaris-Card__Section"><span class="Polaris-TextStyle--variationSubdued">May take 2+ days to complete</span></div>

        <div class="Polaris-Card__Section">

          <div class="Polaris-ResourceList__ResourceListWrapper">

            <ul class="Polaris-ResourceList" aria-live="polite">

              <li class="Polaris-ResourceList__ItemWrapper">

                <div class="Polaris-ResourceItem" >

                  <p style="margin-bottom:0.5em">Hire our expert team to complete your installation. We will validate that everything is installed properly and ensure that your app is working as intended.</p>

                </div>

              </li>

              <li class="Polaris-ResourceList__ItemWrapper">

                <div class="Polaris-ResourceItem" data-href="produdcts/258"><a aria-describedby="258" aria-label="View details for Tucan scarf" class="Polaris-ResourceItem__Link" tabindex="0" id="PolarisResourceListItemOverlay8" href="produdcts/258" data-polaris-unstyled="true"></a>

                  <div class="Polaris-ResourceItem__Container" id="258">

                    <div class="Polaris-ResourceItem__Content" style="text-align: center;">
                      <?php
                      if(!empty($install) && $install->status != 0){?>
                        <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;"><span class="Polaris-Badge Polaris-Badge--statusSuccess"><span class="Polaris-VisuallyHidden">Success</span>Request is in progress</span></div>
                      <?php }else{?>
                      <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                        <a  class="Polaris-Button Polaris-Button--primary" href="<?php  echo base_url().'Home/installationRequest?shop='.$_GET['shop'] ?>">
                          <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Request Expert Install</span></span>
                        </a>
                      </div>
                    <?php } ?>
                    </div>

                  </div>

                </div>

              </li>

            </ul>

          </div>

        </div>

      </div>

    </div>

    <div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf">

      <div class="Polaris-Card">

        <div class="Polaris-Card__Header">

          <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">

            <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">

              <h2 class="Polaris-Heading">Automatic Install <br>(Free)</h2>

            </div>

            <div class="Polaris-Stack__Item">

              <i class="fas fa-robot" style="font-size: 20px;"></i>

            </div>

          </div>

        </div>

        <div class="Polaris-Card__Section"><span class="Polaris-TextStyle--variationSubdued">Instant</span></div>

        <div class="Polaris-Card__Section">

          <div class="Polaris-ResourceList__ResourceListWrapper">

            <ul class="Polaris-ResourceList" aria-live="polite">

              <li class="Polaris-ResourceList__ItemWrapper">

                <div class="Polaris-ResourceItem" >
                  <p style="margin-bottom:0.5em">This installation will add all relevant code to your Shopify theme automatically! Don't worry, we backup all updated files and offer exceptional support if things aren't quite right.</p>
                </div>

              </li>

              <li class="Polaris-ResourceList__ItemWrapper">

                <div class="Polaris-ResourceItem" data-href="produdcts/259"><a aria-describedby="259" aria-label="View details for Tucan scarf" class="Polaris-ResourceItem__Link" tabindex="0" id="PolarisResourceListItemOverlay10" href="produdcts/259" data-polaris-unstyled="true"></a>

                  <div class="Polaris-ResourceItem__Container" id="259">


                    <div class="Polaris-ResourceItem__Content" style="text-align: center;">

                      <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                        <button type="button" class="Polaris-Button Polaris-Button--primary installBtn">
                          <span class="Polaris-Button__Content">
                            <span class="Polaris-Button__Text">Start Automatic Install</span>
                          </span>
                        </button>
                      </div>

                    </div>

                  </div>

                </div>

              </li>

            </ul>

          </div>

        </div>

      </div>

    </div>

    <!-- <div class="Polaris-Layout__Section Polaris-Layout__Section--oneThird">

      <div class="Polaris-Card">

        <div class="Polaris-Card__Header">

          <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">

            <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">

              <h2 class="Polaris-Heading">Manual Install <br>(Free)</h2>

            </div>

            <div class="Polaris-Stack__Item">

              <i class="fas fa-swatchbook" style="font-size: 20px;"></i>

            </div>

          </div>

        </div>

        <div class="Polaris-Card__Section"><span class="Polaris-TextStyle--variationSubdued">Advanced Users Only</span></div>

        <div class="Polaris-Card__Section">

          <div class="Polaris-ResourceList__ResourceListWrapper">

            <ul class="Polaris-ResourceList" aria-live="polite">

              <li class="Polaris-ResourceList__ItemWrapper">

                <div class="Polaris-ResourceItem">
                  <p style="margin-bottom:0.5em">If you're comfortable with editing theme files and Liquid code, you can complete your own install! Click below for the full instructions.</p>
                </div>

              </li>

              <li class="Polaris-ResourceList__ItemWrapper">

                <div class="Polaris-ResourceItem" >

                  <div class="Polaris-ResourceItem__Container" id="260">

                    <div class="Polaris-ResourceItem__Content" style="text-align: center;">

                      <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                        <button type="button" class="Polaris-Button Polaris-Button--primary ">
                          <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">View Installation Instructions</span>
                        </span>
                      </button>
                    </div>

                    </div>

                  </div>

                </div>

              </li>

            </ul>

          </div>

        </div>

      </div>

    </div> -->

  </div>

</div>
