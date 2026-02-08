<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class BasicTestCase extends KernelTestCase
{
    use ResetDatabase;
}
