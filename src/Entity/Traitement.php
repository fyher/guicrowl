<?php
/**
 * Created by Fyher with PHPSTORM
 * @author: Driaux Cédric - SARL FYHER
 * Date: 28/09/2018
 * Time: 12:22
 */

namespace App\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Table(name="Traitement")
 * @ORM\Entity(repositoryClass="App\Repository\TraitementRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Traitement
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;


    /**
     * @var datetime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateTraitement;


    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $urlSite;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $end;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $hashTraitement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTraitement(): ?\DateTimeInterface
    {
        return $this->dateTraitement;
    }

    public function setDateTraitement(\DateTimeInterface $dateTraitement): self
    {
        $this->dateTraitement = $dateTraitement;

        return $this;
    }

    public function getUrlSite(): ?string
    {
        return $this->urlSite;
    }

    public function setUrlSite(string $urlSite): self
    {
        $this->urlSite = $urlSite;

        return $this;
    }

    public function getHashTraitement(): ?string
    {
        return $this->hashTraitement;
    }

    public function setHashTraitement(string $hashTraitement): self
    {
        $this->hashTraitement = $hashTraitement;

        return $this;
    }

    public function getEnd(): ?bool
    {
        return $this->end;
    }

    public function setEnd(bool $end): self
    {
        $this->end = $end;

        return $this;
    }



}