<?php

declare(strict_types=1);

namespace Montopolis\Slack\Tests\Domain;

use Montopolis\Slack\Application\MessageTransformer;
use Montopolis\Slack\Domain\Attachment;
use Montopolis\Slack\Domain\Message;
use Montopolis\Slack\Tests\TestCase;

class MessageTransformerTest extends TestCase
{
    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(MessageTransformer::class, new MessageTransformer());
    }

    public function test_it_transforms()
    {
        $t = new MessageTransformer();
        $m = new Message(['channel' => '?', 'text' => '']);
        $this->assertIsArray($t->toArray($m));
    }

    public function test_it_transforms_simple_message()
    {
        $t = new MessageTransformer();
        $input = ['channel' => '?', 'text' => ''];
        $m = new Message($input);
        $this->assertEquals($input, $t->toArray($m));
    }

    public function test_it_transforms_complex_message()
    {
        $t = new MessageTransformer();
        $input = [
            'channel' => '?',
            'text' => '',
            'attachments' => [
                [
                    'title' => '???',
                    'text' => '?????',
                ]
            ]
        ];
        $m = new Message($input);
        $output = $t->toArray($m);
        $this->assertEquals($input, $output);
    }

    public function test_it_transforms_more_complex_message()
    {
        $t = new MessageTransformer();
        $input = ['channel' => '___', 'text' => '!!!', 'attachments' => [
                new Attachment([
                    'title' => '111',
                    'text' => '111111',
                ]),
                new Attachment([
                    'title' => '222',
                    'text' => '222222',
                ]),
            ]
        ];
        $expected = [
            'channel' => '___', 'text' => '!!!', 'attachments' => [['title' => '111', 'text' => '111111'], ['title' => '222', 'text' => '222222']]
        ];
        $m = new Message($input);
        $output = $t->toArray($m);
        $this->assertEquals($expected, $output);
    }
}