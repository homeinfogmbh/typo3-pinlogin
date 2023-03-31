<?php

namespace Homeinfo\Pinlogin\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class PINRepository extends Repository
{
    public function findByPinAndPid(
        string $pin,
        int $pid
    ): QueryResultInterface
    {
        $query = $this->getStorageIndependentQuery();
        return $query
            ->matching(
                $query->logicalAnd(
                    $query->equals('pin', $pin),
                    $query->equals('pid', $pid)
                )
            )
            ->execute();
    }

    private function getStorageIndependentQuery()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query;
    }
}
