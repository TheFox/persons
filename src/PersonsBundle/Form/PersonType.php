<?php

namespace TheFox\PersonsBundle\Form;

use TheFox\PersonsBundle\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->add('lastNameBorn')
            ->add('middleName')
            ->add('firstName')
            ->add('nickName')
            ->add('gender')
            ->add('birthday')
            ->add('deceasedAt')
            ->add('firstMetAt')
            ->add('facebookId')
            ->add('facebookUrl')
            ->add('bloodType')
            ->add('bloodTypeRhd')
            ->add('defaultEventType')
            ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
