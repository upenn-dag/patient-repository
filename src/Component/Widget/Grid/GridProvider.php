<?php
namespace Accard\Component\Widget\Grid;

/**
 * Grid Provider
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Widget\Grid\GridFactory;
use Accard\Bundle\CanvasBundle\Doctrine\ORM\CanvasRepository;

class GridProvider
{
	/**
	 * Canvas Repository
	 */
	private $canvasRepository;

	/**
	 * Grid Factory
	 */
	private $gridFactory;

	/**
	 * Constructor.
	 */
	public function __construct(CanvasRepository $canvasRepository,
								GridFactory $gridFactory)
	{
		$this->canvasRepository = $canvasRepository;
		$this->gridFactory = $gridFactory;
	}


    public function createCanvas($defaultGridLayout, $storedGridIdentifier, $data)
    {
        $builder = $this->gridFactory->createBuilder();

        // Try and get stored grid first...
        if ($this->hasStoredGridLayout($storedGridIdentifier)) {
            $this->loadStoredGridLayout($builder, $storedGridIdentifier);
        } else {
            $this->loadDefaultGridLayout($builder, $defaultGridLayout);
        }

        return $defaultGridLayout . ' - ' . $storedGridIdentifier . ' - ' . get_class($data);
    }

    /**
     * Test if route has an associated grid in storage
     */
    private function hasStoredGridLayout($name)
    {
        // Grab the grid from storage or return false if none found, at which point, it
        // will use the default one in the createCanvas method.
        $storedLayout = $this->canvasRepository->findOneBy(array('route' => $name));

        if(is_null($storedLayout)) {
            return false;
        }

        return true;
    }

    /**
     * Retrieve a grid and load the config to it
     */
    private function loadStoredGridLayout($builder, $storedGridIdentifier)
    {
        $canvas = $this->canvasRepository->findOneBy(array('route' => $storedGridIdentifier));

        $builder->addConfig($canvas->getGrid());
    }

    /**
     * Load the default grid
     */
    private function loadDefaultGridLayout(GridBuilder $builder, $name)
    {
        if (is_array($name)) {
            $builder->addConfig($name);
        } elseif (is_string($name)) {
            $builder->addConfig($this->getDefaultLayoutByName($name));
        } else {
            throw new \InvalidArgumentException('Unknown default grid layout type.');
        }
    }

    private function getDefaultLayoutByName($name)
    {
        $config = array();
        $parts = explode(':', $name);
        $rowStart = 0;

        foreach ($parts as $part) {
            $config = array_merge($config, $this->getRowsFromName($part, $rowStart));
            $rowStart = count($config);
        }

        return $config;
    }

    private function getRowsFromName($name, $rowStart)
    {
        list($rows, $columns) = explode('x', $name);
        $rows = range(1, $rows);
        $columns = range(1, $columns);
        $config = array();

        foreach ($rows as $row) {
            $rowId = 'r' . ($row+$rowStart);
            $rowArray = array('id' => $rowId, 'columns' => array());
            foreach ($columns as $column) {
                $columnId = $rowId.'c'.$column;
                $columnArray = array('id' => $columnId, 'widget' => array());
                $rowArray['columns'][] = $columnArray;
            }

            $config[] = $rowArray;
            unset($rowId, $rowArray, $columnId, $columnArray);
        }

        return $config;
    }
}