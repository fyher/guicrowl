<?php

namespace App\Controller;

use App\Entity\Traitement;
use App\Form\SiteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Dotenv\Dotenv;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(Request $request)
    {

        $form=$this->createForm(SiteType::class);


        $form->handleRequest($request);
        $dotenv = new Dotenv();
        //dump(__DIR__);
        $dotenv->load(__DIR__.'/../../.env');
        $urlelastic = getenv('ELASTIC_URL');
        $loginelastic=getenv('LOGIN_URL');
        $passwordElastic=getenv('ELASTIC_PSSWD');

        //dump($urlelastic);


        if($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
         //on peut lancer le traitement car on à récupérer une url

            $traitement=new Traitement();
            $traitement->setUrlSite($form["urlsite"]->getData());
            $traitement->setDateTraitement(new \DateTime());
            $traitement->setHashTraitement(uniqid());
            $traitement->setEnd(0);
            $em->persist($traitement);
            $em->flush();


            $urlelastic="http://token:56$2MT42G$!@149.202.164.105:9200";


           $commande="python3 /var/www/crowl2/crowl.py -u ".$form["urlsite"]->getData()." --conf_file /var/www/crowl2/config.ini -b test --urlelastic ".$urlelastic." --idtraitement ".$traitement->getId();


           dump($commande);
            // exit();
            //exec($commande);
           /* $process=new Process($commande);
            $process->setTimeout(3600000);
            $process->start();


            $em->flush();*/

           // return $this->redirectToRoute("client_client_liste");
        }


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',"form"=>$form->createView()
        ]);
    }
}