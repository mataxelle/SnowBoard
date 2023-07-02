<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[Vich\Uploadable]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, type: 'string')]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'image_figure', fileNameProperty: 'name')]
    private ?file $imageFile = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Figure $figure = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
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
     * getName
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param  string $name Name
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getImageFile
     *
     * @return void
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * setImageFile
     *
     * @param  File $name ImageFile
     * @return void
     */
    public function setImageFile(File $name = null)
    {
        $this->imageFile = $name;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($name) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }

    /**
     * getFigure
     *
     * @return Figure
     */
    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    /**
     * setFigure
     *
     * @param  Figure $figure Figure
     * @return self
     */
    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }

    /**
     * getUpdatedAt
     *
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * setUpdatedAt
     *
     * @param  DateTimeImmutable $updatedAt UpdatedAt
     * @return self
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
