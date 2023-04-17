<?php

namespace App\MessageHandler;

use App\Entity\MqttMessage;
use App\Message\MyMessage;
use App\Repository\MqttMessageRepository;
use Kl3sk\MqttTransportBundle\Mqtt\MqttMessageInterface;
use Monolog\Level;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'mqtt')]
final class MyMessageHandler {

    public function __construct(private readonly MqttMessageRepository $messageRepository, private readonly ?LoggerInterface $logger = null) { }

    public function __invoke(MqttMessageInterface $message): string
    {
        $_message = new MqttMessage();
        $_message->setContent($message->getContent());
        $_message->setTopic($message->getTopic());
        $_message->setReceivedAt(new \DateTimeImmutable());

        $this->messageRepository->save($_message, true);

        $this->logger?->log(Level::Info, '--------------------------------');
        $this->logger?->log(Level::Info, '--------- Bundle Handled -------');
        $this->logger?->log(Level::Info, '--------- '.$message->getContent().' -------');
        $this->logger?->log(Level::Info, '--------------------------------');

        return $message->getContent();
    }
}
