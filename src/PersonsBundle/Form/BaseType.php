<?php

namespace TheFox\PersonsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity',
            'comment_attr' => [
                'rows' => 10,
                'cols' => 30,
            ],
        ]);
    }
}
