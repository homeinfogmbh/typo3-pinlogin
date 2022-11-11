<?php

namespace Homeinfo\Pinlogin\Controller;

use Psr\Http\Message\ResponseInterface;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
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
        $_POST['logintype'] = 'login';
        $_POST['user'] = 'foo';
        $_POST['pass'] = 'bar';
        $service = GeneralUtility::makeInstance(FrontendUserAuthentication::class);
        DebuggerUtility::var_dump($service, "Service:");
        $started = $service->start();
        DebuggerUtility::var_dump($started, "Start returned:");
        $user = NULL;
        //$user = $service->getUser();
        // $_POST['user'] = $user->getEmail();
        // $_POST['pass'] = $user->getPassword();
    
        if ($user) {
            $this->view->assign('user', $user);
        }
    }
}