<div class="meta-list">
    <ul>
        <li>
            <i class="material-icons">date_range</i>{{ $post->published_at->diffForHumans() }}
        </li>
        <li>
            <i class="material-icons">person_pin</i>{{ $post->author->name }}
        </li>
        <li>
            <i class="material-icons">folder_open</i><a href="{{ route('categories.show', $post->category->slug) }}">{{ $post->category->name }}</a>
        </li>
        <li>
            <i class="material-icons">remove_red_eye</i>{{ $post->view_count }}
        </li>
    </ul>
</div>