<div class="card hoverable post-card">
    <div class="card-image">
        <img src="{{ $post->feature_img }}">
        <a class="btn-floating btn-large halfway-fab waves-effect waves-light materialize-red lighten-2"
           href="{{ route('posts.show', $post->id) }}">
            <i class="material-icons">more_horiz</i>
        </a>
    </div>
    <div class="card-content">
        <div class="section">
            <span class="card-title">{{ $post->title }}</span>
        </div>
        <div class="grey-text text-darken-2 post-meta">
            <ul>
                <li>
                    <span><i class="material-icons">date_range</i>{{ $post->published_at->diffForHumans() }}</span>
                </li>
                <li>
                    <i class="material-icons">person_pin</i>{{ $post->author->name }}
                </li>
                <li>
                    <i class="material-icons">folder_open</i>{{ $post->category->name }}
                </li>
                <li>
                    <i class="material-icons">remove_red_eye</i>{{ $post->view_count }}
                </li>
            </ul>
        </div>

        <div class="divider"></div>

        <blockquote class="flow-text excerpt">{{ $post->excerpt }}</blockquote>

    </div>
    <div class="divider"></div>
    <div class="section post-tag">
        <i class="material-icons grey-text text-darken-2">loyalty</i>
        @foreach($post->tags as $tag)
            <a class="chip waves-effect waves-teal grey-text text-darken-2" href="#!">{{ $tag->name }}</a>
        @endforeach
    </div>
</div>