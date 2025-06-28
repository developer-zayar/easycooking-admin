@extends('layouts.app')

@section('title', $recipe->name)
@section('meta')
    <meta name="title" content="{{ $recipe->name }} | EasyCookingMM">
    <meta name="description" content="{{ config('app.config.app_description') }}">
    <meta name="keywords" content="EasyCookingMM, recipes, cooking, Myanmar food">
    {{-- {{ implode(',', $recipe->tags ?? []) }}, --}}

    <!-- Facebook Meta Tags -->
    <meta property="og:title" content="{{ $recipe->name }}" />
    <meta property="og:description"
        content="{{ config('app.config.app_name_mm') }} - {{ env('APP_NAME', 'EasyCookingMM') }}" />
    <meta property="og:image" content="{{ $recipe->image }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $recipe->name }}" />
    <meta name="twitter:description"
        content="{{ config('app.config.app_name_mm') }} - {{ env('APP_NAME', 'EasyCookingMM') }}" />
    <meta name="twitter:image" content="{{ $recipe->image }}" />

    <meta property="twitter:domain" content="easycookingmm.com">
    <meta property="twitter:url" content="{{ url()->current() }}">

@endsection

@push('styles')
    <style>
        .prose-content img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 1rem auto;
        }

        .prose-content iframe {
            max-width: 100%;
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            display: block;
            margin: 1rem 0;
        }

        .prose-content table {
            width: 100%;
            overflow-x: auto;
            display: block;
        }

        .prose-content p,
        .prose-content ul,
        .prose-content ol {
            word-break: break-word;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <div class="mb-4">
                    <h3 class="fw-bold">{{ $recipe->name }}</h3>
                    <div class="d-flex flex-wrap align-items-center gap-2 mt-2">
                        <span class="badge rounded-pill bg-secondary">{{ $recipe->category->name }}</span>
                        <small class="text-muted">{{ $recipe->created_at->format('F j, Y') }}</small>
                        <small class="text-muted ms-2">
                            <i class="bi bi-eye"></i> {{ $recipe->view_count ?? 0 }} views
                        </small>
                        <small class="text-muted ms-2">
                            <i class="bi bi-heart-fill text-danger"></i> {{ $recipe->fav_count ?? 0 }} favorites
                        </small>
                    </div>
                </div>

                <!-- App Store & Play Store Buttons -->
                <div class="text-center my-4">
                    <a href="https://play.google.com/store/apps/details?id=com.pas.easycooking" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/2560px-Google_Play_Store_badge_EN.svg.png"
                            alt="Download on Google Play" style="height: 50px;">
                    </a>
                    {{--            <a href="https://apps.apple.com/app/id1234567890" target="_blank"> --}}
                    {{--                <img --}}
                    {{--                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/2560px-Download_on_the_App_Store_Badge.svg.png" --}}
                    {{--                    alt="Download on App Store" style="height: 50px;"> --}}
                    {{--            </a> --}}

                </div>

                @if ($recipe->image)
                    <div class="mb-4" style="max-width: 100%; margin: 0 auto;"> {{-- ratio ratio-1x1  --}}
                        <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" class="img-fluid object-fit-cover">
                    </div>
                @endif

                <div class="mb-4">
                    <div class="prose-content">
                        {!! $recipe->description !!}
                    </div>
                </div>

                <!-- Media Gallery -->
                @if ($recipe->images->count())
                    <div class="border-top pt-4 pb-4">
                        <div class="row g-3">
                            @foreach ($recipe->images as $media)
                                {{--                        @if ($media->content_type === 'youtube') --}}
                                {{--                            <div class="col-12"> --}}
                                {{--                                <div class="ratio ratio-16x9"> --}}
                                {{--                                    <iframe --}}
                                {{--                                        src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::after($media->video_id, 'youtu.be/') }}" --}}
                                {{--                                        title="YouTube video" --}}
                                {{--                                        allowfullscreen></iframe> --}}
                                {{--                                </div> --}}
                                {{--                            </div> --}}
                                {{--                        @else --}}
                                <div class="col-6 col-md-4 col-lg-3">
                                    <img src="{{ $media->url }}" class="img-fluid rounded" alt="Recipe Step Image">
                                </div>
                                {{--                        @endif --}}
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="border-top pt-3 text-center">
                    <h5>Share this recipe:</h5>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        target="_blank" class="btn btn-sm btn-primary me-2">
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
        </div>
    </div>

@endsection

