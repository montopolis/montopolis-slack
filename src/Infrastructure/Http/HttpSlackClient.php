<?php

declare(strict_types=1);

namespace Montopolis\Slack\Infrastructure\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Montopolis\Slack\Application\MessageTransformer;
use Montopolis\Slack\Domain\Message;
use Montopolis\Slack\Domain\SlackClient;
use Montopolis\Slack\Domain\SlackCredentialsRepository;

class HttpSlackClient implements SlackClient
{
    protected $credentialsRepository;
    protected $transformer;

    public function __construct(SlackCredentialsRepository $credentialsRepository, MessageTransformer $transformer)
    {
        $this->credentialsRepository = $credentialsRepository;
        $this->transformer = $transformer;
    }

    public function sendMessage(Message $message): bool
    {
        # @todo: handle response failures
        $credential = $this->credentialsRepository->getCredentials();
        return !! $this->sendApiRequest($credential->getToken(), $this->transformer->toArray($message));
    }

    protected function sendApiRequest($token, $payload)
    {
        $client = new Client([
            'base_uri' => 'https://slack.com/api/',
        ]);

        try {
            $response = $client->post('chat.postMessage', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
                'json' => $payload,
            ]);

        } catch (RequestException $ex) {

            throw $ex;
        }
    }
}