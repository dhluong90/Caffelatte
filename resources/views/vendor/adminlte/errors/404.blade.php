@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.pagenotfound') }}
@endsection

@section('main-content')

    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i>{{ trans('adminlte_lang::message.pagenotfound') }}.</h3>
            <p>
                {{ trans('adminlte_lang::message.notfindpage') }}<a href="{{ url('/') }}"> Trở về trang chủ</a>
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
@endsection