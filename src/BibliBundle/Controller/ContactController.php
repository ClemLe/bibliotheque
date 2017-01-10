<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Classe ContactController
 * 
 * Cette classe permet la gestion des messages, leurs ajouts,
 * leurs affichages ainsi que toutes les fonctionnalités
 * concernant les messages
 */
class ContactController extends Controller
{
    /**
     * Envoyer un message à l'aide d'un formulaire
     * 
     * @param Request $request
     * @return type La vue permettant d'envoyer un message
     */
    public function indexContactAction(Request $request)
    {   
        
        $codeErreur=null;
        if (isset($_POST['action'])){
            
            $name=($_POST['name']);
            $subject=($_POST['subject']);
            $messagebody=($_POST['message']);
            $email=($_POST['email']);
            
            $message= new Message();
            $message->setAuthorname($name);
            $message->setEmail($email);
            $message->setSubject($subject);
            $message->setMessage($messagebody);
            $message->setIsRead(false);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            
            $codeErreur=1;
        }
           
        return $this->render('BibliBundle:Contact:index.html.twig',array(
          'codeErreur' => $codeErreur,
        ));
    }
    
    
    /**
     * Affichage de la liste des messages
     * 
     * @return type La liste de tous les messages
     */
    public function consulterMessageAction(){
        
        $messages = $this->getDoctrine()
        ->getRepository('BibliBundle:Message')
        ->findAll();
        
        
       return $this->render('BibliBundle:Contact:consulter.messages.html.twig',array(
           'messages' => $messages
       ));
    }
    
    /**
     * Affichage d'un message
     * 
     * @param type $idMessage L'identifiant du message à afficher
     * @return type La vue de description du message
     */
    public function consulterUnMessageAction($idMessage){
        
        $message=$this->getDoctrine()->getRepository('BibliBundle:Message')->findOneBy(array('id' => $idMessage));
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
        
        
      
       $corpsMessage=htmlentities($message->getMessage());
        
        
        return $this->render('BibliBundle:Contact:consulter.un.message.html.twig',array(
           'message' => $message,
            'corpsMessage' => $corpsMessage

        ));
    }
    
    /**
     * Compte le nombre de messages stockés dans la base de données
     * 
     * @return Response Le nombre de messages 
     */
    public function calculNombreMessageAction(){
        $nombreMessage=0;
        $messages = $this->getDoctrine()
        ->getRepository('BibliBundle:Message')
        ->findAll();
        
        foreach ($messages as $message){
            if($message->getIsRead() == false){
                $nombreMessage++;
            } 
        }
        
        return new Response($nombreMessage);
    }
    
    /**
     * Supprime un message de la base de données
     * 
     * @param type $idMessage L'identifiant du message à supprimer
     * @return type La vue d'affichage des messages
     */
    public function supprimerMessageAction($idMessage){
        
     
        $message=$this->getDoctrine()->getRepository('BibliBundle:Message')->findOneBy(array('id' => $idMessage));
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();
        
       return $this->redirect($this->generateUrl('bibli_consulter_liste_messages'));
        
    }
}