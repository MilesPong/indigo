<?php

namespace App\Http\Middleware;

use App\Repositories\Contracts\VisitorRepository;
use Closure;

/**
 * Class VisitorMiddleware
 * @package App\Http\Middleware
 */
class VisitorMiddleware
{
    /**
     * @var VisitorRepository
     */
    protected $visitorRepo;

    /**
     * VisitorMiddleware constructor.
     * @param VisitorRepository $visitorRepo
     */
    public function __construct(VisitorRepository $visitorRepo)
    {
        $this->visitorRepo = $visitorRepo;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->allowLog()) {
            $this->visitorRepo->createLog();
        }

        return $next($request);
    }

    /**
     * @return mixed
     */
    protected function allowLog()
    {
        return config('blog.log.visitor', false);
    }
}
