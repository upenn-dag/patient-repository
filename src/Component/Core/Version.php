<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core;

/**
 * Accard patient repository core versioning.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
final class Version
{
    /**
     * Core simple version, this contains the current release in the form of:
     *
     * major.minor.release
     *
     * For example: 1.0, 1.0.1, etc.
     *
     * @var    string
     */
    const SIMPLE = '1.0.0 Release Candidate 1';

    /**
     * Major version number
     *
     * @var    integer
     */
    const MAJOR = 1;

    /**
     * Minor version number
     *
     * @var    integer
     */
    const MINOR = 0;

    /**
     * Release version number
     *
     * @var    integer
     */
    const RELEASE = 0;

    /**
     * Core version ID, this contains the version id in the form of:
     *
     * id = (major_version * 10000) + (minor_version * 100) + release_version
     *
     * Examples of a version id value can be:
     *
     * 1.0.0    10000
     * 1.1.0    10100
     * 1.2.2    10202
     *
     * @var    integer
     */
    const ID = 10000;

    /**
     * Development preview mode, this is set to true if this is a development
     * release, such as an Alpha, Beta or Release Candidate.
     *
     * @var    boolean
     */
    const PREVIEW = true;

    /**
     * Development preview type, this is set to the preview type, like 'Alpha',
     * 'Beta' or 'Release Candidate' if this is a preview release. This is only
     * set if this is a preview release.
     *
     * @var    string
     */
    const PREVIEW_TYPE = 'Release Candidate';

    /**
     * Development preview number, this is set to the preview number for the
     * current preview type. This is only set if this is a preview release.
     *
     * @var    integer
     */
    const PREVIEW_NUMBER = 1;

    /**
     * Core version string, this is the full version string, which includes the
     * pre-release name, version and the version number of the upcoming version
     * if this is a pre-release. For example:
     *
     * 1.0.0 Alpha 1
     * 1.0.3 Release Candidate 2
     * 1.0.4
     *
     * @var    string
     */
    const FULL = '1.0.0 Release Candidate 1 (Experimental)';
}
