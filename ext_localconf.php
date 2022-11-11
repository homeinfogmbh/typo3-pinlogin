<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pinlogin',
    'Pinlogin',
    [
        \Homeinfo\Pinlogin\Controller\PinloginController::class => 'start,login'
    ],
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'Pinlogin',
    'auth',
    'Pinlogin',
    [
        'title' => 'Front-end user PIN authentication service',
        'description' => 'Log in front-end users via PINs.',

        'subtype' => 'authUserFE, getUserFE',

        'available' => true,
        'priority' => 100,
        'quality' => 100,
        'os' => 'Any',
        'exec' => NULL,

        'className' => \Homeinfo\Pinlogin\Service\AuthenticationService::class,
    ]
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['frontend']['loginProviders'][1433416020] = [
    'provider' => \Homeinfo\Pinlogin\PINLoginProvider::class,
    'sorting' => 50,
    'icon-class' => 'fa-key',
    'label' => 'LLL:EXT:pinlogin/Resources/Private/Language/locallang.xlf:login.pin'
];