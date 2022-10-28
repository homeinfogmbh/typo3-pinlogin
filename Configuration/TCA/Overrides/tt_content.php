<?php
if (!defined('TYPO3_MODE')) { die('Access denied.'); }

$extensionKey = 'pinlogin';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Pinlogin',
    'Pinlogin',
    'Pinlogin',
    'EXT:'.$extensionKey.'/Resources/Public/Icons/Extension.svg'
);
?>