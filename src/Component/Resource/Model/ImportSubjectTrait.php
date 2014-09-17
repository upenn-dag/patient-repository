<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Model;

use Accard\Component\Resource\Exception\ImportTargetAlreadySetException;

/**
 * Import subject trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait ImportSubjectTrait
{
	/**
	 * Import target.
	 *
	 * @var ImportTargetInterface|null
	 */
	protected $target;


    /**
     * {@inheritdoc}
     */
    public function setImportTarget(ImportTargetInterface $target = null)
    {
    	if (null !== $this->target) {
    		throw new ImportTargetAlreadySetException($target, $this);
    	}

    	$target->setImportSubject($this);
    	$this->target = $target;

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImportTarget()
    {
    	return $this->target;
    }

    /**
     * {@inheritdoc}
     */
    public function hasImportTarget()
    {
    	return $this->target instanceof ImportTargetInterface;
    }
}
