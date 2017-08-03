<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TransactionNewType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'required' => true
            ])
            ->add('payee', TextType::class, [
                'required' => true
            ])
            ->add('category', TextType::class, [
                'required' => false
            ])
            ->add('amount', MoneyType::class, [
                'required' => true
            ]);
    }

}
