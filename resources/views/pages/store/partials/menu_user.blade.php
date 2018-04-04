<!-- Banner -->
<section class="section-banner">
    <div class="container">
        <div class="row banner">
            <div class="col-md-5 title">Trang profile</div>
            <div class="col-md-7 content">
                Trang hệ thống chuyên quản trị viên cao nhất,
                <br /> có thể tạo các quản trị viên quản lý cửa hàng, sản phẩm, và người viết cảm nhận.
            </div>
        </div>
    </div>
</section>
<!-- End Banner -->
<!-- Tab Bar -->
<section class="section-tab-bar">
    <div class="container">
        <div class="row tab-bar">
            <ul class="list-inline list-tabs">
                <li>
                    <a href="{{ url('profile/show_profile/'.$user->id)}}"><span class="heading">Profile</span></a>
                </li>
                <li class="active">
                    <a href="{{ url('profile/manage/store/'.$user->id) }}"><span class="heading"><span class="product-total">0 </span>Cửa hàng</span></a>
                </li>
                <li>
                    <a href=""><span class="heading">Users</span></a>
                </li>
                <li>
                    <a href=""><span class="heading"><span class="product-total">0 </span>Cách nấu</span></a>
                </li>
            </ul>
            <div class="opacity-1"></div>
        </div>
    </div>
</section>
<!-- End Tab Bar -->