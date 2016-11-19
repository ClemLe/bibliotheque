<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexContactAction()
    {
        return $this->render('BibliBundle:Contact:index.html.twig');
    }
}
