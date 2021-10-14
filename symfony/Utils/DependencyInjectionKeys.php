<?php

/**
 * TechDivision\Import\Utils\DependencyInjectionKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-app-simple
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Utils;

/**
 * A utility class for the DI service keys.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-app-simple
 * @link      http://www.techdivision.com
 */
class DependencyInjectionKeys
{

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * The key for the application instance.
     *
     * @var string
     */
    const APPLICATION = 'application';

    /**
     * The key for the configuration service.
     *
     * @var string
     */
    const CONFIGURATION = 'configuration';

    /**
     * The key for the vendor directory.
     *
     * @var string
     */
    const CONFIGURATION_VENDOR_DIR = 'import_cli.configuration.vendor.dir';

    /**
     * The key for the goodby export adapter service.
     *
     * @var string
     */
    const IMPORT_ADAPTER_EXPORT = 'import.adapter.export';

    /**
     * The key for the CSV import adapter service.
     *
     * @var string
     */
    const IMPORT_ADAPTER_IMPORT_CSV = 'import.adapter.import.csv';

    /**
     * The key for the CSV export adapter service.
     *
     * @var string
     */
    const IMPORT_ADAPTER_EXPORT_CSV = 'import.adapter.export.csv';

    /**
     * The key for the CSV import adapter service.
     *
     * @var string
     */
    const IMPORT_ADAPTER_IMPORT_CSV_FACTORY = 'import.adapter.import.csv.factory';

    /**
     * The key for the CSV export adapter service.
     *
     * @var string
     */
    const IMPORT_ADAPTER_EXPORT_CSV_FACTORY = 'import.adapter.export.csv.factory';

    /**
     * The key for the simple PHP filesystem adapter service.
     *
     * @var string
     */
    const IMPORT_ADAPTER_FILESYSTEM_FACTORY_PHP = 'import.adapter.filesystem.factory.php';

    /**
     * The key for the simple PHP filesystem adapter service.
     *
     * @var string
     */
    const IMPORT_ADAPTER_FILESYSTEM_FACTORY_LEAGUE = 'import.adapter.filesystem.factory.league';

    /**
     * The key for the import processor service.
     *
     * @var string
     */
    const IMPORT_PROCESSOR_IMPORT = 'import.processor.import';

    /**
     * The key for the cache warmer or the EAV attribute option value repository.
     *
     * @var string
     */
    const IMPORT_CACHE_WARMER_EAV_ATTRIBUTE_OPTION_VALUE_REPOSITORY = 'import.repository.cache.warmer.eav.attribute.option.value';

    /**
     * The key for the CSV import bunch file resolver service.
     *
     * @var string
     */
    const IMPORT_SUBJECT_FILE_RESOLVER_SIMPLE = 'import.subject.file.resolver.simple';

    /**
     * The key for the OK file aware CSV import bunch file resolver service.
     *
     * @var string
     */
    const IMPORT_SUBJECT_FILE_RESOLVER_OK_FILE_AWARE = 'import.subject.file.resolver.ok.file.aware';

    /**
     * The key for the OK file CSV import bunch file writer service.
     *
     * @var string
     */
    const IMPORT_SUBJECT_FILE_WRITER_OK_FILE_AWARE = 'import.subject.file.writer.ok.file.aware';

    /**
     * The key for the simple number converter service.
     *
     * @var string
     */
    const IMPORT_SUBJECT_NUMBER_CONVERTER_SIMPLE = 'import.subject.number.converter.simple';

    /**
     * The key for the simple date converter service.
     *
     * @var string
     */
    const IMPORT_SUBJECT_DATE_CONVERTER_SIMPLE = 'import.subject.date.converter.simple';

    /**
     * The key for the value CSV serializer.
     *
     * @var string
     */
    const IMPORT_SERIALIZER_CSV_VALUE = 'import.serializer.csv.value';

    /**
     * The key for the category CSV serializer.
     *
     * @var string
     */
    const IMPORT_SERIALIZER_CSV_CATEGORY = 'import.serializer.csv.category';

    /**
     * The key for the product category CSV serializer.
     *
     * @var string
     */
    const IMPORT_SERIALIZER_CSV_PRODUCT_CATEGORY = 'import.serializer.csv.product.category';

    /**
     * The key for the additional attribute CSV serializer.
     *
     * @var string
     */
    const IMPORT_SERIALIZER_CSV_ADDITIONAL_ATTRIBUTE = 'import.serializer.csv.additional.attribute';

    /**
     * The key for the additional attribute CSV serializer factory.
     *
     * @var string
     */
    const IMPORT_SERIALIZER_FACTORY_CSV_VALUE = 'import.serializer.factory.csv.value';

    /**
     * The key for the additional attribute CSV serializer factory.
     *
     * @var string
     */
    const IMPORT_SERIALIZER_FACTORY_CSV_ADDITIONAL_ATTRIBUTE = 'import.serializer.factory.csv.additional.attribute';
}
