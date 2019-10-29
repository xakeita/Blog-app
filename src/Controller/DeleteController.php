<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="delete")
     * 記事を削除する
     */
    public function index(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($request->getMethod() === 'POST') {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($article);
            $manager->flush();

            return $this->redirect('/home');
        } else {
            return $this->render('delete/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
