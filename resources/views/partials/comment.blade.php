@if($commentDriver == 'disqus' && App::environment('production'))
    @include('widgets.disqus', [
        'disqus_short_name' => $disqus['short_name'],
        'page_url' => $disqus['page_url'],
        'page_identifier' => $disqus['page_identifier'],
    ])
@else

@endif