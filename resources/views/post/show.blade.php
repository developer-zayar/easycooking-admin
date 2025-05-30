@extends('layouts.app')

@section('title', $post->title)
@section('meta')
    <meta name="title" content="{{ $post->title }} | EasyCookingMM">
    <meta name="description" content="{{ $post->slug }}">
    <meta name="keywords" content="EasyCookingMM, recipes, cooking, Myanmar food">
    {{-- {{ implode(',', $post->tags ?? []) }},--}}

    <meta property="og:title" content="{{ $post->title }}"/>
    <meta property="og:description" content="{{ $post->slug }}"/>
    <meta property="og:image" content="{{  $post->images[0]->url }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="article"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{ $post->title }}"/>
    <meta name="twitter:description" content="{{ $post->slug }}"/>
    <meta name="twitter:image" content="{{  $post->images[0]->url }}"/>
@endsection

@section('content')
    <div class="container">
        <div class="mb-4">
            <h3 class="fw-bold">{{ $post->title }}</h3>
            <div class="d-flex flex-wrap align-items-center gap-2 mt-2">
                {{--                <span class="badge rounded-pill bg-secondary">{{ $post->category->name }}</span>--}}
                <small class="text-muted">{{ $post->created_at->format('F j, Y') }}</small>
                <small class="text-muted ms-2">
                    <i class="bi bi-eye"></i> {{ $post->view_count ?? 0 }} views
                </small>
                {{--                <small class="text-muted ms-2">--}}
                {{--                    <i class="bi bi-heart-fill text-danger"></i> {{ $post->fav_count ?? 0 }} favorites--}}
                {{--                </small>--}}
            </div>
        </div>

        <!-- App Store & Play Store Buttons -->
        <div class="text-center my-4">
            <a href="https://play.google.com/store/apps/details?id=com.yourapp" target="_blank">
                <img
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/2560px-Google_Play_Store_badge_EN.svg.png"
                    alt="Download on Google Play" style="height: 50px;">
            </a>
            <a href="https://apps.apple.com/app/id1234567890" target="_blank">
                <img
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/2560px-Download_on_the_App_Store_Badge.svg.png"
                    alt="Download on App Store" style="height: 50px;">
            </a>
        </div>


        {{--        @if($post->images->isNotEmpty())--}}
        {{--            <div class="ratio ratio-1x1 mb-4" style="max-width: 400px; margin: 0 auto;">--}}
        {{--                <img src="{{ $post->images[0]->url }}" alt="{{ $post->title }}"--}}
        {{--                     class="img-fluid object-fit-cover">--}}
        {{--            </div>--}}
        {{--        @endif--}}

        <div class="lh-base mb-4">
            {!! $post->content !!}
        </div>

        <!-- Media Gallery -->
        @if($post->images->count())
            <div class="border-top py-4">
                <div class="row g-3">
                    @foreach($post->images as $media)
                        {{--                        @if($media->content_type === 'youtube')--}}
                        {{--                            <div class="col-12">--}}
                        {{--                                <div class="ratio ratio-16x9">--}}
                        {{--                                    <iframe--}}
                        {{--                                        src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::after($media->video_id, 'youtu.be/') }}"--}}
                        {{--                                        title="YouTube video"--}}
                        {{--                                        allowfullscreen></iframe>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        @else--}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="{{ $media->url }}" class="img-fluid rounded"
                                 alt="Recipe Step Image">
                        </div>
                        {{--                        @endif--}}
                    @endforeach
                </div>
            </div>
        @endif

        <div class="border-top pt-3">
            <h5>Share this recipe:</h5>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
               class="btn btn-sm btn-primary me-2">
                <i class="bi bi-facebook"></i> Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank"
               class="btn btn-sm btn-info me-2">
                <i class="bi bi-twitter"></i> Twitter
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
               target="_blank" class="btn btn-sm btn-secondary">
                <i class="bi bi-linkedin"></i> LinkedIn
            </a>
        </div>
    </div>
@endsection

