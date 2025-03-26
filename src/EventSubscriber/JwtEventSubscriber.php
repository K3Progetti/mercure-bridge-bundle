<?php

namespace App\Bundle\MercureBridge\EventSubscriber;

use App\Bundle\Jwt\Event\JwtUserLoggedOutEvent;
use App\Bundle\MercureBridge\Enum\NotificationType;
use App\Bundle\MercureBridge\Service\NotificationMessageFactory;
use App\Bundle\MercureBridge\Service\SendNotification;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JwtEventSubscriber implements EventSubscriberInterface
{
    private SendNotification $sendNotification;
    private ParameterBagInterface $params;

    public function __construct(
        SendNotification      $sendNotification,
        ParameterBagInterface $params,
    )
    {
        $this->sendNotification = $sendNotification;
        $this->params = $params;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            JwtUserLoggedOutEvent::class => 'onUserLogout',
        ];
    }

    /**
     * @param JwtUserLoggedOutEvent $event
     * @return void
     */
    public function onUserLogout(JwtUserLoggedOutEvent $event): void
    {
        if ($this->params->get('mercureEnabled')) {
            $payload = NotificationMessageFactory::create(
                NotificationType::AuthEvent,
                'logout',
                ['id' => $event->userId]
            );

            $this->sendNotification->send($payload);
        }
    }
}