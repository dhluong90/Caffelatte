<div class="container ">
	<div class="row ">
		@foreach ($foods as $item_food)
		<div class="col-md-3 col-sm-6 ">
			<div class="thumbnail ">
				<a href="javascript:void(0)" title=""><img src="{{url('img/website/lau-img.jpg') }}" alt=" " class="img-responsive product-img "></a>
				<a href="javascript:void(0)" title=""><img src="{{ url('img/website/icon-fav.png') }}" class="icon-fa img-responsive "></a>
				<div class="caption ">
					<a href="{{ url('/food/view/' . $item_food->slug . '/' . $item_food->id) }}" title=""><h4 class="caption-title ">{{ $item_food->name }}</h4></a>
					<div class="left ">
						<i class="fa fa-star fa-lg star " aria-hidden="true "></i>
						<i class="fa fa-star fa-lg star " aria-hidden="true "></i>
						<i class="fa fa-star fa-lg star " aria-hidden="true "></i>
						<i class="fa fa-star fa-lg star " aria-hidden="true "></i>
						<i class="fa fa-star fa-lg star " aria-hidden="true "></i>
						<span>&nbsp;57</span>
					</div>
					<div class="icon-favorite ">
						<i class="fa fa-heart heart-icon " aria-hidden="true "></i>
						<span class="point-favorite ">25</span>
					</div>
					<p class="caption-content ">{{ $item_food->detail }}</p>
					<hr>
					<div class="clearfix">
						<div class="icon-footer-caption">
							<ul>
								<li>
									<a href="" title=""><img src="{{ url('img/website/icon-care.png') }}" alt=" " class="img-responsive "></a>
								</li>
								<li>
									<a href="" title=""><img src="{{ url('img/website/icon-cart2.png') }}" alt=" " class="img-responsive "></a>
								</li>
								<li>
									<a href="" title=""><img src="{{ url('img/website/icon-cart2.png') }}" alt=" " class="img-responsive icon-view"></a>
								</li>
							</ul>
						</div>
						<div class="right ">
							<span class="price-title ">{{ $item_food->price/1000 }}</span>
							<div class="price ">
								<span class="unit-price ">K </span>
								<span class="slash "></span>
								<span class="part ">Phần</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach

	</div>
</div>
