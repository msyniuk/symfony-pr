<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 09.01.18
 * Time: 23:10
 */

namespace App\Form;


use App\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;


class FeedBackType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'data_class' => Feedback::class,
       ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('message')
        ;
    }


}