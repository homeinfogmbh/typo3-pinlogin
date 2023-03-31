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

use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use Homeinfo\Pinlogin\Domain\Repository\PINRepository;

final class PINAuthService extends AbstractAuthenticationService
{    
    final public function authUser(array $user)
    {    
        if (!$this->isResponsible()) {
            return 100;
        }

        if (TYPO3_MODE !== "FE") {
            return 100;
        }

        return 200;
    }

    final public function getUser()
    {
        if (!$this->isResponsible()) {
            return false;
        }

        $pin = GeneralUtility::_GP('user');

        if (strlen($pin) != 4)
            return false;

        $pin_entries = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(PINRepository::class)
            ->findByPinAndPid($pin, intval(GeneralUtility::_GP('pageId')));

        if ($pin_entries->count() < 1)
            return false;

        $entry = $pin_entries->getFirst();
        $this->db_user['check_pid_clause'] = '';  
        $user = $this->fetchUserRecord('', 'uid = ' . $entry->feuserId);

        if(!is_array($user))
            return false;

        return $user;
    }

    private function isResponsible(): bool
    {
        return GeneralUtility::_GP("login-provider") === "pinauthentication";
    }
}
