<?php


namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;

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