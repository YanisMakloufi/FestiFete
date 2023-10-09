<?php

namespace App\Form;

use App\Entity\Festival;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'label' => "Nom du festival : "
            ])
            ->add('description',TextareaType::class, [
                'label' => "Description du festival : "
            ])
            ->add('lieu', TextType::class, [
                'label' => "Lieu du festival : "
            ])
            ->add('creneau', CreneauType::class, [
                'label' => "Durée du festival : "
            ])
            ->add('postes', CollectionType::class, [
                'entry_type' => PosteType::class,
                'label' => "Postes à pourvoir : ",
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => [
                    new Assert\Count([
                        'min' => 1,
                        'minMessage' => 'Le festival doit proposer au moins 1 poste',
                    ]),
                ]])
            ->add('envoyer',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Festival::class,
        ]);
    }
}
