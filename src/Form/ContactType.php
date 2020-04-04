<?php

namespace App\Form;

use App\Entity\ProduitSearch;
use App\Entity\Contact;
use App\Repository\ThemeRepository;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'Nom'
                ]
            ])
            ->add('prenom',TextType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'Prénom'
                ]
            ])
            ->add('mail',TextType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'mail'
                ]
            ])
            ->add('telephone',TextType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'Telephone'
                ]
            ])
            ->add('sujet',TextType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'Sujet'
                ]
            ])
            ->add('message',TextareaType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=> [
                    'placeholder' =>'Message'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
