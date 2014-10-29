<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient;

/**
 * Patient utilities.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Utils
{
    /**
     * Parse fore and sur-names from a full name string.
     *
     * Returns: array('forename' => 'firstname'[, 'surname' => 'lastname'])
     *
     * @param string $name
     * @return array
     */
    public static function parseName($name)
    {
        $nameArray = array('forename' => '', 'surname' => '');
        $name = trim($name);
        if (false === strpos($name, ' ')) {
            $nameArray['forename'] = $name;
        } else {
            $parts = explode(' ', $name);
            $nameArray['forename'] = array_shift($parts);
            $nameArray['surname'] = implode(' ', $parts);
        }

        return $nameArray;
    }
}
