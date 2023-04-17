<?php

namespace App\MessageHandler\Serializer;

use App\Message\MyMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class JsonMessageSerializer implements SerializerInterface {
    public function decode(array $encodedEnvelope): Envelope
    {
        $body    = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];
        $data    = json_decode($body, true);
        $message = new MyMessage($data['content']);

        // in case of redelivery, unserialize any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }

        return new Envelope($message, $stamps);
    }

    public function encode(Envelope $envelope): array
    {
        // dd($envelope);
        // this is called if a message is redelivered for "retry"
        $message = $envelope->getMessage();
        // expand this logic later if you handle more than
        // just one message class
        if ($message instanceof MyMessage) {
            // recreate what the data originally looked like
            $data = ['content' => $message->getContent()];
        } else {
            throw new \Exception('Unsupported message class');
        }
        $allStamps = [];
        foreach ($envelope->all() as $stamps) {
            $allStamps = array_merge($allStamps, $stamps);
        }

        return [
            'body'    => json_encode($data),
            'headers' => [
                // store stamps as a header - to be read in decode()
                'stamps' => serialize($allStamps),
            ],
        ];
    }
}