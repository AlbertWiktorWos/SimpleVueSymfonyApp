<?php

namespace App\Validator;

use App\Dto\WorkExperienceModel;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateRangeValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        assert($constraint instanceof DateRange);
        assert($value instanceof WorkExperienceModel);

        if (!$value->dateFrom || !$value->dateTo) {
            return;
        }

        if ($value->dateFrom > $value->dateTo) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ from }}', $value->dateFrom->format('Y-m-d'))
                ->setParameter('{{ to }}', $value->dateTo->format('Y-m-d'))
                ->addViolation();
        }
    }
}
