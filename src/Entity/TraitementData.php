<?php
/**
 * Created by Fyher with PHPSTORM
 * @author: Driaux Cédric - SARL FYHER
 * Date: 28/09/2018
 * Time: 12:24
 */

namespace App\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Table(name="TraitementData")
 * @ORM\Entity(repositoryClass="App\Repository\TraitementDataRepository")
 * @ORM\HasLifecycleCallbacks
 */
class TraitementData
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
    private $url;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $h1;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $h2;


    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $h3;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $h4;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $h5;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $h6;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $h7;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponseCode;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @var text
     * @ORM\Column(type="text", length=500, nullable=true)
     */
    private $referer;

    /**
     * @var text
     * @ORM\Column(type="text", nullable=true)
     */
    private $metaDescription;


    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $latency;


    /**
     * @var text
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @var text
     * @ORM\Column(type="text", nullable=true)
     */
    private $canonical;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wordCount;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getH1(): ?array
    {
        return $this->h1;
    }

    public function setH1(?array $h1): self
    {
        $this->h1 = $h1;

        return $this;
    }

    public function getH2(): ?array
    {
        return $this->h2;
    }

    public function setH2(?array $h2): self
    {
        $this->h2 = $h2;

        return $this;
    }

    public function getH3(): ?array
    {
        return $this->h3;
    }

    public function setH3(?array $h3): self
    {
        $this->h3 = $h3;

        return $this;
    }

    public function getH4(): ?array
    {
        return $this->h4;
    }

    public function setH4(?array $h4): self
    {
        $this->h4 = $h4;

        return $this;
    }

    public function getH5(): ?array
    {
        return $this->h5;
    }

    public function setH5(?array $h5): self
    {
        $this->h5 = $h5;

        return $this;
    }

    public function getH6(): ?array
    {
        return $this->h6;
    }

    public function setH6(?array $h6): self
    {
        $this->h6 = $h6;

        return $this;
    }

    public function getH7(): ?array
    {
        return $this->h7;
    }

    public function setH7(?array $h7): self
    {
        $this->h7 = $h7;

        return $this;
    }

    public function getReponseCode(): ?int
    {
        return $this->reponseCode;
    }

    public function setReponseCode(?int $reponseCode): self
    {
        $this->reponseCode = $reponseCode;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getReferer(): ?string
    {
        return $this->referer;
    }

    public function setReferer(?string $referer): self
    {
        $this->referer = $referer;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getLatency(): ?float
    {
        return $this->latency;
    }

    public function setLatency(?float $latency): self
    {
        $this->latency = $latency;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCanonical(): ?string
    {
        return $this->canonical;
    }

    public function setCanonical(?string $canonical): self
    {
        $this->canonical = $canonical;

        return $this;
    }

    public function getWordCount(): ?int
    {
        return $this->wordCount;
    }

    public function setWordCount(?int $wordCount): self
    {
        $this->wordCount = $wordCount;

        return $this;
    }


}