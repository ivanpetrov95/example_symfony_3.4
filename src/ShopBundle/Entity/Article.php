<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min="5", max="60", minMessage="Title is too short!", maxMessage="Title is too long!")
     * @ORM\Column(name="title", type="string", length=60, unique=true)
     */
    private string $title;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min="10", max="10000", minMessage="Content is too short!", maxMessage="Content is too long!")
     * @ORM\Column(name="content", type="string", length=10000)
     */
    private string $content;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="datetime", length=255)
     */
    private $date;

    private ?string $summary = null;

    /**
     * @var int
     * @ORM\Column(name="authorId", type="integer")
     */
    private ?int $authorId = null;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(name="authorId", referencedColumnName="id")
     */
    private ?User $author = null;

    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Comment", mappedBy="post")
     */
    private $comments;

    public function __construct()
    {
        $this->date = new \DateTime("now");
        $this->comments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @return string|void
     */
    public function getSummary(): string
    {
        if($this->summary != null) {
            return $this->summary;
        }
        else
        {
            $this->setSummary();
        }
    }

    /**
     * @param string $summary
     */
    public function setSummary(): void
    {
        $this->summary = substr($this->getContent(),0,$this->getContent()/2)."...";
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     * @return Article
     */
    public function setAuthorId(int $authorId):Article
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getAuthorName(): string
    {
        return $this->author->getUsername();
    }

    /**
     * @param User $author
     * @return Article
     */
    public function setAuthor(User $author): Article
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments(): ArrayCollection
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     */
    public function setComments(ArrayCollection $comments): self
    {
        $this->comments = $comments;
        return $this;
    }
}

