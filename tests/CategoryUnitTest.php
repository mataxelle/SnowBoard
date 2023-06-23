<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Figure;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $category = new Category();

        $category->setName('nom')
            ->setParent($category)
            ->setDescription('description')
            ->setSlug('slug');

        $this->assertTrue($category->getName() === 'nom');
        $this->assertTrue($category->getParent() === $category);
        $this->assertTrue($category->getDescription() === 'description');
        $this->assertTrue($category->getSlug() === 'slug');
    }

    public function testIsFalse(): void
    {
        $category = new Category();

        $category->setName('nom')
            ->setParent($category)
            ->setDescription('description')
            ->setSlug('slug');

        $this->assertFalse($category->getName() === 'false');
        $this->assertFalse($category->getParent() === new Category);
        $this->assertFalse($category->getDescription() === 'false');
        $this->assertFalse($category->getSlug() === 'false');
    }

    public function testIsEmpty(): void
    {
        $category = new Category();

        $this->assertEmpty($category->getName());
        $this->assertEmpty($category->getParent());
        $this->assertEmpty($category->getDescription());
        $this->assertEmpty($category->getSlug());
        $this->assertEmpty($category->getId());
    }

    public function testGetAddRemovePeinture()
    {
        $category = new Category();
        $figure = new Figure();

        $this->assertEmpty($category->getFigures());

        $category->addFigure(($figure));
        $this->assertContains($figure, $category->getFigures());

        $category->removeFigure(($figure));
        $this->assertEmpty($category->getFigures());
    }
}
