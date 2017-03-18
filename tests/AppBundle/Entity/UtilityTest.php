<?php
/**
 * dekazimir, 2017
 */

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Reading;
use AppBundle\Entity\Utility;
use Doctrine\Common\Collections\Criteria;
use Tests\AppBundle\TestDataFixtures\FixtureAwareTestCase;
use Tests\AppBundle\TestDataFixtures\ORM\LoadReadings;
use AppBundle\DataFixtures\ORM\LoadUtilities;
use PHPUnit\Framework\TestCase;

class UtilityTest extends TestCase
{
    /**
     * @var Utility
     */
    protected $utility;

    public function setUp()
    {
        $this->utility = new Utility();
        $this->utility->setName('Газ');
        $this->utility->setId(1);

        // Base fixture for all tests
        /** @var Reading $reading */
        $reading = new Reading();
        $today = new \DateTime();
        $yesterday = clone $today;
        $yesterday->modify('-1 DAY');
        $fiveDaysBefore = clone $today;
        $fiveDaysBefore->modify('-5 DAY');

        $reading = new Reading();
        $reading->setDate($fiveDaysBefore);
        $reading->setValue(10000);
        $reading->setIsControl(true);
        $reading->setId(1);
        $this->utility->addReading($reading);

        $reading = new Reading();
        $reading->setDate($yesterday);
        $reading->setValue(10200);
        $reading->setIsControl(false);
        $reading->setId(2);
        $this->utility->addReading($reading);

        $reading->setDate($today);
        $reading->setValue(10250);
        $reading->setIsControl(false);
        $reading->setId(3);
        $this->utility->addReading($reading);

    }

    public function testGetLastControlReading()
    {
        $lastControlReading = $this->utility->getLastControlReading();
        self::assertNotNull($lastControlReading, 'LastControl is null');
        self::assertNotInstanceOf(Reading::class, 'LastControl is not an instance of Reading');
        self::assertTrue($lastControlReading->getIsControl(), 'LastControl is not control');
    }

    public function testDiffReadings()
    {
       self::assertEquals(250, $this->utility->getLastReadingsDiff());
    }

    public function tesGetLastUncontrolledReadings()
    {
        $lastControlReadings = $this->utility->getLastUncontrolledReadings();
        self::assertCount(2, $lastControlReadings, 'Uncontrolled readings count is bad');
    }

}
