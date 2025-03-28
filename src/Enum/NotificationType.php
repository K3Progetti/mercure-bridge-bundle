<?php

namespace K3Progetti\MercureBridgeBundle\Enum;

enum NotificationType: string
{
    case AuthEvent = 'auth_event';
    case UserEvent = 'user_event';
    case SessionEvent = 'session_event';
    case SystemEvent = 'system_event';
    case CommandEvent = 'command_event';
    case ProgressEvent = 'progress_event';
    case StatusUpdate = 'status_update';
}
