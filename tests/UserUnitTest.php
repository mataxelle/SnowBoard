<?php

namespace App\Tests;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = new User();
        $datetime = new DateTimeImmutable();

        $user->setEmail('true@test.com')
             ->setRoles(['ROLE_TEST'])
             ->setPassword('password')
             ->setFirstname('nom')
             ->setLastname('prenom')
             ->setImageProfile('file')
             ->setCreatedAt($datetime)
             ->setUpdatedAt($datetime);

        $this->assertTrue($user->getEmail() === 'true@test.com');
        $this->assertTrue($user->getUserIdentifier() === 'true@test.com');
        $this->assertTrue($user->getRoles() === ['ROLE_TEST', 'ROLE_USER']);
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getFirstname() === 'nom');
        $this->assertTrue($user->getLastname() === 'prenom');
    }

    public function testIsFalse(): void
    {
        $user = new User();
        $datetime = new DateTimeImmutable();

        $user->setEmail('true@test.com')
             ->setRoles(['ROLE_TEST'])
             ->setPassword('password')
             ->setFirstname('nom')
             ->setLastname('prenom')
             ->setImageProfile('file')
             ->setCreatedAt($datetime)
             ->setUpdatedAt($datetime);

        $this->assertFalse($user->getEmail() === 'false@test.com');
        $this->assertFalse($user->getUserIdentifier() === 'false@test.com');
        $this->assertFalse($user->getPassword() === 'false');
        $this->assertFalse($user->getFirstname() === 'false');
        $this->assertFalse($user->getLastname() === 'false');
        $this->assertFalse($user->getCreatedAt() === new DateTimeImmutable());
        $this->assertFalse($user->getUpdatedAt() === new DateTimeImmutable());
    }

    public function testIsEmpty(): void
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getUserIdentifier());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getLastname());
        $this->assertEmpty($user->getCreatedAt());
        $this->assertEmpty($user->getUpdatedAt());
        $this->assertEmpty($user->getId());
    }

    public function testGetAddRemoveFigure() {
        $user = new User();
        $figure = new Figure();

        $this->assertEmpty($user->getFigures());

        $user->addFigure(($figure));
        $this->assertContains($figure, $user->getFigures());

        $user->removeFigure(($figure));
        $this->assertEmpty($user->getFigures());
    }

    public function testGetAddRemoveComment() {
        $user = new User();
        $comment = new Comment();

        $this->assertEmpty($user->getComments());

        $user->addComment(($comment));
        $this->assertContains($comment, $user->getComments());

        $user->removeComment(($comment));
        $this->assertEmpty($user->getComments());
    }
}
