<?php

namespace Homeinfo\Pinlogin\Domain\Repository;

use TYPO3\CMS\FrontendLogin\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class CustomFrontendUserRepository extends FrontendUserRepository
{
    public function findByUid(int $uid): QueryResultInterface {
        $queryParser = $this->objectManager->get(Typo3DbQueryParser::class);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $q = $query
            ->matching(
                $query->equals('uid', $uid)
            );
        $queryBuilder = $queryParser->convertQueryToDoctrineQueryBuilder($q);
        DebuggerUtility::var_dump($queryBuilder->getSQL());
        DebuggerUtility::var_dump($queryBuilder->getParameters());
        return $q->execute();
    }
}