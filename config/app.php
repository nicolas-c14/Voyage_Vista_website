<?php

$documentRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/'));
$projectRoot = str_replace('\\', '/', dirname(__DIR__));
$appUrl = str_replace($documentRoot, '', $projectRoot);

if ($appUrl === '') {
    $appUrl = '/VoyageVista';
}

define('APP_URL', rtrim($appUrl, '/'));
