<?php

namespace ShopBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int|null
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min="3",
     *     max="255",
     *     minMessage="Email is too short!",
     *     maxMessage="Email is too long!")
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min="8", max="255", minMessage="Password is too short!", maxMessage="Password is too long!")
     * @ORM\Column(name="password", type="string", length=255)
     */
    private string $password;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="30", minMessage="Username is too short!", maxMessage="Username is too long!")
     * @ORM\Column(name="username", type="string", length=30, unique=true)
     */
    private string $username;

    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Article", mappedBy="author")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Comment", mappedBy="author")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="ShopBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles",
     * joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     */
    private $roles;

    /**
     * @var string|null
     *
     * @ORM\Column(name="picture_uri", type="string", length=255, unique=true, nullable=true)
     */
    private ?string $pictureURI = null;

    /**
     * TO DO is_active flag for an user acc being active it can be changed by administrator or the owner user
     */


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->roles = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    public function getRoles()
    {
        $rolesArray = [];
        /**
         * @var Role $role
         */
        foreach($this->roles as $role)
        {
            $rolesArray[] = $role->getName();
        }
        return $rolesArray;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles(): ArrayCollection
    {
        return $this->articles;
    }

    /**
     * @return string
     */
    public function getPictureURI(): ?string
    {
        return $this->pictureURI;
    }

    /**
     * @param string|null $pictureURI
     */
    public function setPictureURI(?string $pictureURI): void
    {
        $this->pictureURI = $pictureURI;
    }

    /**
     * @param Article $article
     * @return User
     */
    public function addArticle(Article $article): User
    {
        $this->articles[] = $article;
        return $this;
    }

    public function isAuthor(Article $article): bool
    {
        return $article->getAuthorId() === $this->getId();
    }

    /**
     * @return ArrayCollection
     */
    public function getComments(): ArrayCollection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     */
    public function setComment(Comment $comment): self
    {
        $this->comments[] = $comment;
        return $this;
    }

}

