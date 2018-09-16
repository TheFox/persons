<?php

namespace TheFox\PersonsBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use TheFox\PersonsBundle\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EventType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Translation Entity Name
        $ten = $options['translation_entity_name'];

        $builder
            ->add('person', TextType::class, [
                'label' => 'person.entity_name_plural',
                'disabled' => true,
            ])
            ->add('type', null, [
                'label' => sprintf('%s.%s', $ten, 'type'),
            ])
            ->add('happenedAt', null, [
                'label' => sprintf('%s.%s', $ten, 'happenedAt'),
            ])
            ->add('place', null, [
                'label' => sprintf('%s.%s', $ten, 'place'),
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
            'data_class' => Event::class,
            'translation_entity_name' => 'event',
        ]);
    }
}
