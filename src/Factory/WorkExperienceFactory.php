<?php

namespace App\Factory;

use App\Entity\WorkExperience;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<WorkExperience>
 */
final class WorkExperienceFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return WorkExperience::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'company' => self::faker()->text(255),
            'dateFrom' => new \DateTime('-2 years'),
            'dateTo'   => new \DateTime('-1 year'),
            'person' => PersonFactory::new(),
            'position' => self::faker()->jobTitle(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(WorkExperience $workExperience): void {})
        ;
    }
}
