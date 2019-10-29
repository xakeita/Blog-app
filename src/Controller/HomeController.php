<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * 記事一覧を取得して表示
     */
    public function index()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);
        $data = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @Route("/home/{id}", name="find")
     * 自動フェッチを用いて記事を表示
     */
    public function find(Request $request, Article $article)
    {
        return $this->render('home/find.html.twig',[
            'data' => $article,
        ]);
    }
}
