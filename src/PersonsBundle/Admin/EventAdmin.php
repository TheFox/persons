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
        $form
            ->add('person', null, [
                'label' => 'person.entity_name_singular',
            ])
            ->add('happenedAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'happenedAt'),
            ])
            ->add('type', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'type'),
            ])
            ->add('place', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'place'),
            ])
            ->add('title', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'title'),
            ])
            ->add('comment', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'comment'),
            ])
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
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
                'label' => sprintf('%s.%s', $this->translationEntityName, 'id'),
            ])
            ->add('createdAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'createdAt'),
            ])
            ->add('updatedAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'updatedAt'),
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'id'),
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('person', null, [
                'label' => 'person.entity_name_singular',
            ])
            ->add('id', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'id'),
            ])
            ->add('happenedAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'happenedAt'),
            ])
            ->add('type', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'type'),
            ])
            ->add('place', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'place'),
            ])
            ->add('title', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'title'),
            ])
            ->add('comment', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'comment'),
            ])
            ->add('createdAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'createdAt'),
            ])
            ->add('updatedAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'updatedAt'),
            ])
        ;
    }
}
