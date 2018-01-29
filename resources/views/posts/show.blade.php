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
                <h2>{{ $post->title }}</h2>
            </div>
            <div class="row">
                @include('partials.post-meta')
            </div>
        </div>
    @endcomponent

    <div class="container post-main">
        <div class="row">
            <div class="col s12 post-desc">
                <div class="card-panel teal">
                    <blockquote class="white-text flow-text">
                        {{ $post->description }}
                    </blockquote>
                </div>
            </div>
            <div class="col s12 post-body">
                <div class="card-panel">

                    {{-- TODO when use api, content should be parse first, use transformer or parse markdown before store--}}
                    <div id="post-content" class="flow-text post-content">
                        {!! $post->content !!}
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
                        <p><strong>版权声明：</strong>由 <strong>{{ $post->author->name }}</strong> 创作，使用
                            <a href="http://creativecommons.org/licenses/by/4.0/deed.zh"><img src="https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg?style=flat-square" alt="License: CC BY-SA 4.0"></a>
                            创作共享协议，<a href="http://creativecommons.org/licenses/by/4.0/deed.zh">相关说明</a>
                        </p>
                        <p><strong>本文链接：</strong><a href="{{ route('articles.show', $post->slug) }}">{{ route('articles.show', $post->slug) }}</a></p>
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
