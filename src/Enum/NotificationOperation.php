<?php

namespace K3Progetti\MercureBridgeBundle\Enum;

enum NotificationOperation: string
{
    case DownloadReady = 'download_ready';
    case CommandStarted = 'command_started';
    case CommandCompleted = 'command_completed';
    case CommandFailed = 'command_failed';

    // Potresti anche usare metodi helper
    public function description(): string
    {
        return match($this) {
            self::DownloadReady => 'Il file è pronto per il download',
            self::CommandStarted => 'Comando avviato',
            self::CommandCompleted => 'Comando completato con successo',
            self::CommandFailed => 'Comando fallito',
        };
    }
}
