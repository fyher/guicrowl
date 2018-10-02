<?php

namespace App\Controller;

use App\Entity\Traitement;
use App\Form\SiteType;
use App\Service\Test;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Dotenv\Dotenv;

use App\Service\Elastic;

class DefaultController extends Controller
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
            $traitement->setPid(0);
            $em->persist($traitement);
            $em->flush();




           // $pid=$process->getPid();
            //dump($fin);

           // $em->flush();
            return $this->redirectToRoute("traitement_en_cour",array("hashtraitement"=>$traitement->getHashTraitement()));
        }


        $listetraitement=$this->getDoctrine()->getRepository("App:Traitement")->findBy(array(),array("dateTraitement"=>"desc"),10);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',"form"=>$form->createView(),
            "listetraitement"=>$listetraitement
        ]);
    }


    /**
     * @param Request $request
     * @param $hashtraitement
     * @Route("/traitement/{hashtraitement}" , name="traitement_en_cour")
     */
    public function loaddataAction(Request $request,$hashtraitement){
        $infotraitement=$this->getDoctrine()->getRepository("App:Traitement")->findOneBy(array("hashTraitement"=>$hashtraitement));

        if(!$infotraitement){
            return $this->redirectToRoute("default");
        }

        $urlelastic="url";
        $commande="python3 /var/www/crowl2/crowl.py -u ".$infotraitement->getUrlSite()." --conf_file /var/www/crowl2/config.ini -b test  --links --urlelastic url --idtraitement ".$infotraitement->getId();

         exec($commande);
        //dump($commande);
        $process=new Process($commande);

        $process->setTimeout(3600000);
        $process->start();
        while ($process->isRunning()) {
            // waiting for process to finish
            // dump("sa tourne");
        }
        $fin=$process->getOutput();
        $infotraitement->setEnd(1);
        $em=$this->getDoctrine()->getManager();
        $em->flush();


       // return new JsonResponse(array("finis"=>200));

        return $this->redirectToRoute("affiche_traitement",array("hashtraitement"=>$infotraitement->getHashTraitement()));

    }

    /**
     * @param Request $request
     * @param $hashtraitement
     * @Route("/affichetraitement/{hashtraitement}" , name="affiche_traitement")
     */
    public function affichetraitementAction(Request $request, $hashtraitement){

        //on se connecte à elastic et on affiche les informations du traitement
        $infotraitement=$this->getDoctrine()->getRepository("App:Traitement")->findOneBy(array("hashTraitement"=>$hashtraitement));

        if(!$infotraitement){
            return $this->redirectToRoute("default");
        }


        $paginator  = $this->get('knp_paginator');

        $listedata=$this->container->get("app_serv_elastic")->listetraitementdata($infotraitement->getId(),"fos_elastica.finder.crowl_traitement_data.url");


        //dump($listedata);

       $pagination = $paginator->paginate(
           $listedata,
            $request->query->getInt('page', 1),
           50
        );

        //on va chercher toute les informations et on trouve un moyen de refraichir la page correctement ^^

        return $this->render("default/affichetraitement.html.twig",array("pagination"=>$pagination,"traitement"=>$infotraitement));
    }


    /**
     * @param Request $request
     * @param $hashtraitement
     * @Route("/exportcsv/{hashtraitement}" , name="export_csv")
     */
    public function exportcsvAction(Request $request,$hashtraitement){

        $infotraitement=$this->getDoctrine()->getRepository("App:Traitement")->findOneBy(array("hashTraitement"=>$hashtraitement));

        if(!$infotraitement){
            return $this->redirectToRoute("default");
        }

        $listedata=$this->container->get("app_serv_elastic")->listetraitementdata($infotraitement->getId(),"fos_elastica.finder.crowl_traitement_data.url");


        $response = new StreamedResponse();
        $response->setCallback(function() use($listedata,$infotraitement){

            $handle = fopen('php://output', 'w+');
            // Nom des colonnes du CSV
            fputcsv($handle, array('url',
                'level',
                'latency',
                'nboutlinks',
                'title',
                'metadescription',
                'h1',
                'h2','h3','h4','h5','h6','h7','outlinks'
            ),';');

            //Champs

            foreach($listedata as $l){
                $listelink=$this->get("app_serv_elastic")->listelink($infotraitement->getId(),$l->getUrl(),"fos_elastica.finder.crowl_links_data.link");

                $lk=array();
                foreach($listelink as $link){
                    array_push($lk,$link->getTarget());
                }

                fputcsv($handle,array(
                    $l->getUrl(),
                    $l->getLevel(),
                    $l->getLatency(),
                    $l->getOutlinks(),
                    $l->getTitle(),
                    $l->getMetaDescription(),
                    implode(",",$l->getH1()),
                    implode(",", $l->getH2()),
                        implode(",",$l->getH3()),
                    implode(",", $l->getH4()),
                        implode(",", $l->getH5()),
                            implode(",", $l->getH6()),
                                implode(",", $l->getH7()),
                    implode(",",$lk)
                ),';');

            }



            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;

    }
}
