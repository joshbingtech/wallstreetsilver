@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-3">
        <div class="col-md-9">
            @if ($articles_for_carousel->count() > 0)
                <div class="featured-story-carousel border-white mt-3">
                    <div id="featured-story-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($articles_for_carousel as $key => $article)
                            <button type="button" data-bs-target="#featured-story-carousel" data-bs-slide-to="{{ $key }}" class="@if ($key == 0) active @endif" aria-current="true" aria-label="Slide {{ $key }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($articles_for_carousel as $key => $article)
                                <div class="carousel-item @if ($key == 0) active @endif" data-bs-interval="5000">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="outer">
                                                <div class="middle">
                                                    <div>
                                                        <img src="{{ asset('articles/'.$article['thumbnail']) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8" style="min-height: 210px; position: relative;">
                                            <h3 class="text-center"> {{ $article['title'] }} </h3>
                                            <div>
                                                {{ character_limiter($article['description'], 200) }}
                                                <a href="#"> Continue Reading </a>
                                            </div>
                                            <div class="article-publish-date">
                                                <div>
                                                    {{ convertDateTimeTo($article['created_at']) }}
                                                </div>
                                                <div class="article-view">
                                                    <img src="{{ asset('images/icons/view-count.png') }}"> {{ $article['views'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        Twitter Handle Feed
                    </div>
                    <div class="col-md-6">
                        <div class="featured-articles">
                            <div class="featured-articles">
                                @foreach ($featured_articles as $article)
                                    <div class="row article border-white">
                                        <div class="col-md-4">
                                            <div class="outer">
                                                <div class="middle">
                                                    <div>
                                                        <img src="{{ asset('articles/'.$article['thumbnail']) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 article-summary">
                                            <h3 class="text-center"> {{ $article['title'] }} </h3>
                                            <div>
                                                {{ character_limiter($article['description'], 200) }}
                                                <a href="#"> Continue Reading </a>
                                            </div>
                                            <div class="article-publish-date">
                                                {{ convertDateTimeTo($article['created_at']) }}
                                            </div>
                                            <div class="article-view">
                                                <img src="{{ asset('images/icons/view-count.png') }}"> {{ $article['views'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
@endsection
@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
