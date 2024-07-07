<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropositionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $places = $options['places'];
        $choices = $options['propositions'];

        for ($i = 1; $i <= $places; $i++) {
            $builder->add('top_' . $i, ChoiceType::class, [
                'choices' => array_flip($choices),
                'label' => 'Top ' . $i,
                'mapped' => false,
                'required' => true,
                'placeholder' => 'Choisir une option',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'places' => 1,
            'propositions' => [],
        ]);

        $resolver->setAllowedTypes('places', 'int');
        $resolver->setAllowedTypes('propositions', 'array');
    }
}