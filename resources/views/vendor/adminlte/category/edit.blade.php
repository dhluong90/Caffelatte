@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Sửa thể loại
@endsection

@section('contentheader_title')
    Quản lý thể loại
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    <li><a href="{{ url('/admincp/category') }}">Quản lý thể loại</a></li>
    <li class="active">Sửa thể loại</li>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
            <?php //var_dump(session()->all()); ?>
            <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->

    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Sửa thể loại</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @foreach($categories as $item)
                        @if($item->id == Request::segment(4)) 
                    <form role="form" method="POST" action="{{ url('/admincp/category/update/'. $item->id) }}">
                        {{ csrf_field() }}
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tên thể loại</label>
                            <input type="text" class="form-control" placeholder="Tên thể loại ..." name="category-name" value="{{ $item->name}}">
                        </div>
                        <div class="form-group">
                            <label>Đường dẫn tĩnh</label>
                            <input type="text" class="form-control" placeholder="Đường dẫn tĩnh ..." name="category-slug" value="{{ $item->slug}}">
                        </div>
                        <div class="form-group">
                            <label>Thể loại cha</label>
                            <select class="form-control" name="category_parent">
                                <option value="0" >Trống</option>
                                @foreach($categories as $parent_item)
                                @if($parent_item->parent_id == 0 && $parent_item->id != $item->id )
                                <option value="{{$parent_item->id}}" {{ $parent_item->id == $item->parent_id ? 'selected' : '' }}>{{$parent_item->name}}</option>
                                @endif
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mô tả thể loại</label>
                            <input type="text" class="form-control" placeholder="Tên thể loại ..." name="category-description" value="{{ $item->description }}">
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                    @endif
                    @endforeach
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection

