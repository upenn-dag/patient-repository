<?php
namespace Accard\Component\Widget\Grid;

/**
 * Column Factory
 *
 * @author <piercedy@upenn.edu>
 */
use Accard\Component\Widget\Grid\ColumnBuilder;
use Accard\Component\Widget\WidgetFactory;

class ColumnBuilderFactory
{
	public function __construct(WidgetFactory $factory)
	{
		$this->widgetFactory = $factory;
	}
	/**
	 * Create a Grid Builder
	 */
	public function createBuilder()
	{
		return new ColumnBuilder($this->widgetFactory);
	}
}