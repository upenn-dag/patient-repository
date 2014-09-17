<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OptionBundle\Provider;

use Accard\Component\Option\Model\OptionInterface;
use Accard\Component\Option\Provider\OptionProviderInterface;
use Accard\Component\Option\Repository\OptionRepositoryInterface;
use Accard\Component\Option\Exception\OptionNotFoundException;

/**
 * Repository backed option provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RepositoryOptionProvider implements OptionProviderInterface
{
    /**
     * Option repository.
     *
     * @var OptionRepositoryInterface
     */
    protected $optionRepository;


    /**
     * Constructor.
     *
     * @param OptionRepositoryInterface $optionRepository
     */
    public function __construct(OptionRepositoryInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($optionName)
    {
        $option = $this->optionRepository->findOneByName(array('name' => $optionName));

        if (!$option instanceof OptionInterface) {
            throw new OptionNotFoundException($optionName);
        }

        return $option;
    }
}
