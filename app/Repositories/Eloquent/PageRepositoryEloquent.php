<?php

namespace App\Repositories\Eloquent;

use App\Models\Content;
use App\Models\Page;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Eloquent\Traits\FieldsHandler;
use App\Repositories\Eloquent\Traits\HasPublishedStatus;
use App\Repositories\Eloquent\Traits\Slugable;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class PageRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class PageRepositoryEloquent extends BaseRepository implements PageRepository
{
    use Slugable, FieldsHandler, HasPublishedStatus;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $contentModel;

    /**
     * BaseRepository constructor.
     * @param \Illuminate\Container\Container $app
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function __construct(Container $app)
    {
        parent::__construct($app);

        $this->contentModel = $app->make($this->contentModel());
    }

    /**
     * @return string
     */
    public function model()
    {
        return Page::class;
    }

    /**
     * @return string
     */
    public function contentModel()
    {
        return Content::class;
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

        $model = DB::transaction(function () use ($attributes) {
            return tap($this->getNewModelInstance($attributes), function (Model $instance) use ($attributes) {
                $instance->setAttribute('content_id', $this->contentModel->create($attributes)->getKey());
                $instance->setAttribute('user_id', Auth::id());
                $instance->save();
            });
        });

        return $this->parseResult($model);
    }

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        $this->with('author');

        return parent::paginate($perPage, $columns);
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

        $model = DB::transaction(function () use ($attributes, $id) {
            return tap($this->tempDisableApiResource(function () use ($attributes, $id) {
                return parent::update($attributes, $id);
            }), function (Page $page) use ($attributes) {
                $page->content()->update($attributes);
            });
        });

        return $this->parseResult($model);
    }
}