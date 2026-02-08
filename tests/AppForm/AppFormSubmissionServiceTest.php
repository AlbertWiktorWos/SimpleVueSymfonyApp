<?php

namespace App\Tests\AppForm;

use App\Dto\ContactModel;
use App\Dto\PersonModel;
use App\Dto\WorkExperienceModel;
use App\Factory\PersonFactory;
use App\Factory\WorkExperienceFactory;
use App\Service\AppFormSubmissionService;
use App\Tests\BasicTestCase;
use Zenstruck\Foundry\Test\Factories;

class AppFormSubmissionServiceTest extends BasicTestCase
{
    use Factories;

    public function testSavesValidFormData(): void
    {
        self::bootKernel();

        $service = self::getContainer()->get(AppFormSubmissionService::class);

        $dto = new PersonModel(
            firstName: 'Jan',
            lastName: 'Kowalski',
            birthDate: new \DateTime('1990-01-01'),
            contact: new ContactModel(
                email: 'jan@example.com',
                phone: '600700800'
            ),
            workExperiences: [
                new WorkExperienceModel(
                    company: 'ACME',
                    position: 'Developer',
                    dateFrom: new \DateTime('2020-01-01'),
                    dateTo: new \DateTime('2022-01-01')
                )
            ]
        );

        $result = $service->submitAppForm($dto);
        self::assertTrue($result['success']);

        PersonFactory::assert()->count(1);
        WorkExperienceFactory::assert()->count(1);
    }

    public function testRejectsInvalidDateRange(): void
    {
        self::bootKernel();

        $service = self::getContainer()->get(AppFormSubmissionService::class);

        $dto = new PersonModel(
            firstName: 'Jan',
            lastName: 'Kowalski',
            birthDate: new \DateTime('1990-01-01'),
            contact: new ContactModel(
                email: 'jan@example.com',
                phone: '600700800'
            ),
            workExperiences: [
                new WorkExperienceModel(
                    company: 'ACME',
                    position: 'Dev',
                    dateFrom: new \DateTime('2022-01-01'),
                    dateTo: new \DateTime('2020-01-01')
                )
            ]
        );


       $result = $service->submitAppForm($dto);
        self::assertFalse($result['success']);
    }
}