<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Visitor as VisitorResource;
use App\Models\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

/**
 * Class VisitorRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class VisitorRepositoryEloquent extends BaseRepository implements VisitorRepository
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Agent
     */
    protected $agent;

    /**
     * VisitorRepositoryEloquent constructor.
     * @param \Illuminate\Container\Container $app
     * @param \Illuminate\Http\Request $request
     * @param \Jenssegers\Agent\Agent $agent
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function __construct(Container $app, Request $request, Agent $agent)
    {
        parent::__construct($app);
        $this->request = $request;
        $this->agent = $agent;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Visitor::class;
    }

    /**
     * @return null|string
     */
    public function resource()
    {
        return VisitorResource::class;
    }

    /**
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function createLog()
    {
        return $this->create($this->getLogData());
    }

    /**
     * @return array
     */
    protected function getLogData()
    {
        return [
            'ip' => $this->request->ip(),
            'uri' => $this->request->path(),
            'is_robot' => $this->agent->isRobot(),
            'platform' => $this->agent->platform(),
            'device' => $this->agent->device(),
            'browser' => $this->agent->browser(),
            'user_agent' => $this->request->server('HTTP_USER_AGENT'),
        ];
    }
}
