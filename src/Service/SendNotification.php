<?php

namespace App\Bundle\MercureBridge\Service;

use RuntimeException;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

/**
 * Invio notifica
 *
 * @author Mattia Vitali <mattia.vitali@gmail.com>
 */
class SendNotification
{

    private HubInterface $hub;
    private string $defaultTopic;

    public function __construct(HubInterface $hub, ?string $defaultTopic = 'crmLorini')
    {
        $this->hub = $hub;
        $this->defaultTopic = $defaultTopic;
    }


    /**
     * @param array $data
     * @param string|null $topic
     * @param bool $isPrivate
     * @return bool
     */
    public function send(array $data, ?string $topic = null, bool $isPrivate = true): bool
    {

        try {
            $update = new Update(
                $topic ?? $this->defaultTopic,
                json_encode($data),
                $isPrivate
            );

            $this->hub->publish($update);
        } catch (RuntimeException $exception) {
            return false;
        }

        return true;
    }

}
