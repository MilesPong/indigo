<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Eloquent\Traits\Slugable;
use App\Repositories\Exceptions\RepositoryException;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class PostRepositoryEloquent extends Repository implements PostRepository
{
    use Slugable;

    /**
     * @var TagRepository
     */
    protected $tagRepo;

    /**
     * PostRepositoryEloquent constructor.
     * @param Container $app
     * @param TagRepository $tagRepo
     */
    public function __construct(Container $app, TagRepository $tagRepo)
    {
        parent::__construct($app);
        $this->tagRepo = $tagRepo;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function createPost(array $attributes)
    {
        $attributes = $this->preHandleData($attributes);

        // TODO use transaction
        $this->model = request()->user()->posts()->create($attributes);

        return $this->syncTags(data_get($attributes, 'tag'));
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function preHandleData(array $attributes)
    {
        $attributes = $this->autoSlug($attributes, 'title');

        $publishedAt = $this->getPublishedAt(array_get($attributes, 'published_at'));

        $isDraft = $this->getIsDraft(array_get($attributes, 'is_draft'));

        $attributes = array_merge($attributes, [
            'published_at' => $publishedAt,
            'is_draft' => $isDraft,
        ]);

        return $attributes;
    }

    /**
     * @param $value
     * @return Carbon
     */
    protected function getPublishedAt($value)
    {
        if (empty($value)) {
            return Carbon::now();
        }

        return Carbon::createFromTimestamp(strtotime($value));
    }

    /**
     * @param $value
     * @return int
     */
    protected function getIsDraft($value)
    {
        if (empty($value)) {
            return 0;
        }

        return 1;
    }

    /**
     * @param array $tags
     * @throws RepositoryException
     */
    protected function syncTags(array $tags)
    {
        if (!$this->model->exists) {
            throw new RepositoryException('Model is not exist');
        }

        if (empty($tags)) {
            return;
        }

        $ids = [];
        foreach ($tags as $tagName) {
            $tag = $this->tagRepo->firstOrCreate([
                'name' => $tagName,
                'slug' => str_slug($tagName)
            ]);
            array_push($ids, $tag->id);
        }

        return $this->model->tags()->sync($ids);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function updatePost(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        // TODO use transaction
        $this->model = $this->update($attributes, $id);

        return $this->syncTags(data_get($attributes, 'tag'));
    }
}
