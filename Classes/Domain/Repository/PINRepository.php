<?php

namespace Homeinfo\Pinlogin\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PINRepository extends Repository
{
    public function findByPinAndPid(
        string $pin,
        int $pid
    ): QueryResultInterface {
        $queryParser = $this->objectManager->get(Typo3DbQueryParser::class);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $q = $query
            ->matching(
                $query->logicalAnd(
                    $query->equals('pin', $pin),
                    $query->equals('pid', $pid)
                )
            );
        $queryBuilder = $queryParser->convertQueryToDoctrineQueryBuilder($q);
        DebuggerUtility::var_dump($queryBuilder->getSQL());
        DebuggerUtility::var_dump($queryBuilder->getParameters());
        return $q->execute();
    }

    public function getUserById($uid) {
        // $query = $this->createQuery();
        // $query->getQuerySettings()->setRespectStoragePage(FALSE);
        // $query->statement(
        //     'SELECT * FROM fe_users WHERE uid = ?',
        //     [$uid]
        // );
        // $users = $query->execute();

        // if ($users->count() != 1) {
        //     return FALSE;
        // }

        $frontendUserRepository = GeneralUtility::makeInstance(FrontendUserRepository::class);
        return $frontendUserRepository->findByUid($uid);
        // return $users[0];
    }
}
