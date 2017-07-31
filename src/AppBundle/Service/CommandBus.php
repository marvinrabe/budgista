<?php


namespace AppBundle\Service;

interface CommandBus
{

    public function execute($command);

}