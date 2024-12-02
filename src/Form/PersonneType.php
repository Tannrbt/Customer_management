<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Adresse; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('age')
            ->add('adresse',EntityType::class,['class' => Adresse::class, 
            'choice_label' => 'codePostal', 
            'label' => 'Code Postal']);
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
