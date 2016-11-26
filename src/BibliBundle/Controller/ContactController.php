<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
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
    
    
    
    public function consulterMessageAction(){
        
        $messages = $this->getDoctrine()
        ->getRepository('BibliBundle:Message')
        ->findAll();
        
        
       return $this->render('BibliBundle:Contact:consulter.messages.html.twig',array(
           'messages' => $messages
       ));
    }
    
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
    
    
    public function supprimerMessageAction($idMessage){
        
     
        $message=$this->getDoctrine()->getRepository('BibliBundle:Message')->findOneBy(array('id' => $idMessage));
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();
        
       return $this->redirect($this->generateUrl('bibli_consulter_liste_messages'));
        
    }
}