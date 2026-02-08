<?php

namespace App\Tests\AppForm;

use App\Factory\PersonFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

final class MainControllerTest extends WebTestCase
{
    use HasBrowser;
    use ResetDatabase;

    public function testFormSubmissionSuccess(): void
    {
        $this->browser()
            ->post('/form', [
                'json' => [
                    'firstName' => 'Jan',
                    'lastName' => 'Kowalski',
                    'birthDate' => '1990-01-01',
                    'contact' => [
                        'email' => 'jan@example.com',
                        'phone' => '600700800'
                    ],
                    'workExperiences' => [
                        [
                            'company' => 'ACME',
                            'position' => 'Dev',
                            'dateFrom' => '2020-01-01',
                            'dateTo' => '2022-01-01'
                        ]
                    ]
                ]
            ])
            ->assertStatus(200)
            ->assertJson()
            ->assertJsonMatches('success', true);

        PersonFactory::assert()->count(1);
    }
}