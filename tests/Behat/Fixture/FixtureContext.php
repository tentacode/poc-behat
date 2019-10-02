<?php

declare(strict_types=1);

namespace Tests\Behat\Fixture;

use Behat\Behat\Context\Context;
use DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticDriver;

/**
 * This context is used to make sure that we always use
 * the same fixtures between scenarios.
 *
 * - The fixtures are reset once at the begining of the suite.
 * - The transaction is rollbacked between each scenarios.
 */
final class FixtureContext implements Context
{
    /**
    * @BeforeSuite
    */
    public static function reloadFixtures()
    {
        exec('make fixtures-test');
    }

    /**
    * @BeforeSuite
    */
    public static function beforeSuite()
    {
        StaticDriver::setKeepStaticConnections(true);
    }

   /**
    * @BeforeScenario
    */
    public function beforeScenario()
    {
        StaticDriver::beginTransaction();
    }

   /**
    * @AfterScenario
    */
    public function afterScenario()
    {
        StaticDriver::rollBack();
    }

   /**
    * @AfterSuite
    */
    public static function afterSuite()
    {
        StaticDriver::setKeepStaticConnections(false);
    }
}
