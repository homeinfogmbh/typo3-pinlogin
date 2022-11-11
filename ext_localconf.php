<?php
defined('TYPO3_MODE') || die();

$extensionKey = 'pinlogin';

// \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
//     'Pinlogin',
//     'Pinlogin',
//     [
//         \Homeinfo\Pinlogin\Controller\PinloginController::class => 'start,login'
//     ],
// );

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $extname,
    'auth',
    \Homeinfo\Pinlogin\Service\AuthenticationService::class,
    [
        'title' => 'Front-end user PIN authentication service',
        'description' => 'Log in front-end users via PINs.',

        'subtype' => 'authUserFE, getUserFE',

        'available' => true,
        'priority' => 100,
        'quality' => 100,
        'os' => '*',

        'className' => 'Homeinfo\\Pinlogin\\Service\\AuthenticationService',
    ]
);