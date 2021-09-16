<?php

/**
 * TechDivision\Import\Adapter\ExportAdapterInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Adapter;

use TechDivision\Import\Serializer\SerializerFactoryInterface;
use TechDivision\Import\Configuration\Subject\ExportAdapterConfigurationInterface;

/**
 * Interface for all export adapter implementations.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
interface ExportAdapterInterface extends SerializerAwareAdapterInterface
{

    /**
     * Overwrites the default CSV configuration values with the one from the passed configuration.
     *
     * @param \TechDivision\Import\Configuration\Subject\ExportAdapterConfigurationInterface $exportAdapterConfiguration The configuration to use the values from
     * @param \TechDivision\Import\Serializer\SerializerFactoryInterface                     $serializerFactory          The serializer factory instance
     *
     * @return void
     */
    public function init(
        ExportAdapterConfigurationInterface $exportAdapterConfiguration,
        SerializerFactoryInterface $serializerFactory
    );

    /**
     * Imports the content of the CSV file with the passed filename.
     *
     * @param array   $artefacts The artefacts to be exported
     * @param string  $targetDir The target dir to export the artefacts to
     * @param integer $timestamp The timestamp part of the original import file
     * @param string  $counter   The counter part of the origin import file
     *
     * @return void
     */
    public function export(array $artefacts, $targetDir, $timestamp, $counter);

    /**
     * Return's the array with the names of the exported files.
     *
     * @return array The array with the exported filenames
     */
    public function getExportedFilenames();
}
