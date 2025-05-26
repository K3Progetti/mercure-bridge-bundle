<?php

namespace K3Progetti\MercureBridgeBundle\Service;

use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

/**
 * Invio notifica
 *
 * @author Mattia Vitali <mattia.vitali@gmail.com>
 */
readonly class SendNotification
{


    public function __construct(
        private HubInterface          $hub,
        private ParameterBagInterface $parameterBag,
    )
    {

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

            $mercureTopic = $this->parameterBag->get('mercureTopic');
            if (empty($mercureTopic) && $topic === null) {
                throw new RuntimeException('Mercure topic not configured');
            }

            $update = new Update(
                $topic ?? $mercureTopic,
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
