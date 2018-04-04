<!--
    @var $store_id
-->

<!-- Banner -->
<section class="section-banner">
    <div class="container">
        <div class="row banner">
            <div class="col-md-5 title">Trang quản lý</div>
            <div class="col-md-7 content">
                Trang hệ thống chuyên tạo mới một cửa hàng,
                <br /> báo cáo và thống kê các hoạt động kinh doanh, lượng bán sản phẩm.
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
                <li class="{{ ($page_active == 'cua_hang') ? 'active' : '' }}">
                    <a href="{{ url('/manage/store/' . $store_id . '/edit_store') }}"><span class="heading">Về cửa hàng</span></a>
                </li>
                <li class=""  style="display: none;">
                    <a href=""><span class="heading">Hình ảnh</span></a>
                </li>
                <li>
                    <a href=""  style="display: none;"><span class="heading">Thống kê</span></a>
                </li>
                <li class="{{ ($page_active == 'san_pham') ? 'active' : '' }}">
                    <a href="{{ url('/manage/store/' . $store_id . '/food') }}"><span class="heading"><span class="product-total">{{ (!empty($count_foods) ? $count_foods : '') }}</span>&nbsp;Sản phẩm</span></a>
                </li>
                <li class="btn-more-tag">
                    <a href="{{ url('/manage/store/' . $store_id . '/create_food') }}">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span class="tooltiptext tooltip-top">Tạo mới</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- End Tab Bar -->