<?php

namespace App\Repositories\Eloquent\Traits;

use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Trait ApiResource
 * @package App\Repositories\Eloquent\Traits
 */
trait ApiResource
{
    /**
     * Default not to use resource.
     *
     * @var bool
     */
    public $useResource = false;

    /**
     * @param bool $switch
     * @return $this
     */
    public function useResource($switch = true)
    {
        $this->useResource = $switch;

        return $this;
    }

    /**
     * @param $data
     * @return \Illuminate\Support\Collection|mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    protected function parseResult($data)
    {
        if (!$this->useResource) {
            return $data;
        }

        $resource = $this->resource();

        if (is_null($resource)) {
            throw new RepositoryException('Resource is not defined yet.');
        }

        if ($data instanceof Collection || $data instanceof LengthAwarePaginator) {
            return forward_static_call_array([$resource, 'collection'], [$data]);
        } elseif (is_null($data)) {
            $data = collect([]);
        }

        return forward_static_call_array([$resource, 'make'], [$data]);
    }

    /**
     * @return null
     */
    public function resource()
    {
        return null;
    }
}