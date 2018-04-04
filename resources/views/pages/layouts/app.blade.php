<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html>
<!--<![endif]-->

@section('header')
    @include('pages.layouts.partials.header')
@show

<body>
    <div id="container">
        @include('pages.layouts.partials.contentheader')

        <!-- main -->
        <div id="main">
            @yield('main-content')
        </div>
        <!-- end main -->

        @include('pages.layouts.partials.contentfooter')
    </div>
    <!-- end container -->

    @include('pages.layouts.partials.footer')
</body>
</html>
