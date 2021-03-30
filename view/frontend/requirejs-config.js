/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var config = {
    /*map: {
        '*': {
          'Magento_Checkout/template/billing-address.html': 
              'DphInteg_CustomCheckoutFields/template/billing-address.html'
        }
    },*/
    map: {
         '*' : {
                'Magento_Checkout/js/model/new-customer-address':'DphInteg_CustomCheckoutFields/js/model/new-customer-address'
            },
         },
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'DphInteg_CustomCheckoutFields/js/action/set-shipping-information-mixin': true
            }
        }
    }
};