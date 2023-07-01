<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use App\Entity\Traits\BlameableEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class Contact
{
    use BlameableEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $fullName = null;

    #[ORM\Column(length: 180)]
    #[Assert\Email(message: 'Cet email est invalide')]
    #[Assert\Length(
        min: 2,
        max: 180
    )]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private ?string $email = null;

    #[ORM\Column(length: 180)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private ?string $message = null;

    #[ORM\Column]
    private ?bool $isAnswered = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $answeredAt = null;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->answeredAt = new \DateTimeImmutable();
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
     * getFullName
     *
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }
    
    /**
     * setFullName
     *
     * @param  string $fullName Fullname
     * @return self
     */
    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
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
     * getSubject
     *
     * @return string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }
    
    /**
     * setSubject
     *
     * @param  string $subject Subject
     * @return self
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
    
    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
    
    /**
     * setMessage
     *
     * @param  string $message Message
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
    
    /**
     * isIsAnswered
     *
     * @return bool
     */
    public function isIsAnswered(): ?bool
    {
        return $this->isAnswered;
    }
    
    /**
     * setIsAnswered
     *
     * @param  bool $isAnswered IsAnswered
     * @return self
     */
    public function setIsAnswered(bool $isAnswered): self
    {
        $this->isAnswered = $isAnswered;

        return $this;
    }
    
    /**
     * getAnsweredAt
     *
     * @return DateTimeImmutable
     */
    public function getAnsweredAt(): ?\DateTimeImmutable
    {
        return $this->answeredAt;
    }
    
    /**
     * setAnsweredAt
     *
     * @param  DateTimeImmutable $answeredAt AnsweredAt
     * @return self
     */
    public function setAnsweredAt(?\DateTimeImmutable $answeredAt): self
    {
        $this->answeredAt = $answeredAt;

        return $this;
    }
}
