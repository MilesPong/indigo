<?php

namespace App\Http\Middleware;

use App\Indigo\Tools\Localization;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class SetLocale
 * @package App\Http\Middleware
 */
class SetLocale
{
    /**
     * @var string
     */
    protected $localeName = 'locale';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // See if it has locale request via query string.
        // If it doesn't have one or a fail request, we will check the request header named "Accept-Language".
        if ($locale = Localization::getValidLocaleFromRequest($request, $this->localeName)) {
            // Set cookie and redirect to path without query string.
            return $this->redirectResponseWithCookie($request, $locale);
        }

        $locale = Localization::retrieveLocale($request, $this->localeName);

        if ($locale) {
            $this->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectResponseWithCookie(Request $request, $locale)
    {
        return RedirectResponse::create($this->getRedirectUrl($request))->withCookie(new Cookie($this->localeName,
            $locale, Carbon::now()->addMonth()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function getRedirectUrl(Request $request)
    {
        $originalQueries = $request->query();

        unset($originalQueries[$this->localeName]);

        $question = $request->getBaseUrl() . $request->getPathInfo() == '/' ? '/?' : '?';

        return count($originalQueries) > 0 ? $request->url() . $question . http_build_query($originalQueries) : $request->url();
    }

    /**
     * @param $locale
     * @return void
     */
    protected function setLocale($locale)
    {
        app()->setLocale($locale);
    }
}
