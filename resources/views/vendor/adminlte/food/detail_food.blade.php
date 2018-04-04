@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ $data['food']->name }}
@endsection

@section('contentheader_title')
    Quản lý món ăn
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    @if ($data['food']->status == $data['constants']::FOOD_APPROVE)
    <li><a href="{{ url('/admincp/food') }}">Danh sách món ăn</a></li>
    @endif
    @if ($data['food']->status == $data['constants']::FOOD_PENDING)
    <li><a href="{{ url('/admincp/food/pending') }}">Danh sách món ăn chờ duyệt</a></li>
    @endif
    <li class="active">{{ $data['food']->name }}</li>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
        <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4> @endif @endforeach
    </div>
    <!-- end .flash-message -->

    <!-- Detail Food -->
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            @if(isset($data['food']))
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Chi tiết món ăn: <span>{{$data['food']->name}}</span></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-8">
                        <span class="detail-food">Slug: </span>{{ $data['food']->slug }}
                        <br /><span class="detail-food">Chi tiết: </span>{{ $data['food']->detail }}
                    </div>
                    <div class="col-md-4">
                        <img src="{{$data['food']->images }}">
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            @endif
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection
