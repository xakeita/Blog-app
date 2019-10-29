<?php
namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'タイトル',
                'attr' => ['class' => 'form-control']
            ])
            ->add('content', TextareaType::class, [
                'label' => '記事',
                'attr' => ['class' => 'form-control']
            ])
            ->add('created_at', DateType::class, [
                'label' => '日付'
            ])
            ->add('save', SubmitType::class, [
                'label'=>'投稿',
                'attr' => ['class' => 'btn btn-primary mt-2']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class
        ]);
    }
}