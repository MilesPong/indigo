<?php

namespace App\Repositories\Eloquent;

use App\Models\Content;
use App\Models\Post;
use App\Repositories\Contracts\CacheableInterface;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Eloquent\Traits\FieldsHandler;
use App\Repositories\Eloquent\Traits\Slugable;
use App\Repositories\Exceptions\RepositoryException;
use App\Repositories\Eloquent\Traits\Cacheable;
use App\Scopes\PublishedScope;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository, CacheableInterface
{
    use Slugable;
    use Cacheable;
    use FieldsHandler;

    /**
     * @var TagRepository
     */
    protected $tagRepo;

    /**
     * @var mixed
     */
    protected $contentModel;

    /**
     * PostRepositoryEloquent constructor.
     * @param Container $app
     * @param TagRepository $tagRepo
     */
    public function __construct(Container $app, TagRepository $tagRepo)
    {
        parent::__construct($app);
        $this->tagRepo = $tagRepo;
        $this->contentModel = $this->app->make($this->contentModel());
    }

    /**
     * @return string
     */
    public function contentModel()
    {
        return Content::class;
    }

    /**
     * @return $this
     */
    public function scopeBoot()
    {
        parent::scopeBoot();

        // TODO to be optimized
        // Session middleware is called after ServiceProvider binding, so can't set method boot in constructor
        if (isAdmin()) {
            return $this->model = $this->model->withoutGlobalScope(PublishedScope::class);
        }
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
        $this->model = request()->user()->posts()->create(array_merge($attributes, [
            'content_id' => $this->contentModel->create($attributes)->id,
        ]));

        return $this->syncTags(data_get($attributes, 'tag', []));
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function preHandleData(array $attributes)
    {
        $attributes = $this->autoSlug($attributes, 'title');

        foreach ($attributes as $field => $value) {
            if (method_exists($this, $method = 'handle' . ucfirst(camel_case($field)))) {
                array_set($attributes, $field, call_user_func_array([$this, $method], [$value]));
            }
        }

        $attributes = $this->handleImg($attributes);

        // TODO excerpt should be html purifier

        return $attributes;
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

        $ids = [];

        if (empty($tags)) {
            return $this->model->tags()->sync($ids);
        }

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
        $this->model = $this->update(array_except($attributes, 'slug'), $id);

        $this->model->content()->update($attributes);

        return $this->syncTags(data_get($attributes, 'tag', []));
    }

    /**
     * Fetch posts data of home page with pagination.
     *
     * Alert: It's not optimized without cache support,
     * so just only use this while with cache enabled.
     *
     * @param null $perPage
     * @return mixed
     */
    public function lists($perPage = null)
    {
        $perPage = $perPage ?: $this->getDefaultPerPage();

        // Second layer cache
        $pagination = $this->paginate($perPage, ['slug']);

        $items = $pagination->getCollection()->map(function ($post) {
            // First layer cache
            return $this->getBySlug($post->slug);
        });

        return $pagination->setCollection($items);
    }

    /**
     * Get a single post.
     *
     * @param $id
     * @return mixed
     */
    public function retrieve($id)
    {
        return $this->with(['author', 'category', 'tags'])->find($id);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->with(['author', 'category', 'tags'])->findBy('slug', $slug);
    }

    /**
     * @param $model
     * @return mixed
     */
    public function previous($model)
    {
        return $this->scopeQuery(function ($query) use ($model) {
            return $query->previous($model->id, ['title', 'slug']);
        })->first();
    }

    /**
     * @param $model
     * @return mixed
     */
    public function next($model)
    {
        return $this->scopeQuery(function ($query) use ($model) {
            return $query->next($model->id, ['title', 'slug']);
        })->first();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function hot($limit = 5)
    {
        // TODO cache support
        return $this->skipCache()->scopeQuery(function ($query) use ($limit) {
            return $query->hot($limit, ['slug', 'title', 'view_count']);
        })->all();
    }

}
