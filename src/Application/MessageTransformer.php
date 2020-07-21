<?php

declare(strict_types=1);

namespace Montopolis\Slack\Application;

use Montopolis\Slack\Domain\Message;

class MessageTransformer
{
    public function toArray(Message $message): array
    {
        $array = $message->getAttributes();

        if (isset($array['attachments'])) {
            $array['attachments'] = $this->attributeToArray($array['attachments']);
        }

        if (isset($array['blocks'])) {
            $array['blocks'] = $this->attributeToArray($array['blocks']);
        }

        return $array;
    }

    protected function attributeToArray($attrs): array
    {
        $array = [];
        foreach ($attrs as $element) {
            $array[] = is_array($element) ? $element : $element->getAttributes();
        }

        return $array;
    }
}
