/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';
        
     $(document).ready(function () {

        $(document).on('change', '[name="reg"]', function() {

           //for state/province
           
           var reg = $(this).find(':selected').text();
           
           console.log('region: '+ reg);
            
           $('input[name="region"]').val(reg)
           
           //console.log(regObject);
           
           //initialize city list
           var cityObject = $('[name="city"]');  
           cityObject.empty();
           cityObject.append("<option value=''>Select City</option>");

           
           //console.log('reset barangay list');
           
            //initialize barangay list
           var brgyObject = $('[name="custom_attributes[barangay]"]');
           brgyObject.empty();
           brgyObject.append("<option value=''>Select Barangay</option>");
           
           //console.log('change province '+reg);
           
           if(reg!=='Select Province'){
               
               $.getJSON("/pub/assets/js/Addresses.json", function(data){

            //console.log(data); // Prints: 14
            
                Object.keys(data).forEach(function(key) {
                    
                    var value = data[key]['province_list'];          
                    var exist = reg in value;
                    
                    if(exist){
                      //console.log(value);
                      
                      var city = value[reg]['municipality_list'];
                      populateCity(city)
                    }
                     
                });
              
            }).fail(function(){
                //console.log("An error has occurred.");
            });
           }
           

        });
          

        $(document).on('change', '[name="city"]', function() {

           //for cities
          
           var reg = $('select[name="reg"]').find(':selected').text();
           var city = $(this).find(':selected').text();
           
          //console.log('region '+reg);
          //console.log('change city '+city);
         
            //initialize barangay list
           var brgyObject = $('[name="custom_attributes[barangay]"]');
           brgyObject.empty();
           brgyObject.append("<option value=''>Select Barangay</option>");

           if(city!=='Select City'){
               
               $.getJSON("/pub/assets/js/Addresses.json", function(data){

            //console.log(data); // Prints: 14
            
                Object.keys(data).forEach(function(key) {
                    var value = data[key]['province_list'];
                    var exist = reg in value;
                    
                    if(exist){
                      //console.log(value);
                      
                      var brgy = value[reg]['municipality_list'][city]['barangay_list'];
                      populateBarangay(brgy);
                    }
                     
                });
              
            }).fail(function(){
                console.log("An error has occurred.");
            });
           }
           
           

        });

    });
    
    function populateRegion(data){
        
        
        
        var regObject = $('[name="region_id"]');
        regObject.Empty();
        
        Object.keys(data).forEach(function(key) {
            regObject.append("<option value='"+key+"'>"+key+"</option>");
            console.log(key);
                     
        });
        
        
        
    }
    
    function populateCity(data){
        
        //console.log(data);
        
        var cityObject = $('[name="city"]');
        
        
        Object.keys(data).forEach(function(key) {
            cityObject.append("<option value='"+key+"'>"+key+"</option>");
                     
        });
        
        
        
    }
    
    function populateBarangay(data){
        
        
        //console.log(data);
        
        var brgyObject = $('[name="custom_attributes[barangay]"]');
        /*brgyObject.empty();
        
        brgyObject.append("<option value=''>Select Barangay</option>");*/
        
        Object.keys(data).forEach(function(key) {
            var value = data[key];
            brgyObject.append("<option value='"+value+"'>"+value+"</option>");
                     
        });
        
    }
    
    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            
            console.log('shipping address: '+shippingAddress);
            
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }
            var attribute = shippingAddress.customAttributes.find(
                function (element) {
                    return element.attribute_code === 'barangay';
                }
            );

            shippingAddress['extension_attributes']['barangay'] = attribute.value;
            // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
            return originalAction();
        });
    };

});

