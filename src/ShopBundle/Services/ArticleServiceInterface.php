<?php


namespace ShopBundle\Services;


use ShopBundle\Entity\Article;
use ShopBundle\Entity\User;

interface ArticleServiceInterface
{
    public function createAnArticle(Article $article, User $author);
    public function editAnArticle(int $id, Article $articleData);
    public function getSpecificArticle(int $id):Article;
    public function getAllArticles():array;
}