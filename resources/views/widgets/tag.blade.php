<div class="collection with-header z-depth-1">
    <div class="collection-header"><h5>Tags</h5></div>
    <div class="tag-list">
        @foreach($tags as $tag)
            <a class="chip waves-effect waves-teal" href="#!">
                {{ $tag->name }}
                <span class="badge-tag teal white-text circle">{{ $tag->posts_count }}</span>
            </a>
        @endforeach
    </div>
</div>