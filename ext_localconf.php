<?php
defined('TYPO3_MODE') || die();

$extensionKey = 'pinlogin';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pinlogin',
    'Pinlogin',
    [
        \Homeinfo\Pinlogin\Controller\PinloginController::class => 'start,login'
    ],
);