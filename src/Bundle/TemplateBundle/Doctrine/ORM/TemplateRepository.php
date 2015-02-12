<?php
namespace Accard\Bundle\TemplateBundle\Doctrine\ORM;

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Bundle\TemplateBundle\Entity\Template;

/**
 * Template repository.
 *
 * @author Dylan Pierce <dylan@upenn.edu>
 */
class TemplateRepository extends EntityRepository
{

    public function findOneOrCreate($criteria)
    {
        $template = $this->findOneBy($criteria);

        if (null === $template)
        {
            $template = new Template();
        }

        return $template;
    }
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'template';
    }
}
