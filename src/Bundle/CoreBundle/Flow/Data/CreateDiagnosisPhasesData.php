<?php

namespace Accard\Bundle\CoreBundle\Flow\Data;

use Doctrine\Common\Collections\ArrayCollection;

class CreateDiagnosisPhasesData
{
	public $patient;
	public $diagnosis;
	public $phases;

	public function __construct()
	{
		$this->phases = new ArrayCollection();
	}
}
