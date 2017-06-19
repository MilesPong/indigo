<?php

namespace App\Http\Middleware;

use App\Repositories\Contracts\VisitorRepository;
use Closure;

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
        $this->visitorRepo->createLog();

        return $next($request);
    }
}
