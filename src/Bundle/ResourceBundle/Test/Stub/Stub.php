<?php

namespace Accard\Bundle\ResourceBundle\Test\Stub;

use Accard\Component\Resource\Model\ResourceInterface;

class Stub implements ResourceInterface
{
    protected $id = 1;
    protected $sort = 1;
    protected $column = 'value';
    protected $name = 'name';

    public function getId()
    {
        return $this->id;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setImportTarget($target)
    {
        
    }
}
