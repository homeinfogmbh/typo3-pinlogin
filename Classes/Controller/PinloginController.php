<?php

namespace Homeinfo\Pinlogin\Controller;

use Psr\Http\Message\ResponseInterface;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use Homeinfo\Pinlogin\Service\AuthenticationService;

class PinloginController extends ActionController
{
    protected Context $context;
    
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }


    public function startAction()
    {
    }

    public function loginAction()
    {
        $_POST['logintype'] = 'login';
        $_POST['login-provider'] = 'pinauthentication';
        $authService = GeneralUtility::makeInstance(AuthenticationService::class);
        $user = $authService->getUser();
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($user);
    }
}