<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OrderAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('createdAt')
            ->add('count')
            ->add('amount')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('status')
            ->add('isPaid')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('createdAt')
            ->add('count')
            ->add('amount')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('status')
            ->add('isPaid')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('createdAt')
            ->addIdentifier('count')
            ->addIdentifier('amount')
            ->addIdentifier('phone')
            ->addIdentifier('email')
            ->addIdentifier('address')
            ->add('status')
            ->add('isPaid')
        ;
    }
}