<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @var string
     *
     * @ORM\Column(name="commentText", type="string", length=10000)
     */
    private string $commentText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfPosting", type="datetime")
     */
    private $dateOfPosting;

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Article", inversedBy="comments")
     */
    private $post;
    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\User", inversedBy="comments")
     */
    private $author;

    public function __construct()
    {
        $this->setDateOfPosting();
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
     * Set commentText
     *
     * @param string $commentText
     *
     * @return Comment
     */
    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;

        return $this;
    }

    /**
     * Get commentText
     *
     * @return string
     */
    public function getCommentText()
    {
        return $this->commentText;
    }

    /**
     * Set dateOfPosting
     *
     * @param \DateTime $dateOfPosting
     *
     * @return Comment
     */
    public function setDateOfPosting()
    {
        $this->dateOfPosting = new \DateTime('now');

        return $this;
    }

    /**
     * Get dateOfPosting
     *
     * @return \DateTime
     */
    public function getDateOfPosting()
    {
        return $this->dateOfPosting;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost(Article $post): self
    {
        $this->post = $post;
        return $this;
    }
}

