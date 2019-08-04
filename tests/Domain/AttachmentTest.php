<?php

declare(strict_types=1);

namespace Montopolis\Slack\Tests\Domain;

use Montopolis\Slack\Domain\Attachment;
use Montopolis\Slack\Tests\TestCase;

class AttachmentTest extends TestCase
{
    public function test_it_is_instantiable()
    {
        $this->assertInstanceOf(Attachment::class, new Attachment([]));
    }
}