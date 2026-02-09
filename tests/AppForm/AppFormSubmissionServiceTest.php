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
                    company: 'TEST',
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
                    company: 'TEST',
                    position: 'Dev',
                    dateFrom: new \DateTime('2022-01-01'),
                    dateTo: new \DateTime('2020-01-01')
                )
            ]
        );


       $result = $service->submitAppForm($dto);
        self::assertFalse($result['success']);
    }

    public function testValidatesDtoFieldsSuccess(): void
    {
        self::bootKernel();
        $service = self::getContainer()->get(AppFormSubmissionService::class);

        $validDto = new PersonModel(
            firstName: 'Jan',
            lastName: 'Kowalski',
            birthDate: new \DateTime('1997-01-01'),
            contact: new ContactModel(email: 'jan@example.com', phone: '600700800'),
            workExperiences: [
                new WorkExperienceModel(
                    company: 'TEST',
                    position: 'Developer',
                    dateFrom: new \DateTime('2020-01-01'),
                    dateTo: new \DateTime('2022-01-01')
                )
            ]
        );

        $result = $service->submitAppForm($validDto);

        self::assertTrue($result['success']);
        self::assertArrayNotHasKey('errors', $result);
        self::assertEquals('Jan', $result['data']['firstName']);
        self::assertEquals('Kowalski', $result['data']['lastName']);
        self::assertEquals('1997-01-01', $result['data']['birthDate']);
        self::assertIsArray($result['data']['contact']);
        self::assertEquals('jan@example.com', $result['data']['contact']['email']);
        self::assertEquals('600700800', $result['data']['contact']['phone']);
        self::assertIsArray($result['data']['workExperiences']);
        self::assertEquals('TEST', $result['data']['workExperiences'][0]['company']);
        self::assertEquals('Developer', $result['data']['workExperiences'][0]['position']);
        self::assertEquals('2020-01-01', $result['data']['workExperiences'][0]['dateFrom']);
        self::assertEquals('2022-01-01', $result['data']['workExperiences'][0]['dateTo']);

    }

    public function testValidatesDtoFieldsFailure(): void
    {
        $service = self::getContainer()->get(AppFormSubmissionService::class);

        $invalidDto = new PersonModel(
            firstName: '', // brak imienia
            lastName: '',  // brak nazwiska
            birthDate: new \DateTime('3000-01-01'), // przyszła data
            contact: new ContactModel(email: 'invalid-email', phone: ''), // niepoprawny email + brak telefonu
            workExperiences: [] // brak doświadczeń
        );

        $resultInvalid = $service->submitAppForm($invalidDto);

        self::assertFalse($resultInvalid['success']);
        self::assertArrayHasKey('errors', $resultInvalid);

        $errorProperties = array_column($resultInvalid['errors'], 'property');

        self::assertContains('firstName', $errorProperties);
        self::assertContains('lastName', $errorProperties);
        self::assertContains('birthDate', $errorProperties);
        self::assertContains('contact.email', $errorProperties);
        self::assertContains('contact.phone', $errorProperties);
        self::assertContains('workExperiences', $errorProperties);
    }
}