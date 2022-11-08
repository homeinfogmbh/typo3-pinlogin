<?php

namespace Homeinfo\Pinlogin\Domain\Repository;

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
        return $this->getStorageIndependentQuery()
            ->matching(
                $query->logicalAnd(
                    $query->equals('pin', $pin),
                    $query->equals('pid', $pid)
                )
            )
            ->execute();
    }

    private function getStorageIndependentQuery() {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query;
    }
}
