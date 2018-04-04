@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Danh sách sản phẩm
@endsection

@section('contentheader_title')
    Quản lý sản phẩm
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    <li><a href="{{ url('/admincp/product') }}">Quản lý sản phẩm</a></li>
    <li class="active">Danh sách sản phẩm</li>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
        <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4> @endif @endforeach
    </div>
    <!-- end .flash-message -->
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Danh sách sản phẩm</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        {{--
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button> --}}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="example1_filter" class="dataTables_filter pull-right">
                                <form action="{{url('admincp/product')}}" method="POST">
                                {{ csrf_field() }}

                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search-product"
                                        class="form-control" placeholder="Tìm kiếm">
                                        <span class="input-group-btn">
                                          <button type="submit" class="btn btn-info btn-flat">
                                              <i class="fa fa-search"></i>
                                          </button>
                                        </span>
                                    </div>
                                </form>
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
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Tên sản phẩm</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Giá SP</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Số lượng</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Tác vụ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($products as $items)
                                        <?php $i++; ?>
                                        <tr role="row" class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                                            <td class="sorting_1">{{ $items->id }}</td>
                                            <td class="sorting_1 ">
                                                <img class="custom-image" src="{{ $items->images }}"></td>
                                            <td class="sorting_1">{{ $items->name }}</td>
                                            <td class="sorting_1 ">{{ number_format($items->price) }}<span> VNĐ</span></td>
                                            <td class="sorting_1">{{ $items->quantity }}</td>             
                                            <td class="">
                                                <a href="{{ url('/admincp/product/edit/'.$items->id) }}" class="btn-edit " title="Sửa">
                                                </a>
                                                <a href="{{ url('/admincp/product/delete/'.$items->id) }}" class="btn-delete" title="Xóa">
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
                                    {{ $products->links() }}
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
