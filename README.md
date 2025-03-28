# MercureBridgeBundle

Bundle Symfony per gestire notifiche in tempo reale tramite [Mercure](https://mercure.rocks/).

## 📦 Installazione

Se usi questo bundle come pacchetto locale:

```bash
composer require k3progetti/mercure-bridge-bundle
```

## ⚙️ Configurazione

Nel tuo `config/bundles.php` aggiungi:

```php
return [
    App\Bundle\MercureBridge\MercureBridgeBundle::class => ['all' => true],
];
```

## 🛠️ Servizi inclusi

- `SendNotification`: servizio per inviare notifiche Mercure
- `NotificationMessageFactory`: helper per creare il payload del messaggio
- `JwtEventSubscriber`: listener che intercetta eventi JWT e invia aggiornamenti

## 📂 Struttura del bundle

```
MercureBridge/
├── composer.json
├── README.md
├── src/
│   ├── MercureBridgeBundle.php
│   ├── Enum/
│   ├── EventSubscriber/
│   ├── Service/
│   └── DependencyInjection/
│       ├── Configuration.php
│       └── MercureBridgeExtension.php
│   └── Resources/config/services.yaml
```

## 🧪 Requisiti

- PHP >= 8.2
- Symfony >= 7.0
- `symfony/mercure-bundle`

## 🔧 Registrazione automatica dei servizi

Nel bundle è già presente un file `services.yaml` che carica tutti i servizi con:

```yaml
services:
    App\Bundle\MercureBridge\:
        resource: '../../src/*'
        exclude:
            - '../../src/DependencyInjection/'
            - '../../src/MercureBridgeBundle.php'
        autowire: true
        autoconfigure: true
        public: false
```

## 📥 Contribuire

Sentitevi liberi di proporre migliorie
