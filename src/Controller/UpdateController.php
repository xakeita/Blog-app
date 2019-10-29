<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    /**
     * @Route("/update", name="update")
     * 記事一覧を取得
     */
    public function index()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);
        $data = $repository->findAll();

        return $this->render('update/index.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @Route("/update/{id}", name="updated")
     * 記事を更新する
     */
    public function update(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($request->getMethod() === 'POST') {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirect('/hello');
        } else {
            return $this->render('update/update.html.twig', [
                'message' => '更新する',
                'id' => $article->getId(),
                'form' => $form->createView(),
            ]);
        }
    }
}
