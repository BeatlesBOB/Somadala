<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('PhotoFile',FileType::class)
            ->add('prix')
            ->add('quantite')
            ->add('theme',EntityType::class, [
                'class' => Theme::class,
                'query_builder' => function (ThemeRepository $th) {
                    return $th->createQueryBuilder('theme');
                },
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
