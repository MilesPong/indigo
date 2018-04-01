<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Indigo\Tools\GithubWebhook;

/**
 * Class WebhookController
 * @package App\Http\Controllers
 */
class WebhookController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Reaction based on event, ping-pong or execute deployment in queue
        return with(new GithubWebhook($request))->handle();
    }
}
