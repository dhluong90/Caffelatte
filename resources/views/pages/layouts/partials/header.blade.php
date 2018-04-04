<head>
    <!-- 
        @param string header_title
        @param string header_description
        @param string header_keyword
        @param string header_image
    -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>@yield('header_title', 'Ăn cơm nhà')</title>
    <base href="{{ url('/') }}">

    <link rel="manifest" href="manifest.json">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Ăn cơm nhà">
    <meta name="apple-mobile-web-app-title" content="Ăn cơm nhà">
    <meta name="theme-color" content="#00e1be">
    <meta name="msapplication-navbutton-color" content="#00e1be">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/?pwa">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('/img/website/ancomnha.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="{{ asset('/img/website/ancomnha.png') }}">

    <meta name="robots" content="noodp,index,follow"/>
    <meta name="description" content="@yield('header_description', 'Ăn cơm nhà - Chia sẻ và đánh giá địa điểm buôn bán thức ăn sạch, với hàng ngàn địa điểm về ẩm thực đã được khảo sát, những nơi ăn ngoài như ăn cơm nhà')" />
    <meta name="keywords" content="@yield('header_keyword', 'Địa điểm ăn uống, đồ ăn sạch, mua đồ ăn online, ẩm thực, nhà hàng, cafe, bar/pub, quán ăn')" />
    <meta name='revisit-after' content='30 days' />

    <meta property="fb:app_id" content=""/>
    <meta property="fb:admins" content="" />

    <meta property="og:title" content="@yield('header_title', 'Ăn cơm nhà')" />
    <meta property="og:site_name" content="ancomnha.vn" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:description" content="@yield('header_description', 'Ăn cơm nhà - Chia sẻ và đánh giá địa điểm buôn bán thức ăn sạch, với hàng ngàn địa điểm về ẩm thực đã được khảo sát, những nơi ăn ngoài như ăn cơm nhà')" />
    <meta property="og:image" content="@yield('header_image', asset('/img/website/ancomnha-logo.png'))"/>
    <meta property="og:type" content="ancomnhavn:restaurant" />

    <link rel="canonical" href="{{ url('/') }}">
    <link rel="shortcut icon" href="{{ asset('/img/website/favicon.ico') }}"/>
    <link rel="image_src" href="@yield('header_image', asset('/img/website/ancomnha-logo.png'))">

    <!-- load css -->
    <link rel="stylesheet" href="{{ asset('/css/vendors/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/vendors/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/vendors/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/modules/alertify/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/modules/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/modules/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/modules/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/modules/owl-carousel/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/pages/master.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/pages/common.css') }}">
    @yield('define-css')

    <!-- load js -->
    <script src="{{ asset('/js/vendors/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vendors/jquery-1.11.2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/vendors/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/modules/slick/slick.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/modules/masonry/masonry.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/modules/imagesLoaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="{{ asset('/modules/owl-carousel/owl.carousel.min.js') }}"></script>
</head>