<?php

namespace AppBundle\Repository;

interface AccountRepository
{

    public function exists($name): bool;

}