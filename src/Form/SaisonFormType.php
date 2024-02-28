<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\SaisonDefini;
use App\Entity\Saisons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaisonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SD', EntityType::class, [
                'required' => false,
                'class' => SaisonDefini::class,
                'choice_label' => 'NomSaisons',
            ])
            ->add('clientId', EntityType::class, [
                'required' => false,
                'class' => Clients::class,
                'choice_label' => 'NomClient',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Saisons::class,
        ]);
    }
}
