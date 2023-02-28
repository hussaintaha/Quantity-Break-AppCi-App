<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <link href="<?= base_url().'assets/css/style.css'; ?>" media="all" rel="stylesheet" type="text/css" />
    <!-- <link href="<?= base_url().'assets/css/seaff.css'; ?>" media="all" rel="stylesheet" type="text/css" />    -->
    <link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@5.1.0/dist/styles.css"    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/cecf693e6a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <style>
    .bcr-product-selector .pagination .nav-link, .bcr-product-selector .pagination .nav-stub{
      padding:0px !important;
    }
    .hidden {
      display: none;
    }

    form > .row {
      margin-bottom: 20px;
    }

    form > .row:last-child {
      margin-bottom: 0;
    }

    form input.invalid {
      border-color: #dc3545;
    }

    form .invalid-feedback {
      color: #dc3545;
      font-size: 14px;
      line-height: 21px;
      margin-top: 4px;
      text-align: left;
    }

      ul.nav {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        border: 1px solid #e7e7e7;
        background-color: #f3f3f3;
      }

      li.nav-item {
        float: left;
      }

      li a {
        display: block;
        color: #666;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
      }

      li a:hover:not(.active) {
        background-color: #ddd;
        text-decoration: none;
        color: #666;
      }

      li a.active {
        color: white;
        background-color: #1C2260;
      }

      /* Absolute Center Spinner */
      .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
      }

      /* Transparent Overlay */
      .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
          background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

        background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
      }

      /* :not(:required) hides these rules from IE9 and below */
      .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
      }

      .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
      box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
      }

      /* Animation */

      @-webkit-keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @-moz-keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @-o-keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      .segment {
        position: relative;
        display: block;
        border-bottom: 1px solid rgba(0,0,0,.1);
        margin: 0;
        padding: 30px;
            padding-right: 30px;
            padding-left: 30px;
        }
        .with-annotation .content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }
        .with-annotation .annotation:first-child {
            padding-right: 30px;
            margin-right: 0;
            margin-bottom: 20px;
        }
        .with-annotation .annotation {
            -ms-flex: 0 1 30%;
            flex: 0 1 30%;
        }
        .nav-item a
        {
          text-decoration: none;
        }
        .margin-5
        {
          margin-bottom: 5px;
        }
        .color-gray
        {
          color: gray;
        }
        .NewSelector {
          line-height: 2.4rem;
          text-transform: none;
          letter-spacing: normal;
          position: relative;
          z-index: 20;
          display: block;
          flex: 1 1;
          width: 100%;
          min-width: 0;
          min-height: 3.6rem;
          margin: 0;
          padding: .5rem 1.2rem;
          background: none;
          border: .1rem solid #c4cdd5;
          font-size: inherit;
          font-weight: inherit;
          -moz-appearance: none;
          border-radius: 3px;
      }
      .contact
      {
        position: fixed;
          bottom: 20px;
          left: 20px;
          display: inline-block;
          background: #1C2260;
          padding: 1em;
          color: white;
          font-size: 1em;
      }
    </style>
     <script type="text/javascript">
         ShopifyApp.init({
            apiKey: '<?php echo $this->config->item('shopify_api_key'); ?>',
            shopOrigin: '<?php echo 'https://'.$_GET['shop'];?>'
        });

    </script>
</head>

    <body>
      <div class="loading" style="display:none;">Loading&#8230;</div>

        <div id="root">
          <ul class="nav bv-page">
            <li class="nav-item"><a <?php if (stripos($_SERVER['REQUEST_URI'],'Home/welcome') !== false) {echo 'class="active"';} ?>  href="<?php echo base_url().'Home/welcome?shop='.$_GET['shop'] ?>">Product Pricing Groups</a></li>
            <li class="nav-item"><a <?php if (stripos($_SERVER['REQUEST_URI'],'Home/generalSetting') !== false) {echo 'class="active"';} ?> href="<?php echo base_url().'Home/generalSetting?shop='.$_GET['shop'] ?>">Settings</a></li>
            <li class="nav-item"><a <?php if (stripos($_SERVER['REQUEST_URI'],'Home/accountPlan') !== false) {echo 'class="active"';} ?> href="<?php echo base_url().'Home/accountPlan?shop='.$_GET['shop'] ?>">Plans</a></li>
            <li class="nav-item"><a <?php if (stripos($_SERVER['REQUEST_URI'],'Home/InstallationPage') !== false) {echo 'class="active"';} ?> href="<?php echo base_url().'Home/InstallationPage?shop='.$_GET['shop'] ?>">Installation</a></li>
          </ul>
            <div class="bv-app">
                <main class="bv-page">
