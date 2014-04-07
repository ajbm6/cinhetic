<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class MoviesRepository
 * @package Cinhetic\PublicBundle\Repository
 */
class MoviesRepository extends EntityRepository
{

    /**
     * Search all movies by criteria
     * @param null $word
     * @return array
     */
    public function search($word = null){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM CinheticPublicBundle:Movies p
                JOIN p.category ca
                JOIN p.tags ta
                JOIN p.cinemas ci
                JOIN p.directors di
                JOIN p.actors ac

                WHERE (p.title LIKE :article
                OR ca.title LIKE :category
                OR ta.word LIKE :tag
                OR ci.title LIKE :cinema
                OR di.firstname LIKE :difirstname
                OR di.lastname LIKE :dilastname
                OR ac.firstname LIKE :acfirstname
                OR ac.lastname LIKE :aclastname)
                AND p.visible = 1
                ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'article' => "%".$word."%",
                'category' => "%".$word."%",
                'tag' => "%".$word."%",
                'cinema' => "%".$word."%",
                'difirstname' => "%".$word."%",
                'dilastname' => "%".$word."%",
                'acfirstname' => "%".$word."%",
                'aclastname' => "%".$word."%",
            ));

            return $query->getResult();
    }

    /**
     * Get Current movies by criteria
     * @param null $word
     * @return array
     */
    public function getCurrentMovies($limit = 3){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.dateRelease >= :current
                    AND p.visible = 1
                    ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'current' => new \Datetime('midnight'),
            ));

            return $query->setMaxResults($limit)->getResult();
    }

    /**
     * Get Current movies by criteria
     * @param null $word
     * @return array
     */
    public function getCoverMovies($limit = 5){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT m
                    FROM CinheticPublicBundle:Medias m
                    JOIN m.movies mo
                    WHERE mo.dateRelease >= :current
                    AND mo.visible = 1
                    AND mo.cover = 1
                    ORDER BY mo.id DESC'
            )
            ->setParameters(
            array(
                'current' => new \Datetime('midnight'),
            ));

            return $query->setMaxResults($limit)->getResult();
    }


    /**
     * Get  movies more scored
     * @param null $word
     * @return array
     */
    public function getStarMovies($limit = 3){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.visible = 1
                    ORDER BY p.notePresse DESC'
            );

            return $query->setMaxResults($limit)->getResult();
    }


}