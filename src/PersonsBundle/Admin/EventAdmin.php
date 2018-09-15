<?php

namespace TheFox\PersonsBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EventAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $ten = $this->translationEntityName;

        $form
            ->add('person', null, [
                'label' => 'person.entity_name_singular',
            ])
            ->add('happenedAt', null, [
                'label' => sprintf('%s.%s', $ten, 'happenedAt'),
            ])
            ->add('type', null, [
                'label' => sprintf('%s.%s', $ten, 'type'),
            ])
            ->add('place', null, [
                'label' => sprintf('%s.%s', $ten, 'place'),
            ])
            ->add('title', null, [
                'label' => sprintf('%s.%s', $ten, 'title'),
            ])
            ->add('comment', null, [
                'label' => sprintf('%s.%s', $ten, 'comment'),
            ])
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $ten = $this->translationEntityName;

        $list
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ],
            ])
            ->add('person', null, [
                'label' => 'person.entity_name_singular',
            ])
            ->add('id', null, [
                'label' => sprintf('%s.%s', $ten, 'id'),
            ])
            ->add('createdAt', null, [
                'label' => sprintf('%s.%s', $ten, 'createdAt'),
            ])
            ->add('updatedAt', null, [
                'label' => sprintf('%s.%s', $ten, 'updatedAt'),
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $ten = $this->translationEntityName;

        $filter
            ->add('id', null, [
                'label' => sprintf('%s.%s', $ten, 'id'),
            ]);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $ten = $this->translationEntityName;
    
        $show
            ->add('person', null, [
                'label' => 'person.entity_name_singular',
            ])
            ->add('id', null, [
                'label' => sprintf('%s.%s', $ten, 'id'),
            ])
            ->add('happenedAt', null, [
                'label' => sprintf('%s.%s', $ten, 'happenedAt'),
            ])
            ->add('type', null, [
                'label' => sprintf('%s.%s', $ten, 'type'),
            ])
            ->add('place', null, [
                'label' => sprintf('%s.%s', $ten, 'place'),
            ])
            ->add('title', null, [
                'label' => sprintf('%s.%s', $ten, 'title'),
            ])
            ->add('comment', null, [
                'label' => sprintf('%s.%s', $ten, 'comment'),
            ])
            ->add('createdAt', null, [
                'label' => sprintf('%s.%s', $ten, 'createdAt'),
            ])
            ->add('updatedAt', null, [
                'label' => sprintf('%s.%s', $ten, 'updatedAt'),
            ])
        ;
    }
}
