<?php

namespace App\Bundle\MercureBridge\Service;

use App\Bundle\MercureBridge\Enum\NotificationType;

class NotificationMessageFactory
{
    public static function create(
        NotificationType $type,
        string $operation,
        array $userData = [],
        array $meta = []
    ): array {
        return [
            'type' => $type->value,
            'operation' => $operation,
            'user' => $userData,
            'meta' => array_merge([
                'timestamp' => (new \DateTime())->format(DATE_ATOM),
            ], $meta),
        ];
    }
}
