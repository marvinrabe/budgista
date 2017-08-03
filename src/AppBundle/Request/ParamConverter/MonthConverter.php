<?php

namespace AppBundle\Request\ParamConverter;

use AppBundle\Entity\Month;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class MonthConverter implements ParamConverterInterface
{

    /**
     * Stores the object in the request.
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();

        $attribute = $request->attributes->get($name);

        $year = substr($attribute, 0, 4);
        $month = substr($attribute, -2);

        $object = new Month($month,$year);
        $request->attributes->set($name, $object);

        return true;
    }

    /**
     * Checks if the object is supported.
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        if($configuration->getClass() == Month::class) {
            return true;
        }

        return false;
    }

}
