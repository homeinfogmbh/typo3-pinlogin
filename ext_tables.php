<?php
defined('TYPO3_MODE') || die();

// allow table entries to be added to normal pages
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pinlogin_domain_model_pin');