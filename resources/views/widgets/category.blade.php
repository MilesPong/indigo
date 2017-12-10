<div class="collection with-header z-depth-1">
    <div class="collection-header grey lighten-4"><h5>Categories</h5></div>
    @foreach($categories as $category)
        <a href="{{ route('categories.show', $category->slug) }}" class="collection-item waves-effect black-text">
            <span class="badge" data-badge-caption="">{{ $category->posts_count }}</span>
            {{ $category->name }}
        </a>
    @endforeach
</div>