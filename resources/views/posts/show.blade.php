@extends('layouts.app')

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h2>{{ $post->title }}</h2>
            </div>
            <div class="row post-meta">
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
        </div>
    </div>
@endsection