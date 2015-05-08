<?php
namespace Accard\Bundle\ResourceBundle\Test\Stub;

/**
 * Import Resource Stub
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\ResourceInterface;

class ImportStub implements ResourceInterface
{
	public function getName()
	{
		return 'name';
	}

	public function getManager()
	{
		return 'manager';
	}

	public function getRepository()
	{
		return 'repository';
	}

	public function isSubject()
	{
		return true;
	}

	public function isTarget()
	{
		return false;
	}

	public function getForm()
	{
		return 'form';
	}
}