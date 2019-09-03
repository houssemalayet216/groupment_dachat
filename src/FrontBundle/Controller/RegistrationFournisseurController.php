<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\RegistrationController as baseController ;
use FrontBundle\Form\RegistrationFournisseurType;
use Symfony\Component\HttpFoundation\JsonResponse;


use Symfony\Component\Routing\Annotation\Route;

class RegistrationFournisseurController extends Controller
{
   

    /**
     * @Route("/fournisseur/register",name="fournisseur_register")
     */
    public function registrationFournisseurAction(Request $request)
    {


    $formFactory=$this->get('form.factory');
    $userManager=$this->get('fos_user.user_manager');
    $eventDispatcher=$this->get('event_dispatcher');




        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->addRole('ROLE_FOURNISSEUR');

        $event = new GetResponseUserEvent($user, $request);
        $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);





        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
           
           $form=$formFactory->create(RegistrationFournisseurType::class,$user);
       /* $form =$formFactory->create(new ClientRegistrationType($this->container->getParameter('fos_user.model.user.class')));*/
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));


                if($request->isXmlHttpRequest())
                     {

                        $msg='Compte fournisseur creer successfly !';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg,'username'=>$user->getUsername()));

                     }     








                return $response;
            }


                 elseif($request->isXmlHttpRequest())
             {

                $formErrors=$this->get('validator')->validate($form);
                $errorsArray=[];

                foreach ($formErrors  as $error) {
                    
                    $errorsArray[]=array(
                       'elementId'=>$error->getPropertyPath(),
                       'errorMessage'=>$error->getMessage(),

                      
                    );

                }

                $msg="Vous vérifier vos information !!";
                return new JsonResponse(['success'=>false,'message'=>$msg,'errors'=>$errorsArray]);
             }

















            $event = new FormEvent($form, $request);
            $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        
        
          $user = $this->container->get('security.token_storage')->getToken()->getUser();
          
    if (is_object($user) || $user instanceof UserInterface) {
        
      return $this->redirectToRoute('redirect_user');
            
     }







        return $this->render('@FOSUser/Registration/register_fournisseur.html.twig', array(
            'formfournisseur' => $form->createView(),
        ));
    }

  
}