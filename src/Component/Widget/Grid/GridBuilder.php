<?php
namespace Accard\Component\Widget\Grid;

/**
 * Grid Builder
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Widget\Grid\Grid;
use Accard\Component\Widget\WidgetFactory;
use Accard\Component\Widget\Widget;

class GridBuilder
{
    /**
     * Grid
     */
    private $grid;

    /**
     * Row Builder Factory
     */
    public $rowBuilderFactory;

    /**
     * Column Builder Factory
     */
    public $columnBuilderFactory;

    /**
     * Widget Factory
     */
    public $widgetFactory;


    /**
     * Constructor.
     */
    public function __construct(RowBuilderFactory $rowFactory,
                                ColumnBuilderFactory $columnFactory,
                                WidgetFactory $widgetFactory)
    {
        $this->rowBuilderFactory = $rowFactory;
        $this->columnBuilderFactory = $columnFactory;
        $this->widgetFactory = $widgetFactory;
        $this->grid = new Grid;
    }

    /**
     * Add config to grid
     */
    public function addConfig(array $config)
    {
        foreach ($config as $configRow) {
            $rowBuilder = $this->rowBuilderFactory->createBuilder();
            $resolvedRow = $rowBuilder->resolveConfig($configRow);
            $rowBuilder->create($resolvedRow['id']);

            $row = $rowBuilder->getRow();

            foreach($configRow['columns'] as $configColumn) {
                $columnBuilder = $this->columnBuilderFactory->createBuilder();
                $resolvedConfig = $columnBuilder->resolveConfig($configColumn);

                $columnBuilder->create($row, $resolvedConfig['id'], $resolvedConfig['widget']);

                $this->addColumn($row, $columnBuilder->getColumn());
            }

            $this->addRow($row);
        }

        return $this;
    }

    /**
     * Get a row by id.
     * 
     * @param string|integer $rowId
     * @return Row|null
     */
    public function getRow($rowId)
    {
        try {
            return $this->resolveRow($rowId);
        } catch (\LogicException $e) {}
    }


    /**
     * Get a column, regardless of which row it is in.
     * 
     * @param string|integer $columnId
     * @return Column|null
     */
    public function getColumn($columnId)
    {
        foreach ($this->grid as $row) {
            if (isset($row[$columnId])) {
                return $row[$columnId];
            }
        }
    }

    /**
     * Add row.
     * 
     * @param Row $row
     * @return self
     */
    public function addRow(Row $row)
    {
        $this->grid->set($row->getId(), $row);

        return $this;
    }

    /**
     * Add column.
     * 
     * @param Row|string|integer $row
     * @param Column $column
     * @return self
     */
    public function addColumn($row, Column $column)
    {
        $this->resolveRow($row)->add($column);

        return $this;
    }

    /**
     * Resolve row from value.
     * 
     * @param Row|string|integer $row
     * @return Row
     * 
     * @throws LogicException If row could not be located.
     */
    private function resolveRow($row)
    {
        if ($row instanceof Row) {
            return $row;
        }

        if (!is_scalar($row) || !isset($this->grid[$row])) {
            throw new \LogicException(sprintf('Row with id "%s" could not be found.', $row));
        }

        return $this->grid[$row];
    }

    /**
     * Get grid.
     * 
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

}