<?php

namespace BibliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livre
 *
 * @ORM\Table(name="livre")
 * @ORM\Entity(repositoryClass="BibliBundle\Repository\LivreRepository")
 */
class Livre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="text")
     */
    private $resume;

    /**
     * @var string
     *
     * @ORM\Column(name="couverture", type="string", length=255)
     */
    private $couverture;
    
    
    /**
        * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
        * @ORM\JoinColumn(nullable=true)
    */
    private $user_emprunt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEmprunt", type="datetime")
     */
    private $dateEmprunt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReservation", type="datetime")
     */
    private $dateReservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRetour", type="datetime")
     */
    private $dateRetour;


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
     * Set titre
     *
     * @param string $titre
     * @return Livre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Livre
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Livre
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set couverture
     *
     * @param string $couverture
     * @return Livre
     */
    public function setCouverture($couverture)
    {
        $this->couverture = $couverture;

        return $this;
    }

    /**
     * Get couverture
     *
     * @return string 
     */
    public function getCouverture()
    {
        return $this->couverture;
    }

    /**
     * Set dateEmprunt
     *
     * @param \DateTime $dateEmprunt
     * @return Livre
     */
    public function setDateEmprunt($dateEmprunt)
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    /**
     * Get dateEmprunt
     *
     * @return \DateTime 
     */
    public function getDateEmprunt()
    {
        return $this->dateEmprunt;
    }

    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     * @return Livre
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime 
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * Set dateRetour
     *
     * @param \DateTime $dateRetour
     * @return Livre
     */
    public function setDateRetour($dateRetour)
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    /**
     * Get dateRetour
     *
     * @return \DateTime 
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * Set user_emprunt
     *
     * @param \UserBundle\Entity\User $userEmprunt
     * @return Livre
     */
    public function setUserEmprunt(\UserBundle\Entity\User $userEmprunt = null)
    {
        $this->user_emprunt = $userEmprunt;

        return $this;
    }

    /**
     * Get user_emprunt
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUserEmprunt()
    {
        return $this->user_emprunt;
    }
}
