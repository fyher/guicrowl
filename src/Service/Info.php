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

class Info
{


    protected $em;
    protected $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function infolink($url,$idtraitement){


        return $this->container->get("app_serv_elastic")->listelink($idtraitement,$url,"fos_elastica.finder.crowl_links_data.link");
    }

}