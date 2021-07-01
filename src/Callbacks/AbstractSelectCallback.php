<?php

/**
 * TechDivision\Import\Callbacks\SelectCallback
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Callbacks;

use TechDivision\Import\Utils\MemberNames;
use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Utils\StoreViewCodes;
use TechDivision\Import\Observers\AttributeCodeAndValueAwareObserverInterface;

/**
 * A callback implementation that converts the passed select value.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
abstract class AbstractSelectCallback extends AbstractEavAwareCallback
{

    /**
     * Will be invoked by a observer it has been registered for.
     *
     * @param \TechDivision\Import\Observers\AttributeCodeAndValueAwareObserverInterface|null $observer The observer
     *
     * @return mixed The modified value
     */
    public function handle(AttributeCodeAndValueAwareObserverInterface $observer = null)
    {

        // set the observer
        $this->setObserver($observer);

        // load the attribute code and value
        $attributeCode = $observer->getAttributeCode();
        $attributeValue = $observer->getAttributeValue();

        // query whether or not a value for the attibute with the diven code has been set
        if ($attributeValue == null || $attributeValue === '') {
            return;
        }

        // load the store ID
        $storeId = $this->getStoreId(StoreViewCodes::ADMIN);

        // try to load the attribute option value and return the option ID
        if ($eavAttributeOptionValue = $this->loadAttributeOptionValueByEntityTypeIdAndAttributeCodeAndStoreIdAndValue($this->getEntityTypeId(), $attributeCode, $storeId, $attributeValue)) {
            return $eavAttributeOptionValue[MemberNames::OPTION_ID];
        }

        // query whether or not we're in debug mode
        if ($this->isDebugMode()) {
            // log a warning and return immediately
            $this->getSystemLogger()->warning(
                $this->appendExceptionSuffix(
                    sprintf(
                        'Can\'t find select option value "%s" for attribute "%s"',
                        $attributeValue,
                        $attributeCode
                    )
                )
            );
            // add the missing option value to the registry
            $this->mergeAttributesRecursive(
                array(
                    RegistryKeys::MISSING_OPTION_VALUES => array(
                        $attributeCode => array(
                            $attributeValue => array(
                                $this->raiseCounter($attributeValue),
                                array($this->getUniqueIdentifier() => true)
                            )
                        )
                    )
                )
            );
        } elseif ($this->isStrictMode()) {
            // throw an exception if the attribute is NOT
            // available and we're not in debug mode
            throw new \Exception(
                $this->appendExceptionSuffix(
                    sprintf(
                        'Can\'t find select option value "%s" for attribute "%s"',
                        $attributeValue,
                        $attributeCode
                    )
                )
            );
        }
    }
}
