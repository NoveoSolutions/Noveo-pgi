<?php

namespace App\Form;

use App\Entity\Adresses;
use App\Entity\Clients;
use App\Form\EntityType;
use App\Form\AjoutAdresseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormTypeInterface;


#[IsGranted('ROLE_USER')]
class AjoutClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('commandes')
            ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
