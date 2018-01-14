<div class="widget-sidebar widget-post-card">

    <div class="card hoverable">
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
            <div class="grey-text text-darken-2">
                @include('partials.post-meta')
            </div>

            <div class="divider"></div>

            <blockquote class="flow-text">{{ $post->description }}</blockquote>

        </div>

        <div class="divider"></div>

        @include('partials.post-tag')

    </div>

</div>