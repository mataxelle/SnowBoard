<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email(message: 'Cet email est invalide')]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, max: 50)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, max: 50)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, type: 'string')]
    private ?string $imageProfile = null;

    #[Vich\UploadableField(mapping: 'image_profile', fileNameProperty: 'imageProfile')]
    private ?file $imageProfileFile = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Figure::class, orphanRemoval: true)]
    private Collection $figures;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->figures = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
    
    /**
     * getId
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * getEmail
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    /**
     * setEmail
     *
     * @param  string $email Email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    
    /**
     * setRoles
     *
     * @param  array $roles Roles
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    
    /**
     * getFirstname
     *
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    
    /**
     * setFirstname
     *
     * @param  string $firstname Firstname
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
    
    /**
     * getLastname
     *
     * @return string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    
    /**
     * setLastname
     *
     * @param  string $lastname Lastname
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }
    
    /**
     * getImageProfile
     *
     * @return string
     */
    public function getImageProfile(): ?string
    {
        return $this->imageProfile;
    }
    
    /**
     * setImageProfile
     *
     * @param  string $imageProfile ImageProfile
     * @return self
     */
    public function setImageProfile(?string $imageProfile): self
    {
        $this->imageProfile = $imageProfile;

        return $this;
    }
    
    /**
     * getImageProfileFile
     *
     * @return void
     */
    public function getImageProfileFile()
    {
        return $this->imageProfileFile;
    }
    
    /**
     * setImageProfileFile
     *
     * @param  File $imageProfile ImageProfileFile
     * @return void
     */
    public function setImageProfileFile(?File $imageProfile = null)
    {
        $this->imageProfileFile = $imageProfile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageProfile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return Collection<int, Figure>
     */
    public function getFigures(): Collection
    {
        return $this->figures;
    }
    
    /**
     * addFigure
     *
     * @param  Figure $figure Figure
     * @return self
     */
    public function addFigure(Figure $figure): self
    {
        if (!$this->figures->contains($figure)) {
            $this->figures->add($figure);
            $figure->setCreatedBy($this);
        }

        return $this;
    }
    
    /**
     * removeFigure
     *
     * @param  Figure $figure Figure
     * @return self
     */
    public function removeFigure(Figure $figure): self
    {
        if ($this->figures->removeElement($figure)) {
            // set the owning side to null (unless already changed)
            if ($figure->getCreatedBy() === $this) {
                $figure->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }
    
    /**
     * addComment
     *
     * @param  Comment $comment Comment
     * @return self
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setCreatedBy($this);
        }

        return $this;
    }
    
    /**
     * removeComment
     *
     * @param  Comment $comment Comment
     * @return self
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getCreatedBy() === $this) {
                $comment->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->firstname;
    }

    /**
     * Return only the security relevant data
     *
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * Restore security relevant data
     *
     * @param array $data
     */
    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->password = $data['password'];
    }
}
