<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * Class CommentComposer
 * @package App\Http\ViewComposers
 */
class CommentComposer
{

    /**
     * @param View $view
     * @throws \Exception
     */
    public function compose(View $view)
    {
        $commentDriver = config('blog.comment.driver');

        // Disqus
        if (($commentDriver == 'disqus')) {

            if (!$shortName = config('blog.comment.disqus.short_name')) {
                throw new \Exception('Please set disqus short name.');
            }

            $view->with('disqus', [
                'short_name' => $shortName,
                'page_url' => request()->url(),
                'page_identifier' => request()->path(),
            ]);
        }

        $view->with('commentDriver', $commentDriver);
    }
}