<?php

namespace App\Controller;

use App\Repository\MqttMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/', name: 'app_message')]
    public function index(MqttMessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();

        return $this->render('message/index.html.twig', [
            'messages' => $messages
        ]);
    }
}
