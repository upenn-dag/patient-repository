<?php
namespace Accard\Component\Widget\Grid;

/**
 * Row Builder Factory
 *
 * @author <piercedy@upenn.edu>
 */
use Accard\Component\Widget\Grid\RowBuilder;

class RowBuilderFactory
{
	/**
	 * Create a Grid Builder
	 */
	public function createBuilder()
	{
		return new RowBuilder;
	}
}