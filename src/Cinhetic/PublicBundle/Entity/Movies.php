<?php

namespace Cinhetic\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Movies
 *
 * @ORM\Table(name="movies")
 * @ORM\Entity(repositoryClass="Cinhetic\PublicBundle\Repository\MoviesRepository")
 * @UniqueEntity(fields="title", message="Le titre est deja pris!")
 */
class Movies
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="type_film", type="string", length=250, nullable=true)
     */
    private $typeFilm;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=250, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "10",
     *      max = "150",
     *      minMessage = "Votre synopsis doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre synopsis ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="synopsis", type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "20",
     *      max = "1050",
     *      minMessage = "Votre description doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre description ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @Assert\Length(
     *      min = "10",
     *      max = "5050",
     *      minMessage = "Votre trailer doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre trailer ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="trailer", type="text", nullable=true)
     */
    private $trailer;

    /**
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="movies")
     * @ORM\JoinColumn(name="categories_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var integer
     * @ORM\Column(name="languages", type="string", length=250, nullable=true)
     */
    private $languages;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="distributeur", type="string", length=250, nullable=true)
     */
    private $distributeur;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="bo", type="string", length=250, nullable=true)
     */
    private $bo;

    /**
     * @var integer
     * @Assert\Range(
     *      min = 1930,
     *      max = 2016,
     *      minMessage = "Le minimum d'année est de 1930",
     *      maxMessage = "Le maximum d'année est de 2016"
     * )
     * @ORM\Column(name="annee", type="integer", nullable=true)
     */
    private $annee;

    /**
     * @var float
     * @Assert\Range(
     *      min = 1000,
     *      max = 10000000,
     *      minMessage = "Le minimum de budget est de 1000",
     *      maxMessage = "Le maximum de budget est de 10000000"
     * )
     * @ORM\Column(name="budget", type="float", precision=10, scale=0, nullable=true)
     */
    private $budget;

    /**
     * @var integer
     * @Assert\Range(
     *      min = 0.5,
     *      max = 5,
     *      minMessage = "Le minimum d'heure est est de 30min.",
     *      maxMessage = "Le maximum d'heure est de 5h"
     * )
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_release", type="date", nullable=true)
     */
    private $dateRelease;

    /**
     * @var float
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Le minimum de note de presse est est de 1 étoile",
     *      maxMessage = "Le maximum de note de presse est est de 5 étoiles"
     * )
     * @ORM\Column(name="note_presse", type="float", precision=10, scale=0, nullable=true)
     */
    private $notePresse;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=true)
     */
    private $visible;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cover", type="boolean", nullable=true)
     */
    private $cover;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Actors", mappedBy="movies")
     */
    private $actors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Cinema", mappedBy="movies")
     */
    private $cinemas;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Directors", mappedBy="movies")
     */
    private $directors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Medias", inversedBy="movies")
     * @ORM\JoinTable(name="medias_movies",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="medias_id", referencedColumnName="id")
     *   }
     * )
     *     */
    private $medias;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="movie")
     */
    private $comments;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", inversedBy="movies")
     * @ORM\JoinTable(name="related_movies",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="movies_id_related", referencedColumnName="id")
     *   }
     * )
     */
    private $moviesRelated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movies", mappedBy="moviesRelated")
     */
    private $movies;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Tags", mappedBy="movies")
     * @ORM\JoinTable(name="movies_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movies_id", referencedColumnName="movies_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tags_id", referencedColumnName="id")
     *   }
     * )
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cinemas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->directors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->medias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCreated = new \Datetime('now');
        $this->dateRelease = new \Datetime('now');
        $this->annee = new \Datetime('now');
        $this->annee = $this->annee->format('Y');
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typeFilm
     *
     * @param string $typeFilm
     * @return Movies
     */
    public function setTypeFilm($typeFilm)
    {
        $this->typeFilm = $typeFilm;

        return $this;
    }

    /**
     * Get typeFilm
     *
     * @return string
     */
    public function getTypeFilm()
    {
        return $this->typeFilm;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Movies
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set synopsis
     *
     * @param string $synopsis
     * @return Movies
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * Get synopsis
     *
     * @return string
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Movies
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set trailer
     *
     * @param string $trailer
     * @return Movies
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;

        return $this;
    }

    /**
     * Get trailer
     *
     * @return string
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Set languages
     *
     * @param integer $languages
     * @return Movies
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * Get languages
     *
     * @return integer
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set distributeur
     *
     * @param string $distributeur
     * @return Movies
     */
    public function setDistributeur($distributeur)
    {
        $this->distributeur = $distributeur;

        return $this;
    }

    /**
     * Get distributeur
     *
     * @return string
     */
    public function getDistributeur()
    {
        return $this->distributeur;
    }

    /**
     * Set bo
     *
     * @param string $bo
     * @return Movies
     */
    public function setBo($bo)
    {
        $this->bo = $bo;

        return $this;
    }

    /**
     * Get bo
     *
     * @return string
     */
    public function getBo()
    {
        return $this->bo;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return Movies
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set budget
     *
     * @param float $budget
     * @return Movies
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return float
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     * @return Movies
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set dateRelease
     *
     * @param \DateTime $dateRelease
     * @return Movies
     */
    public function setDateRelease($dateRelease)
    {
        $this->dateRelease = $dateRelease;

        return $this;
    }

    /**
     * Get dateRelease
     *
     * @return \DateTime
     */
    public function getDateRelease()
    {
        return $this->dateRelease;
    }

    /**
     * Set notePresse
     *
     * @param float $notePresse
     * @return Movies
     */
    public function setNotePresse($notePresse)
    {
        $this->notePresse = $notePresse;

        return $this;
    }

    /**
     * Get notePresse
     *
     * @return float
     */
    public function getNotePresse()
    {
        return $this->notePresse;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Movies
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set cover
     *
     * @param boolean $cover
     * @return Movies
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return boolean
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Movies
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Add actors
     *
     * @param \Cinhetic\PublicBundle\Entity\Actors $actors
     * @return Movies
     */
    public function addActor(\Cinhetic\PublicBundle\Entity\Actors $actors)
    {
        $this->actors[] = $actors;

        return $this;
    }

    /**
     * Remove actors
     *
     * @param \Cinhetic\PublicBundle\Entity\Actors $actors
     */
    public function removeActor(\Cinhetic\PublicBundle\Entity\Actors $actors)
    {
        $this->actors->removeElement($actors);
    }

    /**
     * Get actors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Add cinemas
     *
     * @param \Cinhetic\PublicBundle\Entity\Cinema $cinemas
     * @return Movies
     */
    public function addCinema(\Cinhetic\PublicBundle\Entity\Cinema $cinemas)
    {
        $this->cinemas[] = $cinemas;

        return $this;
    }

    /**
     * Remove cinemas
     *
     * @param \Cinhetic\PublicBundle\Entity\Cinema $cinemas
     */
    public function removeCinema(\Cinhetic\PublicBundle\Entity\Cinema $cinemas)
    {
        $this->cinemas->removeElement($cinemas);
    }

    /**
     * Get cinemas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCinemas()
    {
        return $this->cinemas;
    }

    /**
     * Add directors
     *
     * @param \Cinhetic\PublicBundle\Entity\Directors $directors
     * @return Movies
     */
    public function addDirector(\Cinhetic\PublicBundle\Entity\Directors $directors)
    {
        $this->directors[] = $directors;

        return $this;
    }

    /**
     * Remove directors
     *
     * @param \Cinhetic\PublicBundle\Entity\Directors $directors
     */
    public function removeDirector(\Cinhetic\PublicBundle\Entity\Directors $directors)
    {
        $this->directors->removeElement($directors);
    }

    /**
     * Get directors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirectors()
    {
        return $this->directors;
    }

    /**
     * Add medias
     *
     * @param \Cinhetic\PublicBundle\Entity\Medias $medias
     * @return Movies
     */
    public function addMedia(\Cinhetic\PublicBundle\Entity\Medias $medias)
    {
        $this->medias[] = $medias;

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \Cinhetic\PublicBundle\Entity\Medias $medias
     */
    public function removeMedia(\Cinhetic\PublicBundle\Entity\Medias $medias)
    {
        $this->medias->removeElement($medias);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovies()
    {
        return $this->movies;
    }


    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Add movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     * @return Movies
     */
    public function addMovie(\Cinhetic\PublicBundle\Entity\Movies $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $movies
     */
    public function removeMovie(\Cinhetic\PublicBundle\Entity\Movies $movies)
    {
        $this->movies->removeElement($movies);
    }


    /**
     * Set category
     *
     * @param \Cinhetic\PublicBundle\Entity\Categories $category
     * @return Movies
     */
    public function setCategory(\Cinhetic\PublicBundle\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Cinhetic\PublicBundle\Entity\Categories
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tags
     *
     * @param \Cinhetic\PublicBundle\Entity\Tags $tags
     * @return Movies
     */
    public function addTag(\Cinhetic\PublicBundle\Entity\Tags $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Cinhetic\PublicBundle\Entity\Tags $tags
     */
    public function removeTag(\Cinhetic\PublicBundle\Entity\Tags $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add moviesRelated
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $moviesRelated
     * @return Movies
     */
    public function addMoviesRelated(\Cinhetic\PublicBundle\Entity\Movies $moviesRelated)
    {
        $this->moviesRelated[] = $moviesRelated;

        return $this;
    }

    /**
     * Remove moviesRelated
     *
     * @param \Cinhetic\PublicBundle\Entity\Movies $moviesRelated
     */
    public function removeMoviesRelated(\Cinhetic\PublicBundle\Entity\Movies $moviesRelated)
    {
        $this->moviesRelated->removeElement($moviesRelated);
    }

    /**
     * Get moviesRelated
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMoviesRelated()
    {
        return $this->moviesRelated;
    }


    /**
     * @return string
     */
    public function __toString(){
        return $this->title."(".$this->bo.") - ".$this->annee;
    }

    /**
     * Add comments
     *
     * @param \Cinhetic\PublicBundle\Entity\Comments $comments
     * @return Movies
     */
    public function addComment(\Cinhetic\PublicBundle\Entity\Comments $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Cinhetic\PublicBundle\Entity\Comments $comments
     */
    public function removeComment(\Cinhetic\PublicBundle\Entity\Comments $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
