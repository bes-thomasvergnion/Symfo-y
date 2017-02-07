<?php

namespace TV\FindyourbandBundle\Controller;

use TV\FindyourbandBundle\Entity\Contact;
use TV\FindyourbandBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ContactController extends Controller
{
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction($id, Request $request){
        $contact = new Contact();
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TVUserBundle:User')->find($id);
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $receiverEmail = $user->getEmail();
        $senderEmail = $currentUser->getEmail();
              
        $form = $this->get('form.factory')->create(ContactType::class, $contact);
        
         if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
               
            $contact->setEmail($senderEmail);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            
            $subject= $contact->getSubject();
            $content= $contact->getContent();
            
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($receiverEmail)
                ->setBody($this->renderView('TVFindyourbandBundle:Contact:email.html.twig', array('content' => $content, 'senderEmail' => $senderEmail)));
            
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('tv_findyourband_homepage');
        }
        
        return $this->render('TVFindyourbandBundle:Contact:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
