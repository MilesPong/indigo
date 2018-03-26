@extends('admin.layouts.app')

@section('content')
    <div class="row stats">
        <div class="col s12 m6 l3">
            <a href="{{ route('admin.posts.index') }}">
                <div class="card-panel teal white-text">
                    <h5>@lang('menus.posts')</h5>
                    <span>{{ $postCount }}</span>
                </div>
            </a>
        </div>

        <div class="col s12 m6 l3">
            <a href="{{ route('admin.pages.index') }}">
                <div class="card-panel indigo white-text">
                    <h5>@lang('menus.pages')</h5>
                    <span>{{ $pageCount }}</span>
                </div>
            </a>
        </div>

        <div class="col s12 m6 l3">
            <a href="{{ route('admin.categories.index') }}">
                <div class="card-panel deep-orange white-text">
                    <h5>@lang('menus.categories')</h5>
                    <span>{{ $categoryCount }}</span>
                </div>
            </a>
        </div>

        <div class="col s12 m6 l3">
            <a href="{{ route('admin.tags.index') }}">
                <div class="card-panel blue white-text">
                    <h5>@lang('menus.tags')</h5>
                    <span>{{ $tagCount }}</span>
                </div>
            </a>
        </div>

    </div>
    
@endsection

@push('css')
    <style>
        .stats .card-panel {
            display: flex;
            display: -webkit-flex;
            flex-direction: column;
            align-items: center;
            font-size: 1.8rem;
        }
    </style>
@endpush