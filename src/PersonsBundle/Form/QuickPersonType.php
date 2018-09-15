<?php

namespace TheFox\PersonsBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class QuickPersonType extends PersonType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Translation Entity Name
        $ten = $options['translation_entity_name'];

        $builder
            ->add('lastName', null, [
                'label' => sprintf('%s.%s', $ten, 'lastName'),
            ])
            ->add('firstName', null, [
                'label' => sprintf('%s.%s', $ten, 'firstName'),
            ])
            ->add('gender', null, [
                'label' => sprintf('%s.%s', $ten, 'gender'),
            ])
            ->add('firstMetAt', null, [
                'label' => sprintf('%s.%s', $ten, 'firstMetAt'),
            ])
            ->add('comment', null, [
                'label' => sprintf('%s.%s', $ten, 'comment'),
                'attr' => [
                    'rows' => 10,
                    'cols' => 30,
                ],
            ])
        ;
    }
}
