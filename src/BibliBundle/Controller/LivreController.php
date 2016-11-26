<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;

class LivreController extends Controller
{
    public function ajouterAction(Request $request){   
        $codeErreur=null;
        if (isset($_POST['action'])){
            
            $title=mysql_real_escape_string($_POST['titre']);
            $auteur=mysql_real_escape_string($_POST['auteur']);
            $resume=mysql_real_escape_string($_POST['resume']);
            
            $livre= new Livre();
            $livre->setTitre($title);
            $livre->setAuteur($auteur);
            $livre->setResume($resume);

            $em = $this->getDoctrine()->getManager();
            $em->persist($livre);
            $em->flush();
            
            $codeErreur=1;
        }         
        
        return $this->render('BibliBundle:AjouterLivre:index.html.twig',array(
          'codeErreur' => $codeErreur,
        ));
    }
    
    public function rechercheLivreAction(){
        return $this->render('BibliBundle:Livre:recherche.livre.html.twig');
    }
}