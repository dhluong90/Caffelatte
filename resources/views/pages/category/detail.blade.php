@extends('pages.layouts.app')

@section('header_title')
Page Home
@endsection

@section('define-css')
    <link rel="stylesheet" href="{{ asset('/css/pages/home.css') }}">
    <link rel="stylesheet" href="{{ asset('/ui-handler/main-list/main-list.css') }}">
    <link rel="stylesheet" href="{{ asset('/ui-handler/modal-login/modal-login.css') }}">
@endsection

@section('main-content')
<div class="home-page">
   
    <!-- Quick Links -->
    <section class="section-quick-links">
        <div class="container">
            <div class="row quick-links">
                <div class="col-md-3 item {{ $category_slug == 'dac-san-hom-nay' ? 'active' : '' }}">
                    <a href="{{ url('/category/view/dac-san-hom-nay') }}">Đặc sản Hôm nay&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 item {{ $category_slug == 'trong-thuy-canh' ? 'active' : '' }}">
                    <a href="{{ url('/category/view/trong-thuy-canh') }}">Trồng thủy canh&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 item {{ $category_slug == 'trong-thuy-canh' ? 'active' : '' }}">
                    <a href="{{ url('/category/view/mon-de-lam') }}">Món dễ làm&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 item {{ $category_slug == 'vung-mien' ? 'active' : '' }}">
                    <a href="{{ url('/category/view/vung-mien') }}">Vùng miền&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Quick Links -->
    <!-- Main Content -->
    <section class="section-nav-main-content">
        <div class="container">
            <div class="row nav-main-content">
                <div class="col-md-9">
                    <div class="list-inline">
                        <div class="tag">
                            <span class="caption">tag</span>
                        </div>
                        @if($view_all_tag == true)
                            @for ($i = 0; $i < $tags_show->count(); $i++)
                            @if ($i == 3) @break; @endif
                            <div data-slug='{{ $tags_show[$i]->slug }}' class="slug-default tag">
                                <input class="tag" name="tags[]" readonly="" value="1">
                                <span class="title-tag" >{{ $tags_show[$i]->name }}</span>
                            </div>
                            @endfor
                            <div class="drop_down tag">
                                <a href="javascript:void(0)" class="btn-more-tag three-dots">...</a>
                            </div>
                        @else
                            @foreach ($tags_show as $item)
                            <div class="tag">
                                <input class="tag" name="tags[]" readonly="" value="1">
                                <span class="title-tag" data-slug='{{ $item->slug }}'>{{ $item->name }}</span>
                                <i class="fa fa-times btn-remove-tag" data-slug='{{ $item->slug }}' aria-hidden="true"></i>
                            </div>
                            @endforeach
                            <div class="drop_down tag">
                                <a href="javascript:void(0)" class="btn-more-tag "><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        @endif
                        <div class="dropdown-wp">
                            <div class="dropdown-content">
                                <h3>Tags</h3>
                                <hr>
                                <ul class="list-unstyled list-category list-inline">
                                    @foreach( $foods_tag as $item)
                                    <li class="tag"><a data-slug='{{ $item->slug }}' href="{{ route('website_food_list') }}/?tag={{ $item->slug }}"  title="">{{ $item->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="list-inline">
                    </ul>
                </div>
                <div class="col-md-3 most-view" style="display: none;">
                    <a href="">Xem nhiều nhất&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                </div>
            </div>
            <hr />
        </div>
    </section>
    <section class="section-main-content">
        <div class="container">
            <div id="grid" class="main-content grid">
                @include('pages.partials.shared.main_list', [
                    'foods_like_id' => empty($foods_like_id) ? [] : $foods_like_id,
                    'items_main_content' => $foods,
                ])
            </div>
        </div>
    </section>
    <!-- End Main Content -->
    @include('pages.partials.shared.modal_login')
</div>


@endsection

@section('define-js')
<script type="text/javascript" src="{{ asset('/js/pages/home.js') }}"></script>
<script type="text/javascript" src="{{ asset('/ui-handler/main-list/main-list.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.list-inline div i.btn-remove-tag').click(function(e){
            var slug_dropdown = $(this).data("slug");
            var url_current = window.location.href;
            var new_url = url_current.replace(slug_dropdown, '').replace(',,', ',').replace('=,', '=');
            if(new_url.charAt(new_url.length - 1) == ',') {
                new_url = new_url.slice(0, -1);
            }
            window.location.href = new_url;
        });

        $('.dropdown-wp li.tag a').on('click', function(e){
            e.preventDefault();
            var slug_dropdown = $(this).data("slug");
            var url_current = window.location.href;
            console.log(url_current.indexOf('?tag='));
            if(url_current.indexOf('?tag=') == -1) {
                window.location.href = "{{ route('website_food_list') }}" + '?tag=' +$(this).data("slug");
            } else {
                window.location.href = url_current + ',' + slug_dropdown;
            }
        });

        $('.slug-default').on('click', function(e){
            window.location.href = "{{ route('website_food_list') }}" + '?tag=' +$(this).data("slug");
        });
    });
</script>
@endsection
