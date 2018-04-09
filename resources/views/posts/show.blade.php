@extends('layouts.base')

@section('title')
{{ $post->title }} | @parent
@endsection

@section('keywords'){{ $post->tags->implode('name', ',') }}@endsection
@section('description'){{ $post->description }}@endsection

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h1>{{ $post->title }}</h1>
            </div>
            <div class="row">
                @include('partials.post-meta', ['toolTip' => true])
            </div>
        </div>
    @endcomponent

    <div class="container post-main">
        <div class="row">
            <div class="col s12 post-desc">
                <div class="card-panel teal">
                    <blockquote class="white-text">
                        {{ $post->description }}
                    </blockquote>
                </div>
            </div>
            <div class="col s12 post-body">
                <div class="card-panel">

                    {{-- TODO when use api, content should be parse first, use transformer or parse markdown before store--}}
                    <div id="post-content" class="post-content">
                        {!! $post->htmlContent !!}
                    </div>

                    <div class="post-content-tag">
                        <div class="divider"></div>

                        @include('partials.post-tag')
                    </div>

                </div>

            </div>

            <div class="col s12 post-copyright">
                <div class="card-panel grey lighten-3">
                    <blockquote class="">
                        <p>
                            <strong>@lang('articles.source')：</strong><a href="{{ route('articles.markdown', $post->slug) }}">@lang('articles.markdown_version')</a></p>
                        <p>
                            <strong>@lang('articles.copyright')：</strong>@lang('articles.copyright_content', ['name' => $post->author->name, 'badge' => 'https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg?style=flat-square'])
                        </p>
                        <p><strong>@lang('articles.permalink')：</strong><a href="{{ route('articles.show', $post->slug) }}">{{ route('articles.show', $post->slug) }}</a></p>
                    </blockquote>
                </div>
            </div>

            <div class="col s12 post-pre-next">
                <div class="row">
                    <div class="col s6 m4">
                        @if($previous)
                            <a href="{{ route('articles.show', $previous->slug) }}" class="waves-effect waves-teal btn-large btn-flat left post-pre"><i class="material-icons left">keyboard_arrow_left</i>{{ $previous->title }}</a>
                        @endif
                    </div>
                    <div class="col s6 m4 offset-m4">
                        @if($next)
                            <a href="{{ route('articles.show', $next->slug) }}" class="waves-effect waves-teal btn-large btn-flat right post-next"><i class="material-icons right">keyboard_arrow_right</i>{{ $next->title }}</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col s12 post-comment">
                @include('partials.comment')
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            let postBody = $('.post-content');
            
            postBody.find('table').each((idx, elem) => {
                $(elem).addClass('striped centered responsive-table');
            });

            postBody.find('pre:not([class])').each((idx, elem) => {
                $(elem).addClass('language-bash');
                $(elem).find('code:not([class])').each((idx, elem) => {
                    $(elem).addClass('language-bash');
                });
            });
        })
    </script>
@endpush
