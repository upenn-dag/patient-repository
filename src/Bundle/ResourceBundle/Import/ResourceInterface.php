<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Import;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Resource interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ResourceInterface
{
    const SUBJECT = 0;
    const TARGET = 1;
    const NONE = 2;


    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get manager.
     *
     * @return ObjectManager
     */
    public function getManager();

    /**
     * Get repository.
     *
     * @return ObjectRepository
     */
    public function getRepository();

    /**
     * Test if resource is subject.
     *
     * @return boolean
     */
    public function isSubject();

    /**
     * Test if resource is target.
     *
     * @return boolean
     */
    public function isTarget();

    /**
     * Get form.
     *
     * @return FormTypeInterface
     */
    public function getForm();
}
