<?php

namespace App\Admin;

use App\Entity\Order;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrderAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('user')
            ->add('createdAt')
            ->add('count')
            ->add('amount')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'draft' => Order::STATUS_DRAFT,
                    'ordered' => Order::STATUS_ORDERED,
                    'sent' => Order::STATUS_SENT,
                    'recevied' => Order::STATUS_RECEVIED,
                    'completed' => Order::STATUS_COMPLETED,
                ]
            ])
            ->add('isPaid')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user')
            ->add('createdAt')
            ->add('count')
            ->add('amount')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('status', null, [],ChoiceType::class,[
                'choices' => [
                    'draft' => Order::STATUS_DRAFT,
                    'ordered' => Order::STATUS_ORDERED,
                    'sent' => Order::STATUS_SENT,
                    'recevied' => Order::STATUS_RECEVIED,
                    'completed' => Order::STATUS_COMPLETED,
                ]
            ])
            ->add('isPaid')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('user')
            ->addIdentifier('createdAt')
            ->addIdentifier('count')
            ->addIdentifier('amount')
            ->addIdentifier('phone')
            ->addIdentifier('email')
            ->addIdentifier('address')
            ->add('status', 'choice', [
                'editable' => true,
                'choices' => [
                    Order::STATUS_DRAFT => 'draft',
                    Order::STATUS_ORDERED => 'ordered',
                    Order::STATUS_SENT => 'sent',
                    Order::STATUS_RECEVIED => 'recevied',
                    Order::STATUS_COMPLETED => 'completed',
                ]
            ])
            ->add('isPaid', null, ['editable' => true])
        ;
    }
}