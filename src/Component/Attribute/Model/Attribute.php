<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Attribute\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Accard attribute model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Attribute implements AttributeInterface
{
    use \DAG\Component\Prototype\Model\PrototypeSubjectTrait;
    use \DAG\Component\Field\Model\FieldSubjectTrait;

    /**
     * Attribute id.
     *
     * @var integer
     */
    protected $id;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
}
