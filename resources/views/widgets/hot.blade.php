<div class="collection with-header z-depth-1">
    <div class="collection-header grey lighten-4"><h5>Hot</h5></div>
    @foreach($hotPosts as $hotPost)
        <a href="{{ route('articles.show', $hotPost->slug) }}" class="collection-item waves-effect black-text">
            <span class="badge" data-badge-caption="">{{ $hotPost->view_count }}</span>
            {{ $hotPost->title }}
        </a>
    @endforeach
</div>