<?php
namespace Accard\Component\Widget\Grid;

/**
 * Grid Factory
 *
 * @author <piercedy@upenn.edu>
 */
use Accard\Component\Widget\Grid\GridBuilder;
use Accard\Component\Widget\WidgetFactory;

class GridFactory
{
	/**
	 * Row Builder Factory
	 */
	public $rowBuilderFactory;

	/**
	 * Column Builder Factory
	 */
	public $columnBuilderFactory;

	/**
	 * Widget Builder Factory
	 */
	public $widgetBuilderFactory;

	/**
	 * Constructor.'
	 */
	public function __construct(RowBuilderFactory $rowBuilderFactory,
								ColumnBuilderFactory $columnBuilderFactory,
								WidgetFactory $widgetBuilderFactory)
	{
		$this->rowBuilderFactory = $rowBuilderFactory;
		$this->columnBuilderFactory = $columnBuilderFactory;
		$this->widgetBuilderFactory = $widgetBuilderFactory;
	}

	/**
	 * Create a Grid Builder
	 */
	public function createBuilder()
	{
		return new GridBuilder($this->rowBuilderFactory, 
							   $this->columnBuilderFactory, 
							   $this->widgetBuilderFactory);
	}
}