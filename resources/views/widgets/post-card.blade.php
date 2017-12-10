<div class="card hoverable post-card">
    <div class="card-image">
        <img src="{{ $post->feature_img }}">
        <a class="btn-floating btn-large halfway-fab waves-effect waves-light materialize-red lighten-2"
           href="{{ route('articles.show', $post->slug) }}">
            <i class="material-icons">more_horiz</i>
        </a>
    </div>
    <div class="card-content">
        <div class="section">
            <a href="{{ route('articles.show', $post->slug) }}">
                <span class="card-title black-text">{{ $post->title }}</span>
            </a>
        </div>
        <div class="grey-text text-darken-2 post-meta">
            @include('partials.post-meta')
        </div>

        <div class="divider"></div>

        <blockquote class="flow-text excerpt">{{ $post->excerpt }}</blockquote>

    </div>
    <div class="divider"></div>
    <div class="section post-tag">
        <i class="material-icons grey-text text-darken-2">loyalty</i>
        @foreach($post->tags as $tag)
            <a class="chip waves-effect waves-teal grey-text text-darken-2" href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}</a>
        @endforeach
    </div>
</div>