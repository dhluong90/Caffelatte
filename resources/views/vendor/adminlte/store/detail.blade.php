@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Chi tiết cửa hàng
@endsection

@section('contentheader_title')
    Quản lý cửa hàng
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    @if ($store->status == $Constants::STORE_APPROVE)
    <li><a href="{{ url('/admincp/store') }}">Danh sách cửa hàng</a></li>
    @endif
    @if ($store->status == $Constants::STORE_PENDING)
    <li><a href="{{ url('/admincp/store/pending') }}">Danh sách cửa hàng chờ duyệt</a></li>
    @endif
    <li class="active">Chi tiết cửa hàng</li>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
        <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4> @endif @endforeach
    </div>
    <!-- end .flash-message -->

    <!-- Detail Store -->
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            @if(isset($store))
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Chi tiết cửa hàng : <span>{{$store->name}}</span></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-8">
                        <span class="detail-store">Số điện thoại : </span>{{ $store->phone }}
                        <br /><span class="detail-store">Lĩnh vực : </span>{{ $store->sector }}
                        <br /><span class="detail-store">Thời gian mở cửa : </span>{{ date("G:i", strtotime($store->open_time)) }} AM - {{ date("G:i", strtotime($store->close_time))}} PM
                        <br /><span class="detail-store">Email : </span>{{ $store->email }}
                        <br /><span class="detail-store">Facebook : </span>{{ $store->facebook }}
                        <br /><span class="detail-store">Site_url : </span>{{ $store->site_url }}
                        <br /><span class="detail-store">Địa chỉ : </span>{{ $store->address }}
                    </div>
                    <div class="col-sm-4">
                        <img src="{{ asset($ImageHelper::get_image_by_size($store->logo, '150x150'))}}">
                    </div>
                    <div class="col-sm-12">
                        <span class="detail-store">Giới thiệu : </span>{!! $store->introduction !!}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            @endif
            <!-- /.box -->
        </div>
    </div>

    <!-- List foods of store -->
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> {{(isset($store)) ? "Các món ăn của cửa hàng : ".$store->name : "Danh sách món ăn" }}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-4">
                                <div id="example1_filter" class="dataTables_filter pull-right">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-striped table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">STT</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Hình ảnh</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Tên món ăn</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Giá</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Tác vụ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0; ?>
                                    @foreach($foods as $item)
                                        <?php $i++; ?>
                                        <tr role="row" class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                                            <td class="sorting_1">{{$i}}</td>
                                            <td class="sorting_1">
                                                <img src="{{ $item->images }}" alt="" class="img-responsive blog-avatar">
                                            </td>
                                            <td class="sorting_1">{{ $item->name }}</td>
                                            <td class="sorting_1">{{ number_format($item->price) }} VNĐ</td>
                                            <td class="sorting_1">
                                                <a href="{{ url('/admincp/food/edit/'.$item->id) }}" class="btn-edit " title="Sửa">
                                                </a>
                                                <a href="{{ url('/admincp/food/delete/'.$item->id) }}" class="btn-delete" title="Xóa">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                                    {{ $foods->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection
