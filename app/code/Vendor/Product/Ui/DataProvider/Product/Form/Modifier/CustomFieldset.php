<?php
namespace Vendor\Product\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\MultiSelect;
use Magento\Ui\Component\Form\Field;

class CustomFieldset extends AbstractModifier
{

    // Components indexes
    const CUSTOM_FIELDSET_INDEX = 'custom_fieldset';
    const CUSTOM_FIELDSET_CONTENT = 'custom_fieldset_content';
    const CONTAINER_HEADER_NAME = 'custom_fieldset_content_header';

    // Fields names
    const FIELD_NAME_TEXT = 'example_text_field';
    const FIELD_NAME_SELECT = 'example_select_field';
    const FIELD_NAME_MULTISELECT = 'example_multiselect_field';

    /**
     * @var \Magento\Catalog\Model\Locator\LocatorInterface
     */
    protected $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var array
     */
    protected $meta = [];

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        LocatorInterface $locator,
        ArrayManager $arrayManager,
        UrlInterface $urlBuilder
    ) {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Data modifier, does nothing in our example.
     *
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Meta-data modifier: adds ours fieldset
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $this->meta = $meta;
        $this->addCustomFieldset();

        return $this->meta;
    }

    /**
     * Merge existing meta-data with our meta-data (do not overwrite it!)
     *
     * @return void
     */
    protected function addCustomFieldset()
    {
        $this->meta = array_merge_recursive(
            $this->meta,
            [
                static::CUSTOM_FIELDSET_INDEX => $this->getFieldsetConfig(),
            ]
        );
    }


    /**
     * Declare ours fieldset config
     *
     * @return array
     */
    protected function getFieldsetConfig()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Fieldset Title'),
                        'componentType' => Fieldset::NAME,
                        'dataScope' => static::DATA_SCOPE_PRODUCT, // save data in the product data
                        'provider' => static::DATA_SCOPE_PRODUCT . '_data_source',
                        'ns' => static::FORM_NAME,
                        'collapsible' => true,
                        'sortOrder' => 10,
                        'opened' => true,
                    ],
                ],
            ],
            'children' => [
                static::CONTAINER_HEADER_NAME => $this->getHeaderContainerConfig(10),
                static::FIELD_NAME_TEXT => $this->getTextFieldConfig(20),
//                static::FIELD_NAME_SELECT => $this->getSelectFieldConfig(30),
//                static::FIELD_NAME_MULTISELECT => $this->getMultiSelectFieldConfig(40),
            ],
        ];
    }

    /**
     * Get config for header container
     *
     * @param int $sortOrder
     * @return array
     */
    protected function getHeaderContainerConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => null,
                        'formElement' => Container::NAME,
                        'componentType' => Container::NAME,
                        'template' => 'ui/form/components/complex',
                        'sortOrder' => $sortOrder,
                        'content' => __('You can write any text here'),
                    ],
                ],
            ],
            'children' => [],
        ];
    }

    /**
     * Example text field config
     *
     * @param $sortOrder
     * @return array
     */
    protected function getTextFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Example Text Field'),
                        'formElement' => Field::NAME,
                        'componentType' => Input::NAME,
                        'dataScope' => static::FIELD_NAME_TEXT,
                        'dataType' => Number::NAME,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];
    }

    /**
     * Example select field config
     *
     * @param $sortOrder
     * @return array
     */
    protected function getSelectFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Options Select'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => static::FIELD_NAME_SELECT,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'options' => $this->_getOptions(),
                        'visible' => true,
                        'disabled' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Example multi-select field config
     *
     * @param $sortOrder
     * @return array
     */
    protected function getMultiSelectFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Options Multiselect'),
                        'componentType' => Field::NAME,
                        'formElement' => MultiSelect::NAME,
                        'dataScope' => static::FIELD_NAME_MULTISELECT,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'options' => $this->_getOptions(),
                        'visible' => true,
                        'disabled' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Get example options as an option array:
     *      [
     *          label => string,
     *          value => option_id
     *      ]
     *
     * @return array
     */
    protected function _getOptions()
    {
        $options = [
            1 => [
                'label' => __('Option 1'),
                'value' => 1
            ],
            2 => [
                'label' => __('Option 2'),
                'value' => 2
            ],
            3 => [
                'label' => __('Option 3'),
                'value' => 3
            ],
        ];

        return $options;
    }
}
?>