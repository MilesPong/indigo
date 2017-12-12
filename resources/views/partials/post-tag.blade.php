<div class="section tag-list">
    <i class="material-icons grey-text text-darken-2">loyalty</i>
    @foreach($post->tags as $tag)
        <a class="chip waves-effect waves-teal grey-text text-darken-2" href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}</a>
    @endforeach
</div>