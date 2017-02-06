<?php

namespace TV\FindyourbandBundle\Controller;

use TV\FindyourbandBundle\Entity\Contact;
use TV\FindyourbandBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $user = $em->getRepository('TVFindyourbandBundle:Contact')->find($id);
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $receiverEmail = $user->getEmail();
        $senderEmail = $currentUser->getEmail();
        
        
                
        $form = $this->get('form.factory')->create(ContactType::class, $contact);
        
         if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
               
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            
            $subject= $contact->getSubject();
            $content= $contact->getContent();
            
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            $message = \Swift_Message::newInstance()
                ->setSubject('Test envoie de mail')
                ->setFrom('arthuredubois@hotmail.com')
                ->setTo('thomasvergnion@gmail.com')
                ->setBody($this->renderView('TVFindyourbandBundle:Contact:email.html.twig'));
            
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('tv_findyourband_homepage');
        }
        
        return $this->render('TVFindyourbandBundle:Contact:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}