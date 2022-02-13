<?php


namespace ShopBundle\Services;


use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Article;
use ShopBundle\Entity\User;
use ShopBundle\Repository\ArticleRepository;
use ShopBundle\Repository\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{

    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function createAnArticle(Article $article, User $author)
    {
        $article->setAuthor($author);
        $this->articleRepository->createAnArticle($article);
    }

    public function editAnArticle(int $id, Article $articleData)
    {
        $article = $this->getSpecificArticle($id);
        $this->articleRepository->editAnArticle($article, $articleData);
    }

    public function getSpecificArticle(int $id): Article
    {
        return $this->articleRepository->find($id);
    }

    public function getAllArticles(): array
    {
        return $this->articleRepository->findAll();
    }
}