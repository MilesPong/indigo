<?php

namespace App\Repositories\Eloquent\Traits;

use Indigo\Models\Article;

/**
 * Trait MarkdownHelper
 * @package App\Repositories\Eloquent\Traits
 */
trait MarkdownHelper
{
    /**
     * @param \Indigo\Models\Article $article
     * @param bool $copyright
     * @return string
     */
    public function getCompleteMarkdown(Article $article, $copyright = true)
    {
        // Title
        $markdown = sprintf("# %s\n\n", $article->getTitle());

        // Description
        if ($description = $article->getDescription()) {
            $markdown = $markdown . sprintf("%s\n\n<!--more-->\n\n", $description);
        }

        // Content
        $markdown .= $article->getMarkdownContent();

        // Copyright
        return $copyright ? $markdown . $this->markdownCopyright($article->getPermalink()) : $markdown;
    }

    /**
     * @param string $permalink
     * @return string
     */
    public function markdownCopyright($permalink = '')
    {
        // TODO i18n
        return sprintf("\n\n原文链接：[%s](%s)", $permalink, $permalink);
    }
}