<?php

/**
 * TechDivision\Import\Services\UrlKeyAwareProcessorInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Services;

/**
 * Interface for a URL key aware processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
interface UrlKeyAwareProcessorInterface
{

    /**
     * Load's and return's the varchar attribute with the passed params.
     *
     * @param integer $attributeCode The attribute code of the varchar attribute
     * @param integer $entityTypeId  The entity type ID of the varchar attribute
     * @param integer $storeId       The store ID of the varchar attribute
     * @param string  $value         The value of the varchar attribute
     *
     * @return array|null The varchar attribute
     * @deprecated Up from version 17.0.0
     */
    public function loadVarcharAttributeByAttributeCodeAndEntityTypeIdAndStoreIdAndValue($attributeCode, $entityTypeId, $storeId, $value);

    /**
     * Load's and return's the varchar attribute with the passed params.
     *
     * @param integer $attributeCode The attribute code of the varchar attribute
     * @param integer $entityTypeId  The entity type ID of the varchar attribute
     * @param integer $storeId       The store ID of the varchar attribute
     * @param string  $primaryKey    The value of the varchar attribute
     *
     * @return array|null The varchar attribute
     */
    public function loadVarcharAttributeByAttributeCodeAndEntityTypeIdAndStoreIdAndPrimaryKey($attributeCode, $entityTypeId, $storeId, $primaryKey);

    /**
     * Load's and return's the URL rewrite for the given request path and store ID
     *
     * @param string $requestPath The request path to load the URL rewrite for
     * @param int    $storeId     The store ID to load the URL rewrite for
     *
     * @return array|null The URL rewrite found for the given request path and store ID
     */
    public function loadUrlRewriteByRequestPathAndStoreId(string $requestPath, int $storeId);

    /**
     * Persist's the URL rewrite with the passed data.
     *
     * @param array       $row  The URL rewrite to persist
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persistUrlRewrite($row, $name = null);
}
