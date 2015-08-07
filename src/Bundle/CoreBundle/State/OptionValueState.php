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
 * Option value representation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionValueState implements OptionValueStateInterface
{
    private $parent;

    public $value;
    public $order;
    public $locked;

    public function __construct(OptionStateInterface $parent)
    {
        $this->parent = $parent;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
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
        return array('value', 'order', 'locked');
    }
}
