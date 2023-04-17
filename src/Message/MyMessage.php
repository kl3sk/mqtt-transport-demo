<?php

namespace App\Message;

final class MyMessage {
    public function __construct(private readonly string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
