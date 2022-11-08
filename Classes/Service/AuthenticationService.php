<?php
/**
 * Copyright (C) 2022  HOMEINFO - Digitale Informationssysteme GmbH
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Homeinfo\Pinlogin\Service;

use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use Homeinfo\Pinlogin\Domain\Repository\CustomFrontendUserRepository;
use Homeinfo\Pinlogin\Domain\Repository\PINRepository;

final class AuthenticationService extends AbstractAuthenticationService
{    
    use LoggerAwareTrait;

    private $pin_repository;
    private $feuser_repository;

    final public function getUser()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->pin_repository = $objectManager->get(PINRepository::class);
        $this->feuser_repository = $objectManager->get(CustomFrontendUserRepository::class);

        if (!$this->isResponsible()) {
            return -1;
        }

        $pin = \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('pin');
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($pin);

        if (strlen($pin) != 4) {
            return -2;
        }

        $pageUid = $GLOBALS['TSFE']->id;
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($pageUid);
        $all_entries = $this->pin_repository->findAll();
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($all_entries);
        $pin_entries = $this->pin_repository->findByPinAndPid($pin, $pageUid);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($pin_entries);

        if ($pin_entries->count() < 1) {
            return -3;
        }

        return $this->getUserById($pin_entries[0]->feuserId);
    }

    private function isResponsible(): bool
    {
        return GeneralUtility::_POST("login-provider") === "pinauthentication";
    }

    private function getUserById($uid) {
        return $query->statement(
            'SELECT * FROM fe_users WHERE uid = ?',
            [$uid]
        ).execute();
    }
}
