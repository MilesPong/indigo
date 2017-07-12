@extends('layouts.app')

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h2>{{ $post->title }}</h2>
            </div>
            <div class="row post-meta fix-post-meta">
                @include('partials.post-meta')
            </div>
        </div>
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel teal">
                    <blockquote class="white-text flow-text">
                        {{ $post->excerpt }}
                    </blockquote>
                </div>
            </div>
            <div class="col s12">
                <div class="card-panel article">

                    {{-- TODO when use api, content should be parse first, use transformer or parse markdown before store--}}
                    <div id="post-content" class="flow-text">
                        {!! $post->content !!}
                    </div>

                    <div class="card-panel post-meta grey lighten-3">
                        <i class="material-icons grey-text text-darken-2">loyalty</i>
                        @foreach($post->tags as $tag)
                            <a class="chip waves-effect waves-teal grey lighten-3 text text-darken-2"
                               href="#!">{{ $tag->name }}</a>
                        @endforeach
                    </div>

                </div>

            </div>

            <div class="col s12">
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

            <div class="col s12">
                <div class="row">
                    <div class="col s6 m4">
                        @if($previous)
                            <a href="{{ route('articles.show', $previous->slug) }}" class="waves-effect waves-teal btn-large btn-flat left full-width"><i class="material-icons left">keyboard_arrow_left</i>{{ $previous->title }}</a>
                        @endif
                    </div>
                    <div class="col s6 m4 offset-m4">
                        @if($next)
                            <a href="{{ route('articles.show', $next->slug) }}" class="waves-effect waves-teal btn-large btn-flat right full-width"><i class="material-icons right">keyboard_arrow_right</i>{{ $next->title }}</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col s12">
                @include('partials.comment')
            </div>

        </div>
    </div>
@endsection

@push('css')
<style>
    .full-width {
        width: 100%;
    }
</style>
@endpush