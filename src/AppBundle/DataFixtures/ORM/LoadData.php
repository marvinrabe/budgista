<?php


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Payee;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadData extends AbstractFixture
{
    public function load(ObjectManager $em)
    {
        $category = new Category('Income');
        $em->persist($category);

        $payee = new Payee('Reconciliation');
        $em->persist($payee);

        $em->flush();
    }

}