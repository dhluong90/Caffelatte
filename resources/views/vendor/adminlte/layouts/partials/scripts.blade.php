<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Bootstrap -->
<script src="{{ asset('/js/vendors/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<!-- CKEditor -->
<script src="{{ asset('/modules/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<!-- Laravel App -->
<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/modules/alertify/alertify.js') }}" type="text/javascript"></script>
<script src="{{ asset('/modules/LoadImg-master/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/modules/LoadImg-master/js/loadimg.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/admin/home.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/admin/user.js') }}" type="text/javascript"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>