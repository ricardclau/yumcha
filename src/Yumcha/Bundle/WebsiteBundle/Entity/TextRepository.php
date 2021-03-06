<?php

namespace Yumcha\Bundle\WebsiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TextRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TextRepository extends EntityRepository
{
    /**
     * This method returns entities corresponding passed names in an array indexed by name
     *
     * @param array $names
     * @return array
     */
    public function getMultipleNames(array $names)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb->select('t')
            ->from('YumchaWebsiteBundle:Text', 't', 't.name')
            ->where('t.name IN (:names)')
            ->setParameter('names', $names)
        ;

        return $query->getQuery()->getResult();
    }
}
