@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    Chức năng đang hoàn thiện
@endsection

@section('main-content')

    <div class="error-page">
        <h2 class="headline text-yellow">ERROR</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i>Chức năng đang hoàn thiện.</h3>
            <p>
                Chức năng chưa hoàn thành.<a href="{{ url('/') }}"> Trở về trang chủ</a>
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
@endsection