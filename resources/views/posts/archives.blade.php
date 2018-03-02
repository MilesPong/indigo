@extends('layouts.base')

@section('title')
    Archives | @parent
@endsection

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h1>Archives</h1>
            </div>
        </div>
    @endcomponent

    <div class="container archives">
        <div class="row">

            @forelse($archives as $year => $yearCollections)
                <blockquote><h2 class="materialize-red-text text-lighten-2">{{ $year }}</h2></blockquote>

                <ul class="collapsible expandable">

                    @foreach($yearCollections as $month => $monthCollections)

                        <li @if($loop->parent->first && $loop->first)class="active"@endif>
                            <div class="collapsible-header">
                                <i class="material-icons">date_range</i>{{ $month }}
                            </div>
                            <div class="collapsible-body">
                                <ul>
                                    @foreach($monthCollections as $post)
                                        <li>
                                            <a href="{{ route('articles.show', $post->slug) }}">
                                                <span class="title">{{ $post->title }}</span>
                                            </a>
                                            <span class="grey-text text-darken-1">
                                                {{ $post->published_at->toDateString() }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>

                    @endforeach

                </ul>
            @empty
                <p>
                    No posts yet.
                </p>
            @endforelse

        </div>
    </div>
@endsection