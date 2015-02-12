<?php
namespace Accard\Bundle\TemplateBundle\Entity;

/**
 * Template Entity
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class Template
{
	/** 
	 * Id.
	 * 
	 * @var integer
	 */
	protected $id;

	/** 
	 * Parent.
	 * 
	 * @var string
	 */
	protected $parent;

	/**
	 * Location.
	 * 
	 * @var string
	 */
	protected $location;

	/**
	 * Name.
	 * 
	 * @var string
	 */
	protected $name;

	/**
	 * Content.
	 * 
	 * @var text
	 */
	protected $content;

    /**
     * {@inheritdoc}
     */
	public function getId()
	{
		return $this->id;
	}

    /**
     * {@inheritdoc}
     */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function getParent()
	{
		return $this->parent;
	}

    /**
     * {@inheritdoc}
     */
	public function setParent($parent = null)
	{
		$this->parent = $parent;

		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function getName()
	{
		return $this->name;
	}

    /**
     * {@inheritdoc}
     */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function getLocation()
	{
		return $this->location;
	}

    /**
     * {@inheritdoc}
     */
	public function setLocation($location)
	{
		$this->location = $location;

		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function getContent()
	{
		return $this->content;
	}

    /**
     * {@inheritdoc}
     */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

}