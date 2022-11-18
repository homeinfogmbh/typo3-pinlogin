<?php

namespace Homeinfo\Pinlogin\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class PinloginController extends ActionController
{
    public function startAction()
    {
        $this->view->assign('pageId', $GLOBALS['TSFE']->id);
    }

    public function loginAction()
    {
    }
}