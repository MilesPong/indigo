<?php

namespace Indigo\Tools;

use App\Events\GithubWebhookEvent;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class GithubWebhook
 * @package Indigo\Tools
 */
class GithubWebhook
{
    /**
     *
     */
    const HEADER_DELIVERY = 'X-GitHub-Delivery';
    /**
     *
     */
    const HEADER_EVENT = 'X-GitHub-Event';
    /**
     *
     */
    const HEADER_SIGNATURE = 'X-Hub-Signature';
    /**
     * @var string|null
     */
    protected $secret;
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * GithubWebhook constructor.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->secret = config('indigo.github_webhook_secret');

        if (!$this->isGithubRequest()) {
            throw new BadRequestHttpException('Bad Github request.');
        }
    }

    /**
     * @return bool
     */
    protected function isGithubRequest()
    {
        foreach ($this->getWebhookHeaderNames() as $header) {
            if (!$this->request->hasHeader($header)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getWebhookHeaderNames()
    {
        $headers = [
            self::HEADER_DELIVERY,
            self::HEADER_EVENT,
        ];

        return $this->issetSecret() ? array_merge($headers, [self::HEADER_SIGNATURE]) : $headers;
    }

    /**
     * @return bool
     */
    public function issetSecret()
    {
        return !is_null($this->secret);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        if ($this->issetSecret() && !$this->validateSignature()) {
            return $this->response('wrong signature', Response::HTTP_FORBIDDEN);
        }

        if ($this->isPingEvent()) {
            return $this->response('pong');
        }

        event(new GithubWebhookEvent($this->getEvent(), $this->getPayload()));

        return $this->response('ok');
    }

    /**
     * @param string $algo
     * @return bool
     */
    protected function validateSignature($algo = 'sha1')
    {
        return hash_equals($this->getSignature(), hash_hmac($algo, $this->getPayload(), $this->secret));
    }

    /**
     * @param bool $withAlgorithm
     * @return mixed
     */
    public function getSignature($withAlgorithm = false)
    {
        $signature = $this->request->header(self::HEADER_SIGNATURE);

        return $withAlgorithm ? $signature : substr($signature, strpos($signature, '=') + 1);
    }

    /**
     * @param bool $format
     * @return mixed
     */
    public function getPayload($format = false)
    {
        return $format ? $this->request->input() : $this->request->getContent();
    }

    /**
     * @param string $content
     * @param int $status
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($content = '', $status = 200, array $headers = [])
    {
        return response()->json(['message' => $content])->setStatusCode($status)->withHeaders($headers);
    }

    /**
     * @return bool
     */
    protected function isPingEvent()
    {
        return $this->getEvent() === 'ping';
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->request->header(self::HEADER_EVENT);
    }

    /**
     * @return mixed
     */
    public function getDelivery()
    {
        return $this->request->header(self::HEADER_DELIVERY);
    }
}