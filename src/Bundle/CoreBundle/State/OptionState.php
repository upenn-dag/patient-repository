<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\State;

/**
 * Object state representation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionState implements OptionStateInterface
{
    public $name;
    public $presentation;
    public $values = array();

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function addValue(OptionValueStateInterface $value)
    {
        if (!in_array($value->value, $this->values)) {
            $this->values[$value->value] = $value;
        }

        return $this;
    }

    public function getValueValues()
    {
        return array_keys($this->values);
    }

    public function generateHash()
    {
        $this->hash = md5(serialize($this));

        return $this->hash;
    }

    public function jsonSerialize()
    {
        $params = $this->__sleep();
        $out = array(
            'hash' => $this->generateHash(),
        );

        foreach ($params as $param) {
            $out[$param] = $this->$param;
        }

        return $out;
    }

    public function __sleep()
    {
        return array('name', 'presentation', 'values');
    }
}
