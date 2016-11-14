<?php

namespace BibliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livre
 *
 * @ORM\Table(name="livre")
 */
class Livre{
    
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $titre;
    
     /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    
    private $auteur;
    
        
     /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $resume;
    
     /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $couverture;
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $dateEmprunt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $dateReservation;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $dateRetour;

}