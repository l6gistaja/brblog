<?php

namespace App\Repository;

use App\Entity\BlogComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogComment[]    findAll()
 * @method BlogComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogComment::class);
    }

	public function findUpdates($postId, $last) {
		$y = ['last' => -1, 'updates' => []];
		foreach($this->createQueryBuilder('b')
            ->andWhere('b.blogpost = :post and b.hidden = 0 and b.id > :last')
            ->setParameter('post', $postId)
			->setParameter('last', $last)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult() as $b) {
				$y['updates'][] = $b->getBody();
				if($b->getId() > $y['last']) { $y['last'] = $b->getId(); }
			}
        return count($y['updates']) ? $y : [];
	}
	
    // /**
    //  * @return BlogComment[] Returns an array of BlogComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogComment
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	
}
