<?php


namespace ShopBundle\Services;


use ShopBundle\Entity\Article;
use ShopBundle\Entity\Comment;
use ShopBundle\Entity\User;

interface CommentServiceInterface
{
    public function createComment(Comment $comment, Article $article, User $user);
    public function editComment(int $id, Comment $comment);
    public function getSpecificComment(int $id);
    public function deleteComment(int $id);
}