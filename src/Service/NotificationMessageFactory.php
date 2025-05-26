<?php

namespace K3Progetti\MercureBridgeBundle\Service;

use K3Progetti\MercureBridgeBundle\Enum\NotificationOperation;
use K3Progetti\MercureBridgeBundle\Enum\NotificationType;
use DateTime;

class NotificationMessageFactory
{
    public static function create(
        NotificationType             $type,
        NotificationOperation|string $operation,
        array                        $userData = [],
        array                        $meta = []
    ): array
    {
        return [
            'type' => $type->value,
            'operation' => $operation,
            'user' => $userData,
            'meta' => array_merge([
                'timestamp' => (new DateTime())->format(DATE_ATOM),
            ], $meta),
        ];
    }
}
