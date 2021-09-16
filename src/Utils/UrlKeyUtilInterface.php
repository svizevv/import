<?php

/**
 * TechDivision\Import\Utils\UrlKeyUtilInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Utils;

use TechDivision\Import\Subjects\UrlKeyAwareSubjectInterface;

/**
 * Interface for utility implementations that provides functionality to make URL keys unique.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
interface UrlKeyUtilInterface
{

    /**
     * Make's the passed URL key unique by adding the next number to the end.
     *
     * @param \TechDivision\Import\Subjects\UrlKeyAwareSubjectInterface $subject  The subject to make the URL key unique for
     * @param array                                                     $entity   The entity to make the URL key unique for
     * @param string                                                    $urlKey   The URL key to make unique
     * @param array                                                     $urlPaths The URL paths to make unique
     *
     * @return string The unique URL key
     */
    public function makeUnique(UrlKeyAwareSubjectInterface $subject, array $entity, string $urlKey, array $urlPaths = array()) : string;

    /**
     * Load the url_key if exists
     *
     * @param \TechDivision\Import\Subjects\UrlKeyAwareSubjectInterface $subject      The subject toload the URL key
     * @param int                                                       $primaryKeyId The ID from category or product
     *
     * @return string|null The URL key
     */
    public function loadUrlKey(UrlKeyAwareSubjectInterface $subject, $primaryKeyId);
}
