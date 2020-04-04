<?php

namespace App\Form;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit_id',EntityType::class, [
                'class' => Produit::class,
                'query_builder' => function (ProduitRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Panier::class,
        ]);
    }
}
