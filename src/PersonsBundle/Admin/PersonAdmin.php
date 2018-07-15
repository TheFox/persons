<?php

namespace TheFox\PersonsBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PersonAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with(sprintf('%s.group.%s', $this->translationEntityName, 'general'))
            ->add('gender', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'gender'),
            ])
            ->add('comment', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'comment'),
            ])
            ->end()
            ->with(sprintf('%s.group.%s', $this->translationEntityName, 'name'))
            ->add('name', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'name'),
            ])
            ->add('lastNameBorn', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'lastNameBorn'),
            ])
            ->add('middleName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'middleName'),
            ])
            ->add('firstName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'firstName'),
            ])
            ->add('nickName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'nickName'),
            ])
            ->end()
            ->with(sprintf('%s.group.%s', $this->translationEntityName, 'dates'))
            ->add('birthday', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'birthday'),
            ])
            ->add('deceasedAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'deceasedAt'),
            ])
            ->add('firstMetAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'firstMetAt'),
            ])
            ->end()
            ->with(sprintf('%s.group.%s', $this->translationEntityName, 'facebook'))
            ->add('facebookId', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'facebookId'),
            ])
            ->add('facebookUrl', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'facebookUrl'),
            ])
            ->end()
            ->with(sprintf('%s.group.%s', $this->translationEntityName, 'blood'))
            ->add('bloodType', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'bloodType'),
            ])
            ->add('bloodTypeRhd', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'bloodTypeRhd'),
            ])
            ->end()
            ->with('event.entity_name_singular')
            ->add('defaultEventType', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'defaultEventType'),
            ])
            ->end()
            ->with(sprintf('%s.group.%s', $this->translationEntityName, 'user'))
            ->add('user', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'user'),
            ])
            ->end()
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
            ->add('user', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'user'),
            ])
            ->add('id', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'id'),
            ])
            ->add('lastName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'lastName'),
            ])
            ->add('firstName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'firstName'),
            ])
            ->add('gender', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'gender'),
            ])
            ->add('birthday', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'birthday'),
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
            ->add('name', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'name'),
            ])
            ->add('lastNameBorn', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'lastNameBorn'),
            ])
            ->add('middleName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'middleName'),
            ])
            ->add('firstName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'firstName'),
            ])
            ->add('nickName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'nickName'),
            ])
            ->add('gender', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'gender'),
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('user', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'user'),
            ])
            ->add('id', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'id'),
            ])
            ->add('name', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'name'),
            ])
            ->add('lastNameBorn', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'lastNameBorn'),
            ])
            ->add('middleName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'middleName'),
            ])
            ->add('firstName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'firstName'),
            ])
            ->add('nickName', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'nickName'),
            ])
            ->add('gender', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'gender'),
            ])
            ->add('birthday', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'birthday'),
            ])
            ->add('deceasedAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'deceasedAt'),
            ])
            ->add('firstMetAt', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'firstMetAt'),
            ])
            ->add('facebookId', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'facebookId'),
            ])
            ->add('facebookUrl', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'facebookUrl'),
            ])
            ->add('bloodType', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'bloodType'),
            ])
            ->add('bloodTypeRhd', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'bloodTypeRhd'),
            ])
            ->add('defaultEventType', null, [
                'label' => sprintf('%s.%s', $this->translationEntityName, 'defaultEventType'),
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
