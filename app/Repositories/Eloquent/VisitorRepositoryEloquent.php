<?php

namespace App\Repositories\Eloquent;

use App\Models\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Http\Resources\Visitor as VisitorResource;

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
     * @param Container $app
     * @param Request $request
     * @param Agent $agent
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
     * @return \Illuminate\Database\Eloquent\Model
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
            'uri' =>$this->request->path(),
            'is_robot' => $this->agent->isRobot(),
            'platform' => $this->agent->platform(),
            'device' => $this->agent->device(),
            'browser' => $this->agent->browser(),
            'user_agent' => $this->request->server('HTTP_USER_AGENT'),
        ];
    }
}
