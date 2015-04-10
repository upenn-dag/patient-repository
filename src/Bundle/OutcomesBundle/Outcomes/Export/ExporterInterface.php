<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes\Export;

use Accard\Bundle\OutcomesBundle\Outcomes\TransDataset;
use Symfony\Component\HttpFoundation\Response;

/**
 * Outcomes exporter interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ExporterInterface
{
    /**
     * Export data.
     *
     * @param TransDataset $dataset
     * @param array|null $options
     * @return string
     */
    public function export(TransDataset $dataset, array $options = null);

    /**
     * Format a response object.
     *
     * @param Response $response
     */
    public function formatResponse(Response $response);
}
