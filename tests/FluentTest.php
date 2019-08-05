<?php

declare(strict_types=1);

namespace Montopolis\Slack\Tests;

use Montopolis\Slack\Domain\Message;
use Montopolis\Slack\Domain\SlackClient;
use Montopolis\Slack\Fluent;
use PHPUnit\Framework\MockObject\MockObject;

class FluentTest extends TestCase
{
    /** @var MockObject */
    protected $clientMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->clientMock = $this->createMock(SlackClient::class);
    }

    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(Fluent::class, new Fluent($this->clientMock));
    }

    public function test_it_allows_creation_of_basic_slack_message()
    {
        $fluent = new Fluent($this->clientMock);

        $this->clientMock->expects($this->once())
            ->method('sendMessage')
            ->with(new Message(['channel' => 'testing', 'text' => 'This is a test message']));

        $fluent->channel('testing')
            ->text('This is a test message')
            ->send();
    }

    public function test_it_allows_token_to_be_overridden()
    {
        $fluent = new Fluent($this->clientMock);

        $this->clientMock->expects($this->once())
            ->method('sendMessage')
            ->with(new Message(['channel' => 'testing', 'text' => 'This is a test message', 'token' => 'abcdefg']));

        $fluent->channel('testing')
            ->text('This is a test message')
            ->token('abcdefg')
            ->send();
    }
}