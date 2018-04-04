@foreach ($videos as $video)
<li>
    <a href="javascript:void(0)" class="show-video" data-toggle="modal" data-target="#Modal" data-video="{{ $video->id }}">
        <div class="guide-image">
            <img class="img-responsive img-youtube-detail" src="{{ $video->snippet->thumbnails->default->url }}">
            <i class="fa fa-play-circle btn-youtube" aria-hidden="true"></i>
            
        </div>
        <div class="guide-content">
            <h5 class="guide-title">{{ $video->snippet->title }}.</h5>
            <p class="guide-intro">{{ str_limit($video->snippet->description, 50, '...')}}.</p>
        </div>
        <span class="clearfix"></span>
    </a>
</li>
@endforeach