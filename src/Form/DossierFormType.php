<?php

namespace App\Form;

use App\Entity\DossierTech;
use App\Entity\Saisons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossierFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomDossier', TextType::class, [
                'required' => false,
            ])
            ->add('Reference', TextType::class, [
               'required' => false,
            ])
            ->add('Taille', TextType::class, [
                'required' => false,
             ])
            
            ->add('NomSaison', EntityType::class, [
                'required' => false,
                'class' => Saisons::class,
                'choice_label' => 'NomSaison'
            ]) 
               
            ->add('File', FileType::class, [
                'label' => 'Sélectionner un fichier',
                'required' => true,
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
