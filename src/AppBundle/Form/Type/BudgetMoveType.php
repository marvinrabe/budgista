<?php

namespace AppBundle\Form\Type;

use AppBundle\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;

class BudgetMoveType extends AbstractType
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    protected function getChoices()
    {
        $categories = $this->categoryRepository->findAll();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->getName()] = $category->getId();
        }
        return $result;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('toCategory', ChoiceType::class, [
                'required' => true,
                'choices' => $this->getChoices(),
                'placeholder' => 'placeholder.toCategory',
                'label' => 'form.toCategory'
            ])
            ->add('amount', MoneyType::class, [
                'required' => true,
                'label' => 'form.amount'
            ]);
    }

}
