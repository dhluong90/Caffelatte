<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <a href="{{ url('/profile/' . Auth::user()->id) }}" target="_blank">
                        @if (Auth::user()->image == '')
                            <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image"/>
                        @else
                            <img src="{{ asset($ImageHelper::get_image_by_size(Auth::user()->image, '150x150')) }}" class="img-circle" alt="User Image"/>
                        @endif
                    </a>
                </div>
                <div class="pull-left info">
                    <a href="{{ url('/profile/' . Auth::user()->id) }}" target="_blank">
                        <p>{{ Auth::user()->name }}</p>
                    </a>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Quản lý người dùng</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admincp/user/member') }}">Danh sách người dùng</a></li>
                    <li><a href="{{ url('/admincp/user/admin') }}">Danh sách admin</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Quản lý thể loại</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admincp/category') }}">Danh sách thể loại</a></li>
                    <li><a href="{{ url('/admincp/category/create') }}">Tạo mới thể loại</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Quản lý tag</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admincp/tag') }}">Danh sách tag</a></li>
                    <li><a href="{{ url('/admincp/tag/create') }}">Tạo mới tag</a></li>
                </ul>
            </li>
            <!--
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Quản lý bài viết</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admincp/blog') }}">Danh sách bài viết</a></li>
                    <li><a href="{{ url('/admincp/blog/create') }}">Tạo bài viết</a></li>
                </ul>
            </li>
            -->
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Quản lý cửa hàng</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admincp/store') }}">Danh sách cửa hàng</a></li>
                    <li><a href="{{ url('/admincp/store/pending') }}">Danh sách cửa hàng chờ duyệt</a></li>
                    <li><a href="{{ url('profile/' . $user->id . '/create_store') }}">Tạo mới cửa hàng</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Quản lý món ăn</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admincp/food') }}">Danh sách món ăn</a></li>
                    <li><a href="{{ url('/admincp/food/pending') }}">Danh sách món ăn chờ duyệt</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
