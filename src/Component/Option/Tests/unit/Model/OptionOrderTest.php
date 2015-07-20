<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Option\Model;

use Codeception\TestCase\Test;
use Doctrine\Common\Collections\Collection;
use Accard\Component\Option\Model\OptionOrder;
use Accard\Component\Option\Test\OptionOrderableCollectionGenerator as Generator;

/**
 * Option order types class tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionOrderTest extends Test
{
    public function testOptionTypeYieldsChoices()
    {
        $this->assertInternalType('array', OptionOrder::getChoices());
    }

    public function testOptionTypeYieldsChoiceKeys()
    {
        $this->assertInternalType('array', OptionOrder::getKeys());
    }

    public function testOptionDefaultYieldsDefaultSortOrder()
    {
        $this->assertSame(OptionOrder::DEFAULT_ORDER, OptionOrder::getDefault());
    }

    public function testOptionSortAlphaAsc()
    {
        $option = $this->generateOption();
        $actual = OptionOrder::sort($option->getValues(), OptionOrder::BY_ALPHA_ASC);
        $expected = array('Alpha', 'Beta', 'Gamma', 'Theta', 'Zappa');

        $this->assertOrder($expected, $actual, 'Alphabetic sorting yields unexpected results');
    }

    public function testOptionSortAlphaDesc()
    {
        $option = $this->generateOption();
        $actual = OptionOrder::sort($option->getValues(), OptionOrder::BY_ALPHA_DESC);
        $expected = array('Zappa', 'Theta', 'Gamma', 'Beta', 'Alpha');

        $this->assertOrder($expected, $actual, 'Alphabetic sorting desc yields unexpected results');
    }

    public function testOptionSortIdAsc()
    {
        $option = $this->generateOption();
        $actual = OptionOrder::sort($option->getValues(), OptionOrder::BY_ID_ASC);
        $expected = array('Alpha', 'Beta', 'Theta', 'Zappa', 'Gamma');

        $this->assertOrder($expected, $actual, 'Id sorting yields unexpected results');
    }

    public function testOptionSortIdDesc()
    {
        $option = $this->generateOption();
        $actual = OptionOrder::sort($option->getValues(), OptionOrder::BY_ID_DESC);
        $expected = array('Gamma', 'Zappa', 'Theta', 'Beta', 'Alpha');

        $this->assertOrder($expected, $actual, 'Id sorting desc yields unexpected results');
    }

    public function testOptionSortNumber()
    {
        $option = $this->generateOption();
        $actual = OptionOrder::sort($option->getValues(), OptionOrder::BY_NUMBER);
        $expected = array('Beta', 'Alpha', 'Theta', 'Gamma', 'Zappa');

        $this->assertOrder($expected, $actual, 'Number sorting yields unexpected results');
    }

    public function testOptionSortSortsByNumberForInvalidInput()
    {
        $option = $this->generateOption();
        $actual = OptionOrder::sort($option->getValues(), 'not-a-real-one');
        $expected = array('Beta', 'Alpha', 'Theta', 'Gamma', 'Zappa');

        $this->assertOrder($expected, $actual, 'Default is not sorting by numbers.');
    }

    protected function generateOption()
    {
        return Generator::option('option', 'Option')
            ->addValue(Generator::value(22, 'Beta', 1))
            ->addValue(Generator::value(1, 'Alpha', 2))
            ->addValue(Generator::value(53, 'Theta', 3))
            ->addValue(Generator::value(76, 'Zappa', 5))
            ->addValue(Generator::value(99, 'Gamma', 4));
    }

    protected function assertOrder(array $expected, Collection $actual, $message = 'Option order does not match')
    {
        // Reduce value collection
        $reduced = array_values(array_map(array($this, 'getCollectionValues'), $actual->toArray()));

        $this->assertEquals($expected, $reduced, $message);
    }

    private function getCollectionValues($value)
    {
        return $value->getValue();
    }
}
