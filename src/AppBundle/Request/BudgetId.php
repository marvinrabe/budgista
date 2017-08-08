<?php

namespace AppBundle\Request;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class BudgetId implements \AppBundle\Domain\BudgetId
{

    protected $id;

    public function __construct(ContainerInterface $container)
    {
        if ($container->hasParameter('_budget')) {
            $this->id = $container->getParameter('_budget');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

}
