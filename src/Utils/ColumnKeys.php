<?php

/**
 * TechDivision\Import\Utils\ColumnKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Utils;

/**
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class ColumnKeys
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
     * Name for the column 'admin_store_value'.
     *
     * @var string
     */
    const ADMIN_STORE_VALUE = 'admin_store_value';

    /**
     * Name for the column 'original_data'.
     *
     * @var string
     */
    const ORIGINAL_DATA = 'original_data';

    /**
     * Name for the column 'original_filename'.
     *
     * @var string
     */
    const ORIGINAL_FILENAME = 'original_filename';

    /**
     * Name for the column 'original_line_number'.
     *
     * @var string
     */
    const ORIGINAL_LINE_NUMBER = 'original_line_number';

    /**
     * Name for the column 'original_column_name'.
     *
     * @var string
     */
    const ORIGINAL_COLUMN_NAME = 'original_column_name';

    /**
     * Name for the column 'original_column_names'.
     *
     * @var string
     */
    const ORIGINAL_COLUMN_NAMES = 'original_column_names';

    /**
     * Name for the column 'sku'.
     *
     * @var string
     */
    const SKU = 'sku';

    /**
     * Name for the column 'product_type'.
     *
     * @var string
     */
    const PRODUCT_TYPE = 'product_type';

    /**
     * Name for the column 'store_view_code'.
     *
     * @var string
     */
    const STORE_VIEW_CODE = 'store_view_code';

    /**
     * Name for the column 'attribute_code'.
     *
     * @var string
     */
    const ATTRIBUTE_CODE = 'attribute_code';

    /**
     * Name for the column 'attribute_set_code'.
     *
     * @var string
     */
    const ATTRIBUTE_SET_CODE = 'attribute_set_code';

    /**
     * Name for the column 'additional_attributes'.
     *
     * @var string
     */
    const ADDITIONAL_ATTRIBUTES = 'additional_attributes';

    /**
     * Name for the column 'value'.
     *
     * @var string
     */
    const VALUE = 'value';

    /**
     * Name for the column 'sort_order'.
     *
     * @var string
     */
    const SORT_ORDER = 'sort_order';

    /**
     * Name for the column 'counter'.
     *
     * @var string
     */
    const COUNTER = 'counter';

    /**
     * Name for the column 'uniqueIdentifier'.
     *
     * @var string
     */
    const UNIQUE_IDENTIFIER = 'uniqueIdentifier';
}
