<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget;

use ArrayAccess;
use Traversable;
use Countable;

/**
 * Widget hierarchy interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetInterface extends ArrayAccess, Traversable, Countable
{
    public function setParent(WidgetInterface $parent = null);
    public function getParent();
    public function add($child, $type = null, array $options = array());
    public function get($name);
    public function has($name);
    public function remove($name);
    public function all();
    public function setData($data);
    public function getData();
    public function getConfig();
    public function getRoot();
    public function isRoot();
    public function getName();
    public function initialize();
    public function createView(WidgetView $parent = null);
}
