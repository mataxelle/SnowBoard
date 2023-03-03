<?php

namespace App\Tests;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CommentUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $comment = new Comment();
        $figure = new Figure();
        $user = new User;
        $datetime = new DateTimeImmutable();

        $comment->setMessage('message')
                ->setUser($user)
                ->setFigure($figure)
                ->setUpdatedAt($datetime)
                ->setCreatedAt($datetime);

        $this->assertTrue($comment->getMessage() === 'message');
        $this->assertTrue($comment->getUser() === $user);
        $this->assertTrue($comment->getFigure() === $figure);
        $this->assertTrue($comment->getCreatedAt() === $datetime);
        $this->assertTrue($comment->getUpdatedAt() === $datetime);
    }

    public function testIsFalse(): void
    {
        $comment = new Comment();
        $figure = new Figure();
        $user = new User;
        $datetime = new DateTimeImmutable();

        $comment->setMessage('message')
                ->setUser($user)
                ->setFigure($figure)
                ->setUpdatedAt($datetime)
                ->setCreatedAt($datetime);

                $this->assertFalse($comment->getMessage() === 'false');
                $this->assertFalse($comment->getUser() === new User);
                $this->assertFalse($comment->getFigure() === new Figure);
                $this->assertFalse($comment->getCreatedAt() === new DateTimeImmutable());
                $this->assertFalse($comment->getUpdatedAt() === new DateTimeImmutable());
    }

    public function testIsEmpty(): void
    {
        $comment = new Comment();

        $this->assertEmpty($comment->getMessage());
        $this->assertEmpty($comment->getUser());
        $this->assertEmpty($comment->getFigure());
        $this->assertEmpty($comment->getCreatedAt());
        $this->assertEmpty($comment->getUpdatedAt());
        $this->assertEmpty($comment->getId());
    }
}
