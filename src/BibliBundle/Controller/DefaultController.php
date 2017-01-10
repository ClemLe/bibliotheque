<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controlleur par défaut 
 */
class DefaultController extends Controller
{
    /**
     * Retourne la vue par défaut du site
     * 
     * @return type La vue par défaut
     */
    public function indexAction()
    {
        return $this->render('BibliBundle:Default:index.html.twig');
    }
}
