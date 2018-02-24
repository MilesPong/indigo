<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Post as PostResource;
use App\Models\Category;
use App\Models\Content;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Eloquent\Traits\FieldsHandler;
use App\Repositories\Eloquent\Traits\HasPublishedStatus;
use App\Repositories\Eloquent\Traits\MarkdownHelper;
use App\Repositories\Eloquent\Traits\Slugable;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Indigo\Models\Article;

/**
 * Class PostRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    use FieldsHandler, HasPublishedStatus, MarkdownHelper, Slugable {
        getBySlug as slugableGetBySlug;
    }
    /**
     * @var \App\Repositories\Contracts\TagRepository
     */
    protected $tagRepository;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $contentModel;

    /**
     * PostRepositoryEloquent constructor.
     * @param \Illuminate\Container\Container $app
     * @param \App\Repositories\Contracts\TagRepository $tagRepository
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function __construct(Container $app, TagRepository $tagRepository)
    {
        parent::__construct($app);

        $this->tagRepository = $tagRepository;
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
     *
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * @return null|string
     */
    public function resource()
    {
        return PostResource::class;
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
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $attributes)
    {
        $attributes = $this->preHandleData($attributes);

        // Reference: Illuminate\Database\Eloquent\Relations\HasOneOrMany@create to allow "mass assign" attributes.
        $model = DB::transaction(function () use ($attributes) {
            return tap($this->getNewModelInstance($attributes), function (Model $instance) use ($attributes) {
                // TODO how to decouple 'field_name' and logic?
                $instance->setAttribute('content_id', $this->contentModel->create($attributes)->getKey());
                $instance->setAttribute('user_id', Auth::id());

                $instance->save();

                $this->syncTags($instance, array_get($attributes, 'tag', []));
            });
        });

        return $this->parseResult($model);
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function preHandleData(array $attributes)
    {
        $attributes['slug'] = $this->autoSlug($attributes['slug'], $attributes['title']);

        return $this->handle($attributes);
    }

    /**
     * @param \App\Models\Post|\Illuminate\Database\Eloquent\Model $model
     * @param array $tags
     * @return mixed
     */
    protected function syncTags($model, array $tags = [])
    {
        $ids = [];

        foreach ($tags as $tagName) {
            $tag = $this->tagRepository->firstOrCreate([
                'name' => strtolower($tagName),
                'slug' => str_slug($tagName)
            ]);
            array_push($ids, $tag->id);
        }

        return $model->tags()->sync($ids);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        // Oops...
        $model = DB::transaction(function () use ($attributes, $id) {
            return tap($this->tempDisableApiResource(function () use ($attributes, $id) {
                return parent::update($attributes, $id);
            }), function (Post $instance) use ($attributes) {
                $instance->content()->update($attributes);

                $this->syncTags($instance, array_get($attributes, 'tag', []));
            });
        });

        return $this->parseResult($model);
    }

    /**
     * @param $slug
     * @param string $field
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function getBySlug($slug, $field = 'slug')
    {
        $this->with($this->relationships());

        return $this->slugableGetBySlug($slug, $field);
    }

    // /**
    //  * Fetch posts data of home page with pagination.
    //  *
    //  * Alert: It's not optimized without cache support,
    //  * so just only use this while with cache enabled.
    //  *
    //  * @param null $perPage
    //  * @return mixed
    //  */
    // public function lists($perPage = null)
    // {
    //     $perPage = $perPage ?: $this->getDefaultPerPage();
    //
    //     // Second layer cache
    //     $pagination = $this->paginate($perPage, ['slug']);
    //
    //     $items = $pagination->getCollection()->map(function ($post) {
    //         // First layer cache
    //         return $this->getBySlug($post->slug);
    //     });
    //
    //     return $pagination->setCollection($items);
    // }

    /**
     * @return array
     */
    protected function relationships()
    {
        return ['author', 'category', 'tags'];
    }

    /**
     * @param \App\Models\Post $model
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function previous(Post $model)
    {
        return $this->parseResult($this->scopeQuery(function ($query) use ($model) {
            return $query->previous($model, ['title', 'slug']);
        })->first());
    }

    /**
     * @param \App\Models\Post $model
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function next(Post $model)
    {
        return $this->parseResult($this->scopeQuery(function ($query) use ($model) {
            return $query->next($model, ['title', 'slug']);
        })->first());
    }

    /**
     * @param int $limit
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function hot($limit = 5)
    {
        // TODO cache support
        return $this->parseResult($this->scopeQuery(function ($query) use ($limit) {
            return $query->hot($limit, ['slug', 'title', 'view_count']);
        })->findAll());
    }

    /**
     * @param \App\Models\Category $category
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function paginateOfCategory(Category $category)
    {
        return $this->paginateOfPostRelated($category);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $relation
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    protected function paginateOfPostRelated(Model $model, $relation = 'posts')
    {
        if (method_exists($model, $relation)) {
            $paginator = $model->$relation()
                ->with($this->relationships())
                ->latestPublished()
                ->paginate($this->getDefaultPerPage());

            return $this->parseResult($paginator);
        }

        throw new RepositoryException("Current model " . get_class($model) . " doesn't have relationship of '{$relation}'.");
    }

    /**
     * @return int
     */
    public function getDefaultPerPage()
    {
        return config('indigo.posts.per_page');
    }

    /**
     * @param \App\Models\Tag $tag
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function paginateOfTag(Tag $tag)
    {
        return $this->paginateOfPostRelated($tag);
    }

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function frontendPaginate($perPage = null, $columns = ['*'])
    {
        return $this->with($this->relationships())->latestPublished()->paginate($perPage ?: $this->getDefaultPerPage(),
            $columns);
    }

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        return parent::paginate($perPage ?: $this->getDefaultPerPage(), $columns);
    }

    /**
     * @param string $column
     * @return $this
     */
    public function latestPublished($column = 'published_at')
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function backendPaginate($perPage = null, $columns = ['*'])
    {
        return $this->with(['category', 'author'])->orderBy('id',
            'desc')->paginate($perPage ?: $this->getDefaultPerPage(), $columns);
    }

    /**
     * @param $slug
     * @param bool $copyright
     * @return string
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function markdown($slug, $copyright = true)
    {
        $model = $this->useResource(false)->slugableGetBySlug($slug);

        if (!$model instanceof Article) {
            throw new RepositoryException("class " . (object)$model . " is not an instance of " . get_class(Article::class));
        }

        return $this->getCompleteMarkdown($model, $copyright);
    }
}
