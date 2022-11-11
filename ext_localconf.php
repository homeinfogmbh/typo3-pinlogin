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
    'pinlogin',
    'auth',
    \Homeinfo\Pinlogin\Service\AuthenticationService::class,
    [
        'title' => 'Front-end user PIN authentication service',
        'description' => 'Log in front-end users via PINs.',

        'subtype' => 'authUserFE, getUserFE',

        'available' => true,
        'priority' => 100,
        'quality' => 100,
        'os' => 'Any',
        'exec' => '',

        'className' => 'Homeinfo\\Pinlogin\\Service\\AuthenticationService',
    ]
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['frontend']['loginProviders'][1433416020] = [
    'provider' => \Homeinfo\Pinlogin\PINLoginProvider::class,
    'sorting' => 50,
    'icon-class' => 'fa-key',
    'label' => 'LLL:EXT:pinlogin/Resources/Private/Language/locallang.xlf:login.pin'
];