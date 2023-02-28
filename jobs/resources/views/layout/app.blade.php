<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('shopify-app.app_name') }}</title>
        <link href="{!! asset('public/css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        .bcr-product-selector .pagination .nav-link, .bcr-product-selector .pagination .nav-stub{
          padding:0px !important;
        }
        </style>
        @yield('styles')
    </head>
    <body>
      <div class="loading" style="display:none;">Loading&#8230;</div>

        <div id="root">
            <div class="bv-app">
                <div class="bv-sidebar bv-sidebar--collapsable">
                    <div class="bv-sidebar__view">
                        <div class="bv-sidebar__content">
                            <nav class="bv-nav bv-sidebar__nav">
                                <ul class="bv-nav__items">
                                    <li class="bv-nav__item bv-sidebar__nav-item" >
                                        <a class="bv-nav__link welcomPagge" >
                                            <span class="bv-icon bv-nav__icon-before">
                                                <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                    <title class="bv-icon__title">Product Pricing Groups</title>
                                                    <path class="bv-icon__path" fill="currentColor" d="M10.8737707,2.83037423 L8.05874669,2.83037423 L8.05874669,10.7128808 L15.9412533,10.7128808 L15.9412533,2.83037423 L13.1260462,2.83037423 L13.1260462,6.72422084 C13.1260462,6.97772767 12.9210443,7.1818144 12.6684527,7.1818144 L11.3313643,7.1818144 C11.0787727,7.1818144 10.8737707,6.97772767 10.8737707,6.72422084 L10.8737707,2.83037423 L10.8737707,2.83037423 Z M6.37846444,11.4406376 C6.28189345,11.2176797 6.22837246,10.9716191 6.22837246,10.7128808 L6.22837246,2.83037423 C6.22837246,1.82000765 7.04746493,1 8.05874669,1 L15.9412533,1 C16.9516199,1 17.7716275,1.82000765 17.7716275,2.83037423 L17.7716275,10.7128808 C17.7716275,10.9716191 17.7180467,11.2176797 17.621402,11.4406376 L21.1696258,11.4406376 C22.1799923,11.4406376 23,12.2606453 23,13.2710119 L23,21.1535185 C23,22.1648002 22.1799923,22.9838927 21.1696258,22.9838927 L13.2871192,22.9838927 C12.7850949,22.9838927 12.3304331,22.7820384 11.9998272,22.4550233 C11.6691093,22.7820384 11.2144508,22.9838927 10.7128808,22.9838927 L2.83037423,22.9838927 C1.81909247,22.9838927 1,22.1648002 1,21.1535185 L1,13.2710119 C1,12.2606453 1.81909247,11.4406376 2.83037423,11.4406376 L6.37846444,11.4406376 L6.37846444,11.4406376 Z M16.1020517,13.2710119 L13.2871192,13.2710119 L13.2871192,21.1535185 L21.1696258,21.1535185 L21.1696258,13.2710119 L18.3543272,13.2710119 L18.3543272,16.9095213 C18.3543272,17.1621129 18.1484101,17.3671148 17.8967336,17.3671148 L16.5596452,17.3671148 C16.3070536,17.3671148 16.1020517,17.1621129 16.1020517,16.9095213 L16.1020517,13.2710119 L16.1020517,13.2710119 Z M5.64539827,13.2710119 L2.83037423,13.2710119 L2.83037423,21.1535185 L10.7128808,21.1535185 L10.7128808,13.2710119 L7.89767376,13.2710119 L7.89767376,16.9090637 C7.89767376,17.1625705 7.69267185,17.3666572 7.4400802,17.3666572 L6.10299183,17.3666572 C5.85131537,17.3666572 5.64539827,17.1625705 5.64539827,16.9090637 L5.64539827,13.2710119 L5.64539827,13.2710119 Z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span class="bv-nav__details">
                                            <span class="bv-nav__label">Product Pricing Groups</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="bv-nav__item bv-sidebar__nav-item" style="display:none;" >
                                        <a class="bv-nav__link" href="#">
                                            <span class="bv-icon bv-nav__icon-before">
                                                <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                    <title class="bv-icon__title">Quantity Break Display</title>
                                                    <path class="bv-icon__path" fill="currentColor" d="M18.625,23 C18.28,23 18,22.72 18,22.375 L18,18.625 C18,18.28 18.28,18 18.625,18 L22.375,18 C22.72,18 23,18.28 23,18.625 L23,22.375 C23,22.72 22.72,23 22.375,23 L18.625,23 Z M10.125,23 C9.78,23 9.5,22.72 9.5,22.375 L9.5,18.625 C9.5,18.28 9.78,18 10.125,18 L13.875,18 C14.22,18 14.5,18.28 14.5,18.625 L14.5,22.375 C14.5,22.72 14.22,23 13.875,23 L10.125,23 Z M1.625,23 C1.28,23 1,22.72 1,22.375 L1,18.625 C1,18.28 1.28,18 1.625,18 L5.375,18 C5.72,18 6,18.28 6,18.625 L6,22.375 C6,22.72 5.72,23 5.375,23 L1.625,23 Z M18.625,14.5 C18.28,14.5 18,14.22 18,13.875 L18,10.125 C18,9.78 18.28,9.5 18.625,9.5 L22.375,9.5 C22.72,9.5 23,9.78 23,10.125 L23,13.875 C23,14.22 22.72,14.5 22.375,14.5 L18.625,14.5 Z M10.125,14.5 C9.78,14.5 9.5,14.22 9.5,13.875 L9.5,10.125 C9.5,9.78 9.78,9.5 10.125,9.5 L13.875,9.5 C14.22,9.5 14.5,9.78 14.5,10.125 L14.5,13.875 C14.5,14.22 14.22,14.5 13.875,14.5 L10.125,14.5 Z M1.625,14.5 C1.28,14.5 1,14.22 1,13.875 L1,10.125 C1,9.78 1.28,9.5 1.625,9.5 L5.375,9.5 C5.72,9.5 6,9.78 6,10.125 L6,13.875 C6,14.22 5.72,14.5 5.375,14.5 L1.625,14.5 Z M18.625,6 C18.28,6 18,5.72 18,5.375 L18,1.625 C18,1.28 18.28,1 18.625,1 L22.375,1 C22.72,1 23,1.28 23,1.625 L23,5.375 C23,5.72 22.72,6 22.375,6 L18.625,6 Z M10.125,6 C9.78,6 9.5,5.72 9.5,5.375 L9.5,1.625 C9.5,1.28 9.78,1 10.125,1 L13.875,1 C14.22,1 14.5,1.28 14.5,1.625 L14.5,5.375 C14.5,5.72 14.22,6 13.875,6 L10.125,6 Z M1.625,6.00312703 C1.28,6.00312703 1,5.72295191 1,5.37773615 L1,1.62539088 C1,1.28017511 1.28,1 1.625,1 L5.375,1 C5.72,1 6,1.28017511 6,1.62539088 L6,5.37773615 C6,5.72295191 5.72,6.00312703 5.375,6.00312703 L1.625,6.00312703 Z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span class="bv-nav__details">
                                            <span class="bv-nav__label">Quantity Break Display</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="bv-nav__item bv-sidebar__nav-item"  style="display:none;">
                                        <span class="bv-nav__link">
                                            <span class="bv-icon bv-nav__icon-before">
                                                <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                    <title class="bv-icon__title">Settings</title>
                                                    <path class="bv-icon__path" fill="currentColor" d="M4.7649196,16.5683733 C4.25110603,15.7563342 3.87023009,14.8518277 3.65288005,13.8854422 L1,13.2222222 L1,10.7777778 L3.65288005,10.1145578 C3.87023009,9.14817229 4.25110603,8.24366584 4.7649196,7.43162672 L3.35758379,5.08606703 L5.08606703,3.35758379 L7.43162672,4.7649196 C8.24366584,4.25110603 9.14817229,3.87023009 10.1145578,3.65288005 L10.7777778,1 L13.2222222,1 L13.8854422,3.65288005 C14.8518277,3.87023009 15.7563342,4.25110603 16.5683733,4.7649196 L18.913933,3.35758379 L20.6424162,5.08606703 L19.2350804,7.43162672 C19.748894,8.24366584 20.1297699,9.14817229 20.3471199,10.1145578 L23,10.7777778 L23,13.2222222 L20.3471199,13.8854422 C20.1297699,14.8518277 19.748894,15.7563342 19.2350804,16.5683733 L20.6424162,18.913933 L18.913933,20.6424162 L16.5683733,19.2350804 C15.7563342,19.748894 14.8518277,20.1297699 13.8854422,20.3471199 L13.2222222,23 L10.7777778,23 L10.1145578,20.3471199 C9.14817229,20.1297699 8.24366584,19.748894 7.43162672,19.2350804 L5.08606703,20.6424162 L3.35758379,18.913933 L4.7649196,16.5683733 L4.7649196,16.5683733 Z M12,16.8888889 C14.7000588,16.8888889 16.8888889,14.7000588 16.8888889,12 C16.8888889,9.29994122 14.7000588,7.11111111 12,7.11111111 C9.29994122,7.11111111 7.11111111,9.29994122 7.11111111,12 C7.11111111,14.7000588 9.29994122,16.8888889 12,16.8888889 Z"></path>
                                                </svg>
                                            </span>
                                            <span class="bv-nav__details"><span class="bv-nav__label">Settings</span></span>
                                            <span class="bv-icon bv-nav__icon-after">
                                                <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                                    <title class="bv-icon__title">Settings</title>
                                                    <path class="bv-icon__path" fill="currentColor" d="M3.75261265,6.34153452 C3.38894463,5.92588561 2.75718344,5.88374677 2.34153452,6.24741478 C1.92588561,6.6110828 1.88374677,7.24284399 2.24741478,7.65849291 L11.2524148,18.2364929 C11.6508167,18.6918404 12.3591606,18.6918563 12.757583,18.2365268 L21.763583,7.6585268 C22.1272697,7.24289426 22.0851593,6.61113117 21.6695268,6.24744443 C21.2538943,5.8837577 20.6221312,5.9258681 20.2584444,6.34150064 L12.0050479,16.0594019 L3.75261265,6.34153452 Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </span>
                                        <nav class="bv-nav bv-sidebar__subnav">
                                            <ul class="bv-nav__items">
                                                <li class="bv-nav__item bv-sidebar__nav-item bv-sidebar__nav-item-child" ><a class="bv-nav__link" href="#"><span class="bv-nav__details"><span class="bv-nav__label">General</span></span></a>
                                                </li>
                                                <li class="bv-nav__item bv-sidebar__nav-item bv-sidebar__nav-item-child" ><a class="bv-nav__link" href="#"><span class="bv-nav__details"><span class="bv-nav__label">Account Plans</span></span></a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="bv-sidebar__edge">
                            <button class="bv-sidebar__toggle-button">
                                <span class="bv-icon">
                                    <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                        <path class="bv-icon__path" fill="currentColor" d="M17.2364792,3.75261265 C17.6521281,3.38894463 17.6942669,2.75718344 17.3305989,2.34153452 C16.9669309,1.92588561 16.3351697,1.88374677 15.9195208,2.24741478 L5.34152081,11.2524148 C4.88617335,11.6508167 4.8861574,12.3591606 5.34148692,12.757583 L15.9194869,21.763583 C16.3351195,22.1272697 16.9668826,22.0851593 17.3305693,21.6695268 C17.694256,21.2538943 17.6521456,20.6221312 17.2365131,20.2584444 L7.5186118,12.0050479 L17.2364792,3.75261265 Z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <button class="bv-iconbutton bv-sidebar__hamburger-toggle">
                            <span class="bv-icon bv-iconbutton__icon">
                                <svg class="bv-icon__icon" viewBox="0 0 24 24">
                                    <path class="bv-icon__path" fill="currentColor" d="M2,7 C1.448,7 1,6.552 1,6 C1,5.448 1.448,5 2,5 L22,5 C22.552,5 23,5.448 23,6 C23,6.552 22.552,7 22,7 L2,7 Z M2,13 C1.448,13 1,12.552 1,12 C1,11.448 1.448,11 2,11 L22,11 C22.552,11 23,11.448 23,12 C23,12.552 22.552,13 22,13 L2,13 Z M2,19 C1.448,19 1,18.552 1,18 C1,17.448 1.448,17 2,17 L22,17 C22.552,17 23,17.448 23,18 C23,18.552 22.552,19 22,19 L2,19 Z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <main class="bv-page">
                    @yield('content')
                </main>
            </div>
        </div>

        <div id="dialog-root"></div>
        <div id="popover-root"></div>
        <div id="portal-root"></div>
        @if(config('shopify-app.appbridge_enabled'))
        <script src="https://unpkg.com/@shopify/app-bridge"></script>
        <script>
            var shop      ='{{$shop}}';
            var prev_jobs ='{{$prevJobs}}';
            var AppBridge = window['app-bridge'];
            var createApp = AppBridge.default;
            var app = createApp({
                apiKey: '{{ config('shopify-app.api_key') }}',
                shopOrigin: '{{ ShopifyApp::shop()->shopify_domain }}',
                forceRedirect: true,
            });
            const actions = window['app-bridge'].actions;
            var Button    = actions.Button;
            var Modal     = actions.Modal;
            var TitleBar  = actions.TitleBar;
            var Redirect  = actions.Redirect;
            var Loading   = actions.Redirect;
            var laravelAppURL = '{{$AppURL}}';
            var csrfToken = '{{ csrf_token() }}';

        </script>
        @include('shopify-app::partials.flash_messages')
        <script src="{!! asset('public/js/jquery-3.4.1.min.js') !!}" ></script>
        <script src="{!! asset('public/js/pagination.js') !!}" ></script>
        <script src="{!! asset('public/js/custom.js') !!}" ></script>
        @endif
        @yield('scripts')
    </body>
</html>
