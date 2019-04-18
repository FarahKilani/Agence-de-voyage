<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;
use App\Entity\User;
use App\Form\UserType;
class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="frontoffice_home")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $circuits = $em->getRepository(Circuit::class)->findAll();
        
        dump($circuits);
        
        return $this->render('home.html.twig', [ 'circuits' => $circuits,]);
      
    }
    
    
    /**
     * 
     *  @Route("/circuits", name="circuits")
     *  
     *  
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllCircuits () {
        
        $em = $this->getDoctrine()->getManager();
        
        $circuits = $em->getRepository(Circuit::class)->findAll();
        
        return $this->render('front/circuits.html.twig', [
            'circuits'=> $circuits,
        ]);
    }
    
    /**
     *  @Route("/circuitsprogrammes", name="circuitsprogrammes")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllProgrammedCircuits () {
        
        $em = $this->getDoctrine()->getManager();
        $pcircuits=array();
        $allcircuits = $em->getRepository(Circuit::class)->findAll();
        foreach($allcircuits as $circuit){
            if(count($circuit->getProgrammation())>0){
                $pcircuits[] = $circuit;
//                 array_push($pcircuits,$circuit);      
            }
        }
        
        
        return $this->render('front/circuits.html.twig', [
            'circuits'=> $pcircuits,
        ]);
    }
    
    /**
     *  @Route("/circuitLike/{id}", name="front_like")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addCircuitToLikes ($id) {
        
        $em = $this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
                
        $liked = $user->getLikes();
        
        if(is_null($liked)){
            $liked = array();
        }  
        
                
        if(empty($liked)){
            $liked[] = $id;
        }
        else {
            if (! in_array($id, $liked) )
            {
                array_push($liked, $id);
            }
            else
            {
                $liked = array_diff($liked, array($id));
            }
        }
        
        
        $user->setLikes($liked);
        $em->persist($user);
        $em->flush();
        
        return $this->redirectToRoute('circuitsprogrammes');
    }
    
    
    /**
     * Finds and displays a circuit entity.
     *
     * @Route("/panier", name="front_panier_show")
     */
    
    public function panierShow()
    {
        
        $em = $this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){            
            $liked = $user->getLikes();
            
            $pcircuits=array();
            foreach($liked as $c){
                
                array_push($pcircuits,$em->getRepository(Circuit::class)->find($c));
                
            }
            
            
            return $this->render('front/panier_show.html.twig',['pcircuits' => $pcircuits]);
            
        }
        
        return $this->render('front/panier_show.html.twig',['pcircuits' => array()]);
    }
    
    /**
     * Finds and displays a circuit entity.
     *
     * @Route("/circuit/{id}", name="front_circuit_show")
     */
    
    public function circuitShow($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $circuit = $em->getRepository(Circuit::class)->find($id);
        
    
        $nombre=sizeof($circuit->getProgrammation());
        if($nombre==0){
            
        }
        return $this->render('front/circuit_show.html.twig', [
            'circuit'=> $circuit,
            'nombre' => $nombre
        ]);
    }
    
    /**
     * Finds and displays a circuit entity.
     *
     * @Route("/programmation/{id}", name="front_prog_show")
     */
    
    public function programmationShow($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $programmation= $em->getRepository(ProgrammationCircuit::class)->find($id);
        
        return $this->render('front/prog_show.html.twig', [
            'programmation'=> $programmation
        ]);
    }
    
    /**
     * Finds and displays a circuit entity.
     *
     * @Route("/signup", name="signup_show")
     */
    
    public function signupShow(Request $request)
    {
        $user=new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('front_home');
        }
        
        return $this->render('front/signup_show.html.twig', [
            'form' => $form->createView(),
        ]);
        
        
    }
}
