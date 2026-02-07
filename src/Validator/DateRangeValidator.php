<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\WorkExperience;

class DateRangeValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        assert($constraint instanceof DateRange);
        assert($value instanceof WorkExperience);

        $from = $value->getDateFrom();
        $to = $value->getDateTo();

        if (!$from || !$to) {
            return;
        }

        if ($from > $to) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ from }}', $from->format('Y-m-d'))
                ->setParameter('{{ to }}', $to->format('Y-m-d'))
                ->addViolation();
        }
    }
}
