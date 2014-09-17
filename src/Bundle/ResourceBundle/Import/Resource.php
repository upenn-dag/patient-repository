<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Import;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\FormTypeInterface;
use Accard\Bundle\ResourceBundle\Exception\ResourceInvalidTypeException;

/**
 * Resource.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Resource implements ResourceInterface
{
    /**
     * Resource name.
     *
     * @var string
     */
    protected $name;

    /**
     * Resource manager.
     *
     * @var ObjectManager
     */
    protected $manager;

    /**
     * Resource repository.
     *
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Resource type.
     *
     * @var integer
     */
    protected $type;

    /**
     * Resource form.
     *
     * @var FormTypeInterface|null
     */
    protected $form;


    /**
     * Constructor.
     *
     * @throws ResourceInvalidTypeException If type is not acceptable.
     * @param string $name
     * @param ObjectManager $manager
     * @param ObjectRepository $repository
     * @param integer $type
     * @param FormTypeInterface $form
     */
    public function __construct($name,
                                ObjectManager $manager,
                                ObjectRepository $repository,
                                $type,
                                FormTypeInterface $form = null)
    {
        if (!in_array($type, $this->getTypes())) {
            throw new ResourceInvalidTypeException($type);
        }

        $this->name = $name;
        $this->manager = $manager;
        $this->repository = $repository;
        $this->type = $type;
        $this->form = $form;
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
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function isSubject()
    {
        return self::SUBJECT === $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function isTarget()
    {
        return self::TARGET === $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Valid resource types.
     *
     * @return array|integer[]
     */
    private function getTypes()
    {
        return array(self::SUBJECT, self::TARGET, self::NONE);
    }

}
