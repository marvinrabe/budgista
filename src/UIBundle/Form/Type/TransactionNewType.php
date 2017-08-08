<?php

namespace UIBundle\Form\Type;

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
                'widget' => 'single_text',
                'label' => 'form.date',
                'required' => true
            ])
            ->add('payee', TextType::class, [
                'label' => 'form.payee',
                'required' => true
            ])
            ->add('category', TextType::class, [
                'label' => 'form.category',
                'required' => false
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'form.cashflow',
                'required' => true
            ]);
    }

}
