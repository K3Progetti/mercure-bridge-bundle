#!/usr/bin/env php
<?php

$bundlesFile = __DIR__ . '/../config/bundles.php';
$bundleClass = "App\\Bundle\\MercureBridge\\MercureBridgeBundle::class";
$bundleLine = "    $bundleClass => ['all' => true],";

if (!file_exists($bundlesFile)) {
    echo "❌ File config/bundles.php non trovato.\n";
    exit(1);
}

$contents = file_get_contents($bundlesFile);
$argv = $_SERVER['argv'];
$remove = in_array('--remove', $argv, true);

if ($remove) {
    if (strpos($contents, $bundleLine) !== false) {
        $contents = str_replace($bundleLine . "\n", '', $contents);
        $contents = str_replace($bundleLine, '', $contents); // fallback
        file_put_contents($bundlesFile, $contents);
        echo "🗑️  MercureBridgeBundle rimosso da config/bundles.php\n";
    } else {
        echo "ℹ️  MercureBridgeBundle non presente in config/bundles.php\n";
    }
} else {
    if (strpos($contents, $bundleClass) === false) {
        $pattern = '/return\s+\[(.*?)(\];)/s';
        $replacement = "return [\n    $bundleClass => ['all' => true],\n$1$2";
        $newContents = preg_replace($pattern, $replacement, $contents, 1);
        file_put_contents($bundlesFile, $newContents);
        echo "✅ MercureBridgeBundle registrato in config/bundles.php\n";
    } else {
        echo "ℹ️  MercureBridgeBundle è già presente in config/bundles.php\n";
    }
}