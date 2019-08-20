<?php

declare(strict_types=1);

namespace Montopolis\Slack\Infrastructure;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Montopolis\Slack\Application\MessageTransformer;
use Montopolis\Slack\Domain\Message;
use Montopolis\Slack\Domain\SlackClient;
use Montopolis\Slack\Domain\SlackConfigurationRepository;

class HttpSlackClient implements SlackClient
{
    protected $configurationRepository;
    protected $transformer;

    const BASE_URI = 'https://slack.com/api/';

    public function __construct(SlackConfigurationRepository $configurationRepository, MessageTransformer $transformer)
    {
        $this->configurationRepository = $configurationRepository;
        $this->transformer = $transformer;
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function sendMessage(Message $message): bool
    {
        $token = $this->configurationRepository->getCredentials()->getToken();

        $payload = $this->transformer->toArray($message);

        $defaultChannel = $this->getDefaultChannel();

        if (empty($payload['channel'])) {
            $payload['channel'] = $defaultChannel;
        }

        $response = $this->sendApiRequest($token, $payload);

        ###
        # If there's a "channel not found" error we can fallback to the default channel:
        if ($this->isChannelNotFound($response) && !$this->isDefaultChannel($payload['channel'])) {
            if ($this->configurationRepository->getFallbackToDefault()) {
                $payload['channel'] = $defaultChannel;
                $response = $this->sendApiRequest($token, $payload);
            }
        }

        return $this->isResponseOk($response);
    }

    protected function isResponseOk($response): bool
    {
        return !empty($response) && !empty($response->ok);
    }

    protected function isChannelNotFound($response): bool
    {
        return !empty($response->error) && $response->error === 'channel_not_found';
    }

    protected function isDefaultChannel($channel): bool
    {
        return $this->getDefaultChannel() === $channel;
    }

    protected function getDefaultChannel(): string
    {
        return $this->configurationRepository->getDefaultChannel();
    }

    /**
     * @param string $token
     * @param array $payload
     * @return \stdClass
     */
    protected function sendApiRequest(string $token, array $payload): \stdClass
    {
        $client = new Client(['base_uri' => self::BASE_URI]);

        $uri = 'chat.postMessage';

        try {

            $headers = ['Authorization' => "Bearer {$token}"];

            $response = $client->post($uri, [
                'headers' => $headers,
                'json' => $payload,
            ]);

            return json_decode(''.$response->getBody()->getContents());

        } catch (RequestException $ex) {

            throw $ex;
        }
    }
}