<?php

namespace Homeinfo\Pinlogin;

use TYPO3\CMS\Backend\Controller\LoginController;
use TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PINLoginProvider implements LoginProviderInterface
{
    public function render(StandaloneView $view, PageRenderer $pageRenderer, LoginController $loginController)
    {
        /**
         * @var $feuser FrontendUserAuthentication
         */
        $feuser = $GLOBALS["FE_USER"];
        $_POST["uident"] = rand();
        $feuser->start();

        //$pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/UserPassLogin');

        $view->setTemplatePathAndFilename(
            GeneralUtility::getFileAbsFileName(
                'EXT:pinlogin/Resources/Private/Templates/login.html'
            )
        );

        $view->assign('enablePasswordReset', false);
    }
}
