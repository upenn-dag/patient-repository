<?php
namespace Accard\Bundle\ResourceBundle\Import;

/**
 * Source Adapter Interface
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

interface SourceAdapterInterface
{
	public function execute(array $criteria = null);
}