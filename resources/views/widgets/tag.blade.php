<div class="widget-sidebar widget-tag">
    <div class="collection with-header z-depth-1">
        <div class="collection-header grey lighten-4"><h5>@lang('menus.tags')</h5></div>
        <div class="tag-content white">
            @foreach($tags as $tag)
                <a class="chip waves-effect waves-teal" href="{{ route('tags.show', $tag->slug) }}">
                    {{ $tag->name }}
                    <span class="tag-badge teal white-text circle">{{ $tag->posts_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>