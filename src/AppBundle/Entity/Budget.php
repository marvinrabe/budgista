<?php

namespace AppBundle\Entity;

class Budget
{
    protected $name;
    protected $categories;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->categories = ['Rent', 'Groceries', 'Car', 'Electricity', 'Internet', 'Fun Money'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

}