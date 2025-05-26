<?php

namespace K3Progetti\MercureBridgeBundle\Enum;

enum NotificationOperation: string
{
    case DownloadReady = 'download_ready';
    case DownloadStarted = 'download_started';
    case DownloadCompleted = 'download_completed';
    case DownloadFailed = 'download_failed';
    case DownloadProgress = 'download_progress';

    // Potresti anche usare metodi helper
    public function description(): string
    {
        return match($this) {
            self::DownloadReady => 'Il file è pronto per il download',
            self::DownloadStarted => 'Comando avviato',
            self::DownloadCompleted => 'Comando completato con successo',
            self::DownloadFailed => 'Comando fallito',
            self::DownloadProgress => 'Download in elaborazione',
        };
    }
}
