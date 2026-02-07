<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute] class DateRange extends Constraint
{
    public string $message = 'Data "od" ({{ from }}) nie może być późniejsza niż data "do" ({{ to }}).';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
