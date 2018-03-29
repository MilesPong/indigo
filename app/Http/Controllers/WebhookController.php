<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Indigo\Tools\GithubWebhook;

class WebhookController extends Controller
{
    public function index(Request $request, GithubWebhook $webhook)
    {
        // Validate

        // Log header and payload
        $this->log($request);

        // React based on event, ping-pong or execute deployment in queue
        return $webhook->handle();

    }

    protected function log($request)
    {

    }
}
