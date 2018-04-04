@extends('pages.layouts.app')

@section('header_title')
    Page Home
@endsection

@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('/css/pages/home.css') }}">

    <div class="page-home">
        <div class="container">
            <form>
                name: <input id="food-name" type="text" name="food-name">
                price: <input id="food-price" type="text" name="food-price">
                <input id="file" type="file" name="food-image" multiple>
            </form>
            <button id="create-food">submit</button>
        </div>
    </div>

    <script>
        $.when($.ready).then(function () {
            console.log('start script');
            $('#create-food').click(function() {
                var model = {
                    'name': $('#food-name').val(),
                    'price': $('#food-price').val()
                }

                console.log(model);

                var data = new FormData();
                data.append('model', JSON.stringify(model));
                // return;

                var files =  $('#file')[0].files;

                $.each(files, function(i, file) {
                    data.append('file-' + i, file);
                });

                $.ajax({
                    url: "http://localhost:8000/ajax/tool/create_food",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        console.log(result);
                    }
                });
            });

        });

    </script>

    <script type="text/javascript" src="{{ asset('/js/pages/home.js') }}"></script>
@endsection