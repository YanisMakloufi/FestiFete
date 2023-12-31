<?php

namespace App\Form;

use App\Entity\Creneau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreneauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debut', DateTimeType::class, [
                'label' => "Horaire de début",
                'widget' => 'single_text',
                'attr'   => ['min' => (new \DateTime())->format('Y-m-d H:i')]])
            ->add('fin', DateTimeType::class, [
                'label' => "Horaire de fin",
                'widget' => 'single_text',
                'attr'   => ['min' => (new \DateTime())->format('Y-m-d H:i')]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Creneau::class,
        ]);
    }
}
