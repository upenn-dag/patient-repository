<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CanvasBundle\Doctrine\ORM;

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Bundle\CanvasBundle\Entity\Canvas;
/**
 * Basic canvas repository.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class CanvasRepository extends EntityRepository
{
    public function findOneOrCreate($criteria)
    {
        $canvas = $this->findOneBy($criteria);

        if (null === $canvas)
        {
            $canvas = new Canvas;
            $canvas->setRoute($criteria['route']);
        }

        return $canvas;
    }

    public function save(Canvas $canvas)
    {
        return $canvas;
    }

}
