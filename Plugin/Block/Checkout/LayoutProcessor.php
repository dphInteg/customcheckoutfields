<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DphInteg\CustomCheckoutFields\Plugin\Block\Checkout;

class LayoutProcessor
{
    /**
     * Process js Layout of block
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $jsLayout)
    {
       
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                ['shippingAddress']['children']['shipping-address-fieldset']['children']['barangay'] = $this->processBarangayAddress('shippingAddress');
        
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                  ['shippingAddress']['children']['shipping-address-fieldset']['children']['city'] = $this->customCity('shippingAddress');
        
          $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                ['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id'] = $this->disableRegionId('shippingAddress');

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                  ['shippingAddress']['children']['shipping-address-fieldset']['children']['reg'] = $this->customProvince('shippingAddress');

        return $jsLayout;
    }

    /**
     * Process provided address.
     *
     * @param string $dataScopePrefix
     * @return array
     */
    private function processBarangayAddress($dataScopePrefix)
    {
        return [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => $dataScopePrefix.'.custom_attributes',
                //'customScope' => 'shippingAddress',
                //'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'barangay'
            ],
            'dataScope' => $dataScopePrefix.'.custom_attributes.barangay',
            //'dataScope' => 'shippingAddress.barangay',
            'label' => __('Barangay'),
            'options' => [
                          [
                              'value' => '',
                              'label' => 'Select Barangay',
                          ]
                      ],
            'provider' => 'checkoutProvider',
            'validation' => [
               'required-entry' => true
            ],
            'sortOrder' => 100,
            'visible' => true,
            'id' => 'barangay',
            'imports' => [
                'initialOptions' => 'index = checkoutProvider:dictionaries.barangay',
                'setOptions' => 'index = checkoutProvider:dictionaries.barangay'
            ]
        ];
            
        
        /*return [
             'component' => 'Magento_Ui/js/form/element/select',
                      'config' => [
                          'customScope' => 'shippingAddress',
                          'template' => 'ui/form/field',
                          'elementTmpl' => 'ui/form/element/select',
                      ],
                      'dataScope' => 'shippingAddress.barangay',
                      'label' => 'Barangay',
                      'provider' => 'checkoutProvider',
                      'visible' => true,
                      'validation' => ['required-entry' => true],
                      'sortOrder' => 100,
                      'id' => 'barangay',
                      'options' => [
                          [
                              'value' => '',
                              'label' => 'Select Barangay',
                          ]
                      ]
                  ];*/
    }
    
    /**
     * Process provided address.
     *
     * @param string $dataScopePrefix
     * @return array
     */
    private function customCity($dataScopePrefix)
    {
        return [
             'component' => 'Magento_Ui/js/form/element/select',
                      'config' => [
                          'customScope' => 'shippingAddress',
                          'template' => 'ui/form/field',
                          'elementTmpl' => 'ui/form/element/select',
                      ],
                      'dataScope' => 'shippingAddress.city',
                      'label' => 'City',
                      'provider' => 'checkoutProvider',
                      'visible' => true,
                      'validation' => ['required-entry' => true],
                      'sortOrder' => 90,
                      'id' => 'city',
                      'options' => [
                          [
                              'value' => '',
                              'label' => 'Select City',
                          ]
                      ]
                  ];
    }
    
     /**
     * Process provided address.
     *
     * @param string $dataScopePrefix
     * @return array
     */
    private function customProvince($dataScopePrefix)
    {
        return [
             'component' => 'Magento_Ui/js/form/element/select',
                      'config' => [
                          'customScope' => 'shippingAddress',
                          'template' => 'ui/form/field',
                          'elementTmpl' => 'ui/form/element/select',
                      ],
                      'dataScope' => 'shippingAddress.reg',
                      'label' => 'State/Province',
                      'provider' => 'checkoutProvider',
                      'visible' => true,
                      'validation' => ['required-entry' => true],
                      'sortOrder' => 80,
                      'id' => 'reg',
                      'options' => $this->parseJson()
                  ];
    }
    
    /**
     * Process provided address.
     *
     * @param string $dataScopePrefix
     * @return array
     */
    private function customRegion($dataScopePrefix)
    {
        return [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'id' => 'regName'
            ],
            'dataScope' => 'shippingAddress.region',
            'label' => __('Region'),
            'provider' => 'checkoutProvider',
            'validation' => [
               'required-entry' => false
            ],
            'sortOrder' => 110,
            'visible' => true,
            'id' => 'regName'
            /*'imports' => [
                'initialOptions' => 'index = checkoutProvider:dictionaries.reg',
                'setOptions' => 'index = checkoutProvider:dictionaries.reg'
            ]*/
        ];
        
    }
    
    /**
     * Process provided address.
     *
     * @param string $dataScopePrefix
     * @return array
     */
    private function disableRegionId($dataScopePrefix)
    {
        return [
             'component' => 'Magento_Ui/js/form/element/select',
                      'config' => [
                          'customScope' => 'shippingAddress',
                          'template' => 'ui/form/field',
                          'elementTmpl' => 'ui/form/element/select',
                      ],
                      'dataScope' => 'shippingAddress.region',
                      'label' => 'State/Province',
                      'provider' => 'checkoutProvider',
                      'visible' => false,
                      'validation' => ['required-entry' => false],
                      'sortOrder' => 80,
                      'id' => 'region',
                      'options' => []
                  ];
        
    }
    
    private function parseJson() {
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
        $path = $directory->getPath('pub');
        
        if (!file_exists("{$path}/assets")) {
            mkdir("{$path}/assets/js", 0777, true);
            $source_path = str_replace('pub', '', $path);
            
            $source = "{$source_path}vendor/dphinteg/customcheckoutfields/Setup/Data";
            
            if (!file_exists($source)) {
                $source = "{$source_path}app/code/DphInteg/CustomCheckoutFields/Setup/Data";
            }
            
            $source =  "{$source}/Addresses.json";
            $target =  "{$path}/assets/js/Addresses.json";
            
            copy($source, $target);
        }

        $pathFile = "{$path}/assets/js/Addresses.json";
        $file = file_get_contents($pathFile, FILE_USE_INCLUDE_PATH);
        $json_a = json_decode($file, true);
        
        $provinces     = [["value"=> '',"label"=> 'Select Province']];
       
        foreach ($json_a as &$value) {
            
            $value = array_keys($value['province_list']) ;
          
            foreach ($value as &$province) {
                $arr_province = ["value"=> $province,"label"=> $province];
                array_push($provinces, $arr_province );
            }
        }
       
        //sorting
        // Obtain a list of columns
        foreach ($provinces as $key => $row) {
            $label[$key]  = $row['label'];
        }
        
        $label = array_column($provinces, 'label');
       
        
        // Sort the data with volume descending, edition ascending
        // Add $data as the last parameter, to sort by the common key
        array_multisort($label, SORT_ASC, $provinces);

        return $provinces;
        
    }
}