<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Option\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

/**
 * Option order types.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionOrder
{
    const BY_ALPHA_ASC = 'alphabetical';
    const BY_ALPHA_DESC = 'reverse-alphabetical';
    const BY_ID_ASC = 'id';
    const BY_ID_DESC = 'reverse-id';
    const BY_NUMBER = 'numeric';

    const DEFAULT_ORDER = self::BY_NUMBER;

    /**
     * Get option order chocies.
     *
     * @return array
     */
    public static function getChoices()
    {
        return array(
            self::DEFAULT_ORDER => 'Default',
            self::BY_ALPHA_ASC => 'A-Z',
            self::BY_ALPHA_DESC => 'Z-A',
            self::BY_ID_DESC => 'Newest First',
            self::BY_ID_ASC => 'Oldest First',
        );
    }

    /**
     * Get option order keys.
     *
     * @return array
     */
    public static function getKeys()
    {
        return array_keys(static::getChoices());
    }

    /**
     * Get default option order.
     *
     * @return string
     */
    public static function getDefault()
    {
        return self::DEFAULT_ORDER;
    }

    /**
     * Sort existing value collection utility.
     *
     * @param Collection $values
     * @param string $sortKey
     * @return Collection
     */
    public static function sort(Collection $values, $sortKey)
    {
        $criteria = new Criteria();

        switch ($sortKey) {
            case self::BY_ALPHA_ASC:
                $criteria->orderBy(array('value' => Criteria::ASC));
            break;
            case self::BY_ALPHA_DESC:
                $criteria->orderBy(array('value' => Criteria::DESC));
            break;
            case self::BY_ID_ASC:
                $criteria->orderBy(array('id' => Criteria::ASC));
            break;
            case self::BY_ID_DESC:
                $criteria->orderBy(array('id' => Criteria::DESC));
            break;
            case self::BY_NUMBER:
            default:
                $criteria->orderBy(array('order' => Criteria::ASC));
            break;
        }

        return $values->matching($criteria);
    }
}
