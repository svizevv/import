<?php

/**
 * TechDivision\Import\Subjects\SubjectExecutorInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Subjects;

use TechDivision\Import\Configuration\SubjectConfigurationInterface;

/**
 * The interface for all subject executor implementations.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
interface SubjectExecutorInterface
{

    /**
     * Executes the passed subject.
     *
     * @param \TechDivision\Import\Configuration\SubjectConfigurationInterface $subject  The subject configuration instance
     * @param array                                                            $matches  The bunch matches
     * @param string                                                           $serial   The UUID of the actual import
     * @param string                                                           $pathname The path to the file to import
     *
     * @return void
     */
    public function execute(SubjectConfigurationInterface $subject, array $matches, $serial, $pathname);
}
