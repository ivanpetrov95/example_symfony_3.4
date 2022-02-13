<?php


namespace ShopBundle\Repository;


use ShopBundle\Entity\Article;

interface ArticleRepositoryInterface
{
    public function createAnArticle(Article $article);
    public function editAnArticle(Article $oldArticleData, Article $newArticleData);
}