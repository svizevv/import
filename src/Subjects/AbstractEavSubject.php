<?php

/**
 * TechDivision\Import\Subjects\AbstractSubject
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

use TechDivision\Import\Utils\MemberNames;
use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Utils\BackendTypeKeys;

/**
 * An abstract EAV subject implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
abstract class AbstractEavSubject extends AbstractSubject implements EavSubjectInterface, NumberConverterSubjectInterface
{

    /**
     * The trait that provides number converting functionality.
     *
     * @var \TechDivision\Import\Subjects\NumberConverterTrait
     */
    use NumberConverterTrait;

    /**
     * The available EAV attributes, grouped by their attribute set and the attribute set name as keys.
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * The available user defined EAV attributes, grouped by their entity type.
     *
     * @var array
     */
    protected $userDefinedAttributes = array();

    /**
     * The attribute set of the entity that has to be created.
     *
     * @var array
     */
    protected $attributeSet = array();

    /**
     * The available EAV attribute sets.
     *
     * @var array
     */
    protected $attributeSets = array();

    /**
     * The mapping for the supported backend types (for the EAV entity) => persist methods.
     *
     * @var array
     */
    protected $backendTypes = array(
        BackendTypeKeys::BACKEND_TYPE_DATETIME => array('persistDatetimeAttribute', 'loadDatetimeAttribute', 'deleteDatetimeAttribute'),
        BackendTypeKeys::BACKEND_TYPE_DECIMAL  => array('persistDecimalAttribute', 'loadDecimalAttribute', 'deleteDecimalAttribute'),
        BackendTypeKeys::BACKEND_TYPE_INT      => array('persistIntAttribute', 'loadIntAttribute', 'deleteIntAttribute'),
        BackendTypeKeys::BACKEND_TYPE_TEXT     => array('persistTextAttribute', 'loadTextAttribute', 'deleteTextAttribute'),
        BackendTypeKeys::BACKEND_TYPE_VARCHAR  => array('persistVarcharAttribute', 'loadVarcharAttribute', 'deleteVarcharAttribute')
    );

    /**
     * The default mappings for the user defined attributes, based on the attributes frontend input type.
     *
     * @var array
     */
    protected $defaultFrontendInputCallbackMappings = array();

    /**
     * Return's the default callback frontend input mappings for the user defined attributes.
     *
     * @return array The default frontend input callback mappings
     */
    public function getDefaultFrontendInputCallbackMappings()
    {
        return $this->defaultFrontendInputCallbackMappings;
    }

    /**
     * Intializes the previously loaded global data for exactly one bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // load the status of the actual import
        $status = $this->getRegistryProcessor()->getAttribute(RegistryKeys::STATUS);

        // load the global data, if prepared initially
        if (isset($status[RegistryKeys::GLOBAL_DATA])) {
            $this->attributes = $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::EAV_ATTRIBUTES];
            $this->attributeSets = $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::ATTRIBUTE_SETS];
            $this->userDefinedAttributes = $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::EAV_USER_DEFINED_ATTRIBUTES];
        }

        // load the default frontend callback mappings from the child instance and merge with the one from the configuration
        $defaultFrontendInputCallbackMappings = $this->getDefaultFrontendInputCallbackMappings();

        // load the available frontend input callbacks from the configuration
        $availableFrontendInputCallbacks = $this->getConfiguration()->getFrontendInputCallbacks();

        // merge the default mappings with the one's found in the configuration
        foreach ($availableFrontendInputCallbacks as $frontendInputCallbackMappings) {
            foreach ($frontendInputCallbackMappings as $frontendInput => $frontentInputMappings) {
                $defaultFrontendInputCallbackMappings[$frontendInput] = $frontentInputMappings;
            }
        }

        // load the user defined EAV attributes
        $eavUserDefinedAttributes = $this->getEavUserDefinedAttributes();

        // load the user defined attributes and add the callback mappings
        foreach ($eavUserDefinedAttributes as $eavAttribute) {
            // load attribute code and frontend input type
            $attributeCode = $eavAttribute[MemberNames::ATTRIBUTE_CODE];
            $frontendInput = $eavAttribute[MemberNames::FRONTEND_INPUT];

            // query whether or not the array for the mappings has been initialized
            if (!isset($this->callbackMappings[$attributeCode])) {
                $this->callbackMappings[$attributeCode] = array();
            }

            // set the appropriate callback mapping for the attributes input type
            if (isset($defaultFrontendInputCallbackMappings[$frontendInput])) {
                foreach ($defaultFrontendInputCallbackMappings[$frontendInput] as $defaultFrontendInputCallbackMapping) {
                    $this->callbackMappings[$attributeCode][] = $defaultFrontendInputCallbackMapping;
                }
            }
        }

        // prepare the callbacks
        parent::setUp($serial);
    }

    /**
     * Return's mapping for the supported backend types (for the product entity) => persist methods.
     *
     * @return array The mapping for the supported backend types
     */
    public function getBackendTypes()
    {
        return $this->backendTypes;
    }

    /**
     * Set's the attribute set of the product that has to be created.
     *
     * @param array $attributeSet The attribute set
     *
     * @return void
     */
    public function setAttributeSet(array $attributeSet)
    {
        $this->attributeSet = $attributeSet;
    }

    /**
     * Return's the attribute set of the product that has to be created.
     *
     * @return array The attribute set
     */
    public function getAttributeSet()
    {
        return $this->attributeSet;
    }

    /**
     * Cast's the passed value based on the backend type information.
     *
     * @param string $backendType The backend type to cast to
     * @param mixed  $value       The value to be casted
     *
     * @return mixed The casted value
     */
    public function castValueByBackendType($backendType, $value)
    {

        // cast the value to a valid timestamp
        if ($backendType === BackendTypeKeys::BACKEND_TYPE_DATETIME) {
            return $this->getDateConverter()->convert($value);
        }

        // cast the value to a string that represents the float/decimal value, because
        // PHP will cast float values implicitly to the system locales format when
        // rendering as string, e. g. with echo
        if ($backendType === BackendTypeKeys::BACKEND_TYPE_FLOAT ||
            $backendType === BackendTypeKeys::BACKEND_TYPE_DECIMAL
        ) {
            return (string) $this->getNumberConverter()->parse($value);
        }

        // cast the value to an integer
        if ($backendType === BackendTypeKeys::BACKEND_TYPE_INT) {
            return (integer) $value;
        }

        // we don't need to cast strings
        return $value;
    }

    /**
     * Return's the attribute set with the passed attribute set name.
     *
     * @param string $attributeSetName The name of the requested attribute set
     *
     * @return array The attribute set data
     * @throws \Exception Is thrown, if the attribute set or the given entity type with the passed name is not available
     */
    public function getAttributeSetByAttributeSetName($attributeSetName)
    {

        // query whether or not attribute sets for the actualy entity type code are available
        if (isset($this->attributeSets[$entityTypeCode = $this->getEntityTypeCode()])) {
            // load the attribute sets for the actualy entity type code
            $attributSets = $this->attributeSets[$entityTypeCode];

            // query whether or not, the requested attribute set is available
            if (isset($attributSets[$attributeSetName])) {
                return $attributSets[$attributeSetName];
            }

            // throw an exception, if not
            throw new \Exception(
                $this->appendExceptionSuffix(
                    sprintf('Found invalid attribute set name "%s"', $attributeSetName)
                )
            );
        }

        // throw an exception, if not
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Found invalid entity type code "%s"', $entityTypeCode)
            )
        );
    }

    /**
     * Return's the attributes for the attribute set of the product that has to be created.
     *
     * @return array The attributes
     * @throws \Exception Is thrown, if the attribute set or the given entity type with the passed name is not available
     */
    public function getAttributes()
    {

        // query whether or not, the requested EAV attributes are available
        if (isset($this->attributes[$entityTypeCode = $this->getEntityTypeCode()])) {
            // load the attributes for the entity type code
            $attributes = $this->attributes[$entityTypeCode];

            // query whether or not an attribute set has been loaded from the source file
            if (is_array($this->attributeSet) && isset($this->attributeSet[MemberNames::ATTRIBUTE_SET_NAME])) {
                // load the attribute set name
                $attributeSetName = $this->attributeSet[MemberNames::ATTRIBUTE_SET_NAME];

                // query whether or not attributes for the actual attribute set name
                if ($attributeSetName && isset($attributes[$attributeSetName])) {
                    return $attributes[$attributeSetName];
                }

                // throw an exception, if not
                throw new \Exception(
                    $this->appendExceptionSuffix(
                        sprintf('Found invalid attribute set name "%s"', $attributeSetName)
                    )
                );
            } else {
                return call_user_func_array('array_merge', array_values($attributes));
            }
        }

        // throw an exception, if not
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Found invalid entity type code "%s"', $entityTypeCode)
            )
        );
    }

    /**
     * Return's an array with the available user defined EAV attributes for the actual entity type.
     *
     * @return array The array with the user defined EAV attributes
     */
    public function getEavUserDefinedAttributes()
    {

        // initialize the array with the user defined EAV attributes
        $eavUserDefinedAttributes = array();

        // query whether or not user defined EAV attributes for the actualy entity type are available
        if (isset($this->userDefinedAttributes[$entityTypeCode = $this->getEntityTypeCode()])) {
            $eavUserDefinedAttributes = $this->userDefinedAttributes[$entityTypeCode];
        }

        // return the array with the user defined EAV attributes
        return $eavUserDefinedAttributes;
    }

    /**
     * Return's the EAV attribute with the passed attribute code.
     *
     * @param string $attributeCode The attribute code
     *
     * @return array The array with the EAV attribute
     * @throws \Exception Is thrown if the attribute with the passed code is not available
     */
    public function getEavAttributeByAttributeCode($attributeCode)
    {

        // load the attributes
        $attributes = $this->getAttributes();

        // query whether or not the attribute exists
        if (isset($attributes[$attributeCode])) {
            return $attributes[$attributeCode];
        }

        // throw an exception if the requested attribute is not available
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Can\'t load attribute with code "%s"', $attributeCode)
            )
        );
    }
}
