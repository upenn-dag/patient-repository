<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Model;

use Accard\Component\Activity\Model\Activity as BaseActivity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Accard import activity model.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ImportActivity extends BaseActivity implements ImportActivityInterface
{
    // Traits
    use \Accard\Component\Resource\Model\ImportTargetTrait;
    use ActivityTrait;

}
