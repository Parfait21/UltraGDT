<?php

namespace App\Form;

use App\Entity\DossierTech;
use App\Entity\Saisons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DossierFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Reference', TextType::class, [
               'required' => false,
            ])
            ->add('TypeFicher', ChoiceType::class, [
                'choices' => [
                    'PRODUIT' => 'PRODUIT',
                    'PLAN' => 'PLAN',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            
             ->add('saisonId', EntityType::class, [
                'required' => false,
                'class' => Saisons::class,
                'choice_label' => 'NomSaison',
            ]) 
               
            ->add('brochure', FileType::class, [
                'label' => 'Selectionner un fichier',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])                  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DossierTech::class,
        ]);
    }
}
