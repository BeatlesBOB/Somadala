<?php

namespace App\Form;

use App\Entity\ProduitSearch;
use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrix',IntegerType::class,[
                'required'=> false,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'prix maximal'
                ]
            ])
            ->add('minPrix',IntegerType::class,[
                'required'=> false,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'prix minimal'
                ]
            ])
            ->add('nom',TextType::class,[
                'required'=> false,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'Nom du produit'
                ]
            ])

            ->add('theme',EntityType::class, [
                'required'=> false,
                'label'=>false,
                'class' => Theme::class,
                'query_builder' => function (ThemeRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProduitSearch::class,
            'method'=> 'get',
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
