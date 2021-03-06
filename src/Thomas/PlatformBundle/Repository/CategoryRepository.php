<?php

namespace Thomas\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;


/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLikeQueryBuilder($pattern)
    {
        return $this
        ->createQueryBuilder('c')
        ->where('c.name LIKE :pattern')
        ->setParameter('pattern', $pattern)
        ;
    }
}
