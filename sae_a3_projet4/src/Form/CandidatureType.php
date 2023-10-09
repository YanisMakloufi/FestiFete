<?php

namespace App\Form;

use App\Entity\Candidature;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'attr' => [
                    'minlength' => 50,
                    'maxlength' => 600
                ]
            ])
            ->add('preferences', CollectionType::class, [
                'entry_type' => PreferenceType::class,
                'label' => false,
                'entry_options' => ['label' => false],
            ])
            ->add('disponibilites', CollectionType::class, [
                'entry_type' => CreneauType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'constraints' => [
                    new Assert\Count([
                        'min' => 1,
                        'minMessage' => 'Must have at least one value',
                    ]),
            ]])
            ->add('envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
