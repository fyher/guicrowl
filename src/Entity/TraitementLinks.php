<?php
/**
 * Created by Fyher with PHPSTORM
 * @author: Driaux Cédric - SARL FYHER
 * Date: 29/09/2018
 * Time: 08:20
 */

namespace App\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Table(name="TraitementLinks")
 * @ORM\Entity(repositoryClass="App\Repository\TraitementLinksRepository")
 * @ORM\HasLifecycleCallbacks
 */
class TraitementLinks
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
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    private $idTraitement;



    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private $source;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private $target;


    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private $text;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $weight;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $nofollow;


    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $disallow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTraitement(): ?int
    {
        return $this->idTraitement;
    }

    public function setIdTraitement(int $idTraitement): self
    {
        $this->idTraitement = $idTraitement;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getNofollow(): ?int
    {
        return $this->nofollow;
    }

    public function setNofollow(?int $nofollow): self
    {
        $this->nofollow = $nofollow;

        return $this;
    }

    public function getDisallow(): ?int
    {
        return $this->disallow;
    }

    public function setDisallow(?int $disallow): self
    {
        $this->disallow = $disallow;

        return $this;
    }
}