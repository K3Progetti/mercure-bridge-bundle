#!/usr/bin/env php
<?php

$projectRoot = getcwd();
$bundlesFile = $projectRoot . '/config/bundles.php';
$bundleClass = 'K3Progetti\MercureBridgeBundle\MercureBridgeBundle::class';
$bundleLine = "    $bundleClass => ['all' => true],";

$routesFile = $projectRoot . '/config/routes.yaml';
$routesBlock = <<<YAML

mercure_bridge_bundle_routes:
  resource: '@MercureBridgeBundle/Controller/'
  type: attribute
YAML;

function green($text): string
{ return "\033[32m$text\033[0m"; }
function yellow($text): string
{ return "\033[33m$text\033[0m"; }
function red($text): string
{ return "\033[31m$text\033[0m"; }

echo yellow("🔍 File bundles: $bundlesFile\n");

if (!file_exists($bundlesFile)) {
    echo red("❌ File config/bundles.php non trovato.\n");
    exit(1);
}

$contents = file_get_contents($bundlesFile);
$argv = $_SERVER['argv'];
$remove = in_array('--remove', $argv, true);

if ($remove) {
    // Rimozione bundle
    if (strpos($contents, $bundleLine) !== false) {
        $contents = str_replace($bundleLine . "\n", '', $contents);
        $contents = str_replace($bundleLine, '', $contents); // fallback
        file_put_contents($bundlesFile, $contents);
        echo green("🗑️  MercureBridgeBundle rimosso da config/bundles.php\n");
    } else {
        echo yellow("ℹ️  MercureBridgeBundle non presente in config/bundles.php\n");
    }

    if (file_exists($routesFile)) {
        $routesContent = file_get_contents($routesFile);
        if (strpos($routesContent, $routesBlock) !== false) {
            $routesContent = str_replace($routesBlock, '', $routesContent);
            file_put_contents($routesFile, trim($routesContent) . "\n");
            echo green("🗑️  Blocco routes MercureBridgeBundle rimosso da config/routes.yaml\n");
        } else {
            echo yellow("ℹ️  Il blocco routes MercureBridgeBundle non era presente.\n");
        }
    }

} else {
    // Aggiungo bundle
    if (strpos($contents, $bundleClass) === false) {
        $pattern = '/(return\s+\[\n)(.*?)(\n\];)/s';
        if (preg_match($pattern, $contents, $matches)) {
            $before = $matches[1];
            $middle = rtrim($matches[2]);
            $after = $matches[3];

            $newMiddle = $middle . "\n" . $bundleLine;
            $newContents = $before . $newMiddle . $after;
            file_put_contents($bundlesFile, $newContents);
            echo green("✅ MercureBridgeBundle aggiunto in fondo a config/bundles.php\n");
        } else {
            echo red("❌ Errore durante l'inserimento in config/bundles.php\n");
        }
    } else {
        echo yellow("ℹ️  MercureBridgeBundle è già presente in config/bundles.php\n");
    }

    if (file_exists($routesFile)) {
        $routesContent = file_get_contents($routesFile);
        if (strpos($routesContent, $routesBlock) === false) {
            file_put_contents($routesFile, trim($routesContent) . "\n" . $routesBlock . "\n");
            echo green("✅ Blocco routes MercureBridgeBundle aggiunto in config/routes.yaml\n");
        } else {
            echo yellow("ℹ️  Il blocco routes MercureBridgeBundle è già presente in config/routes.yaml\n");
        }
    } else {
        echo red("❌ File config/routes.yaml non trovato.\n");
    }

    // ➕ Aggiungo variabili .env se mancanti
    $envFile = $projectRoot . '/.env';
    $envVars = [
        'MERCURE_TOPIC' => ''
    ];

    if (file_exists($envFile)) {
        $envContent = file_get_contents($envFile);
        $newLines = [];

        foreach ($envVars as $key => $value) {
            if (!preg_match("/^$key=/m", $envContent)) {
                $newLines[] = "$key=$value";
                echo green("➕ Variabile $key aggiunta al file .env\n");
            } else {
                echo yellow("ℹ️  Variabile $key già presente in .env\n");
            }
        }

        if (!empty($newLines)) {
            file_put_contents($envFile, "\n# Start - Mercure Bridge \n" . implode("\n", $newLines) . "\n", FILE_APPEND);
        }
    } else {
        echo yellow("⚠️  File .env non trovato. Nessuna variabile aggiunta.\n");
    }
}
