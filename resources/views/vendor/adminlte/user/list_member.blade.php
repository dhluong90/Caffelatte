@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Danh sách người dùng
@endsection

@section('contentheader_title')
    Quản lý danh sách người dùng
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    <li class="active">Danh sách người dùng</li>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
        <?php //var_dump(session()->all()); ?>
        <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4> @endif @endforeach
    </div>

    <div class="row">
        <div class="form-group pull-right">
            <div class="col-md-12">
                <a class="btn btn-success export-user-to-excel" href="{{"/admincp/user/member/export"}}" target="_blank">Xuất dữ liệu</a>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <!-- Default box -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách người dùng</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="{{ url('/admincp/user/member') }}" method="GET" class="form-list-filter-user">
                                        <div id="example1_filter" class="dataTables_filter pull-right">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" placeholder="Tên..." name="q">
                                                <span class="input-group-btn">
                                              <button type="submit" class="btn btn-info btn-flat">
                                                  <i class="fa fa-search"></i>
                                              </button>
                                            </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-striped table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Ảnh đại diện</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Tên</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Email</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Giới tính</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Số điện thoại</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Quốc gia</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($users as $member)
                                            <?php $i++; ?>
                                            <tr role="row" class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                                                <td class="sorting_1">
                                                    <img src="{{ json_decode($member->image)[0] }}" alt="" class="img-responsive" width="50px" height="50px">
                                                </td>
                                                <td class="sorting_1">{{ $member->name }}</td>
                                                <td class="sorting_1">{{ $member->email }}</td>
                                                <td class="sorting_1">{{ $member->gender != null ? ($member->gender == 1 ? 'Nam' : 'Nữ') : '' }}</td>
                                                <td class="sorting_1">{{ $member->phone }}</td>
                                                <td class="">{{ $member->country }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                                        {{ $users->render() }}
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
</div>
@endsection
