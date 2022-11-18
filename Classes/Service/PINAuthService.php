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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use Homeinfo\Pinlogin\Domain\Repository\PINRepository;

final class PINAuthService extends AbstractAuthenticationService
{    
    final public function authUser(array $user)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($user, "Authenticating user:");
    
        if (!$this->isResponsible()) {
            return AuthenticationStatus::FAIL_CONTINUE;
        }

        if (TYPO3_MODE !== "FE") {
            return AuthenticationStatus::FAIL_CONTINUE;
        }

        if ($user && !$user->empty()) {
            return AuthenticationStatus::FAIL_CONTINUE;
        }

        return AuthenticationStatus::SUCCESS_BREAK;
    }

    final public function getUser()
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump("Getting user:");

        if (!$this->isResponsible()) {
            return FALSE;
        }

        $pin = GeneralUtility::_POST('pin');

        if (strlen($pin) != 4) {
            return FALSE;
        }

        $pin_entries = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(PINRepository::class)
            ->findByPinAndPid($pin, $GLOBALS['TSFE']->id);

        if ($pin_entries->count() < 1) {
            return FALSE;
        }

        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump("Query result:", typeof($pin_entries));
        $entry = $pin_entries[0];
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump("PIN Entry:", $entry);
        
        $qb = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->db_user['table']);
        $where_clause = $qb->expr()->andX(
            $qb->expr()->eq('uid', $qb->expr()->literal($entry->feuserId))
        );

        // Typo3 v10 API will change here!
        $user = $this->fetchUserRecord('', $where_clause);
        if(!is_array($user)) {
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump("User login failed.");
            return FALSE;
        } 

        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($user, "User record:");
        $this->logger->info('Successful token found', ['id'=>$user['uid'], 'username'=>$user['username'], 'token'=>$this->login['uname']]);
        return $user;
    }

    private function isResponsible(): bool {
        return GeneralUtility::_POST("login-provider") === "pinauthentication";
    }
}
