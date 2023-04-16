<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Enregistre l'entité et, éventuellement, flush les changements dans la base de données.
     *
     * @param Post $entity L'entité a enregistré
     * @param bool $flush Indique si les changements doivent être flush dans la base de données (par défaut: false).
     */
    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprime l'entité et, éventuellement, flush les changements dans la base de données.
     *
     * @param Post $entity L'entité a supprimé
     * @param bool $flush Indique si les changements doivent être flush dans la base de données (par défaut: false).
     */
    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Trouve tous les articles avec les images associées.
     *
     * @return Post[] Un tableau d'entités Post.
     */
    public function findAllWithImages(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p, m
            FROM App\Entity\Post p
            LEFT JOIN p.image m'
        );

        return $query->getResult();
    }

    /**
     * Trouve tous les articles avec les commentaires associés limités par la limite spécifiée.
     *
     * @return Post[] Un tableau d'entités Post.
     */
    public function findCommentByLimit(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p, c
            FROM App\Entity\Post p
            LEFT JOIN p.comments c'
        );

        return $query->getResult();
    }
}
