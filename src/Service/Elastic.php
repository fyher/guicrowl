<?php


namespace App\Service;


use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Unirest;

use ToolBundle\Service\Clientprovider;
use ToolBundle\Entity\TokenUserConnector;

use Elastica\Query\Nested;
use Elastica\Query\Term;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Elastic
{


    protected $em;
    protected $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function listetraitementdata($idtraitement,$finder){
        $finder=$this->container->get($finder);

        $query=new \Elastica\Query();
        $query->setSize(10000);
        //dump($idtraitement);

        $boolQuery = new \Elastica\Query\BoolQuery();

        $fieldQuery = new \Elastica\Query\Match();
        $fieldQuery->setFieldQuery("idtraitement", $idtraitement);
        //$fieldQuery->setFieldParam('title', 'analyzer', 'my_analyzer');
        $boolQuery->addMust($fieldQuery);
        $query->setQuery($boolQuery);


        $data = $finder->find($query);

        return $data;
    }

    public function listelink($idtraitement,$url,$finder){

        $finder=$this->container->get($finder);

        $query=new \Elastica\Query();
        $query->setSize(1000);
        //dump($idtraitement);

        $boolQuery = new \Elastica\Query\BoolQuery();

        $fieldQuery = new \Elastica\Query\Match();
        $fieldQuery->setFieldQuery("idtraitement", $idtraitement);
        //$fieldQuery->setFieldParam('title', 'analyzer', 'my_analyzer');
        $boolQuery->addMust($fieldQuery);


        $fieldQuery = new \Elastica\Query\Match();
        $fieldQuery->setFieldQuery("source.keyword", $url);
        //$fieldQuery->setFieldParam('title', 'analyzer', 'my_analyzer');
        $boolQuery->addMust($fieldQuery);

        $query->setQuery($boolQuery);


        $data = $finder->find($query);


        return $data;

    }

    public function nbkeyword($idsite,$datedepart,$datefin,$device,$genre,$finder,$keyword){

        $finder=$this->container->get($finder);

        $query=new \Elastica\Query();
        $query->setSize(0);

        $boolQuery = new \Elastica\Query\BoolQuery();

        $fieldQuery = new \Elastica\Query\Match();
        $fieldQuery->setFieldQuery("idsite", $idsite);
        //$fieldQuery->setFieldParam('title', 'analyzer', 'my_analyzer');
        $boolQuery->addMust($fieldQuery);

        if($device!="ALL"){
            $fieldQuery = new \Elastica\Query\Match();
            $fieldQuery->setFieldQuery("device", $device);
            //$fieldQuery->setFieldParam('title', 'analyzer', 'my_analyzer');
            $boolQuery->addMust($fieldQuery);
        }



        if($genre!="ALL"){
            $fieldQuery = new \Elastica\Query\Match();
            $fieldQuery->setFieldQuery("genre", $genre);
            //$fieldQuery->setFieldParam('title', 'analyzer', 'my_analyzer');
            $boolQuery->addMust($fieldQuery);
        }

        $query->setQuery($boolQuery);

        if($keyword=="historique"){
            $filterQuery=new \Elastica\Query\Range();
            $filterQuery->addParam("datecreation",array("gte"=>$datedepart,"lte"=>$datefin));
            $boolQuery->addFilter($filterQuery);
        }else{
            //actif donc uniquement ceux avant une certaine date (//on retire 10 jours à la date de fin
            $dategestion=new \DateTime($datefin);
            $dategestion->modify("- 10 days");
            $filterQuery=new \Elastica\Query\Range();
            $filterQuery->addParam("datecreation",array("gte"=>$dategestion->format("Y-m-d"),"lte"=>$datefin));
            $boolQuery->addFilter($filterQuery);
        }


        $aggs=new \Elastica\Aggregation\Cardinality("nbkeyword");
        $aggs->setField("idkeyword.keyword");
        $query->addAggregation($aggs);
        $query->setQuery($boolQuery);

        //  dump($query->getQuery());




        $data = $finder->findPaginated($query);
        $res=$data->getAdapter()->getAggregations();

        // dump($res["nbkeyword"]["value"]);

        return $res["nbkeyword"]["value"];

        // dump($data->getAdapter()->getAggregations());


    }
}