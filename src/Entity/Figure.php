<?php

namespace App\Entity;

use App\Repository\FigureRepository;
use App\Entity\Traits\BlameableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: FigureRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class Figure
{
    use BlameableEntity;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\Length(
        min: 2,
        max: 180
    )]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private ?string $name = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'figures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'figure', targetEntity: Image::class, orphanRemoval: true, cascade: ["persist", "remove"])]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'figure', targetEntity: Video::class, orphanRemoval: true, cascade: ["persist", "remove"])]
    private Collection $videos;

    #[ORM\OneToMany(mappedBy: 'figure', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
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
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * getSlug
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    /**
     * setSlug
     *
     * @param  string $slug Slug
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
    
    /**
     * getCategory
     *
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }
    
    /**
     * setCategory
     *
     * @param  Category $category Category
     * @return self
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
    
    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    /**
     * setDescription
     *
     * @param  string $description Description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }
    
    /**
     * addImage
     *
     * @param  Image $image Image
     * @return self
     */
    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setFigure($this);
        }

        return $this;
    }
    
    /**
     * removeImage
     *
     * @param  Image $image Image
     * @return self
     */
    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getFigure() === $this) {
                $image->setFigure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }
    
    /**
     * addVideo
     *
     * @param  Video $video Video
     * @return self
     */
    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setFigure($this);
        }

        return $this;
    }
    
    /**
     * removeVideo
     *
     * @param  Videp $video Video
     * @return self
     */
    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // Set the owning side to null (unless already changed)
            if ($video->getFigure() === $this) {
                $video->setFigure(null);
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
            $comment->setFigure($this);
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
            // Set the owning side to null (unless already changed)
            if ($comment->getFigure() === $this) {
                $comment->setFigure(null);
            }
        }

        return $this;
    }
}
