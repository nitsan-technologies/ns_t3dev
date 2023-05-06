<?php

namespace NITSAN\NsT3dev\Domain\Repository;

class FrontendUserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    public function findByUserId($uid){
        $query = $this->createQuery();
        $constraints = [];
        $constraints[] = $query->equals('uid', $uid);
        $query->getQuerySettings()->setRespectStoragePage(false);
        foreach ($constraints as $value) {
			$query->matching($query->logicalAnd($value));
		}
        return $query->execute();
    }

}
