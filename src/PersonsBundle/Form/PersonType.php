<?php

namespace TheFox\PersonsBundle\Form;

use TheFox\PersonsBundle\Entity\Person;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Translation Entity Name
        $ten = $options['translation_entity_name'];

        $builder
            ->add('name', null, [
                'label' => sprintf('%s.%s', $ten, 'name'),
                'disabled' => true,
            ])
            ->add('lastName', null, [
                'label' => sprintf('%s.%s', $ten, 'lastName'),
                'attr' => [
                    'size' => 50,
                    'maxlength' => 255,
                ],
            ])
            ->add('lastNameBorn', null, [
                'label' => sprintf('%s.%s', $ten, 'lastNameBorn'),
                'attr' => [
                    'size' => 50,
                    'maxlength' => 255,
                ],
            ])
            ->add('middleName', null, [
                'label' => sprintf('%s.%s', $ten, 'middleName'),
                'attr' => [
                    'size' => 50,
                    'maxlength' => 255,
                ],
            ])
            ->add('firstName', null, [
                'label' => sprintf('%s.%s', $ten, 'firstName'),
                'attr' => [
                    'size' => 50,
                    'maxlength' => 255,
                ],
            ])
            ->add('nickName', null, [
                'label' => sprintf('%s.%s', $ten, 'nickName'),
                'attr' => [
                    'size' => 50,
                    'maxlength' => 255,
                ],
            ])
            ->add('gender', null, [
                'label' => sprintf('%s.%s', $ten, 'gender'),
            ])
            ->add('birthday', null, [
                'label' => sprintf('%s.%s', $ten, 'birthday'),
            ])
            ->add('deceasedAt', null, [
                'label' => sprintf('%s.%s', $ten, 'deceasedAt'),
            ])
            ->add('firstMetAt', null, [
                'label' => sprintf('%s.%s', $ten, 'firstMetAt'),
            ])
            ->add('facebookId', null, [
                'label' => sprintf('%s.%s', $ten, 'facebookId'),
                'attr' => [
                    'size' => 50,
                    'maxlength' => 255,
                ],
            ])
            ->add('facebookUrl', null, [
                'label' => sprintf('%s.%s', $ten, 'facebookUrl'),
                'attr' => [
                    'size' => 50,
                    'maxlength' => 255,
                ],
            ])
            ->add('bloodType', null, [
                'label' => sprintf('%s.%s', $ten, 'bloodType'),
            ])
            ->add('bloodTypeRhd', null, [
                'label' => sprintf('%s.%s', $ten, 'bloodTypeRhd'),
            ])
            ->add('defaultEventType', null, [
                'label' => sprintf('%s.%s', $ten, 'defaultEventType'),
            ])
            ->add('comment', null, [
                'label' => sprintf('%s.%s', $ten, 'comment'),
                'attr' => $options['comment_attr'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => Person::class,
            'translation_entity_name' => 'person',
        ]);
    }
}
