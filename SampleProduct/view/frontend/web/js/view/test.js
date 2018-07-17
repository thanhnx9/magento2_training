define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
], function (ko, Component, urlBuilder,storage) {
    'use strict';
    var id=1;
    return Component.extend({

            defaults: {
                template: 'Magestore_SampleProduct/test',
            },

            productListItem: ko.observableArray([]),
            // initialize: function(){
            //     this._super();
            // }
            // ,
            getProduct: function () {
                    var self = this;
                    var serviceUrl = urlBuilder.build('sampleproduct/test/product?id=' + id);
                    id++;
                    return storage.post(
                        serviceUrl,
                        ''
                    ).done(
                        function (response) {
                            self.productListItem.push(JSON.parse(response));
                        }
                    ).fail(
                        function (response) {
                            alert(response);
                        }
                    );

            },
            getTotal: function () {
                 var computed;
                 var qty = document.getElementById('qty').value;
                 var price = document.getElementById('price').value;
                 computed = qty * price;
                 document.getElementById('total').innerHTML =computed;
                 alert("Total: "+computed);
            },

           add_to_cart: function (data) {
               var id=data.entity_id;
               var serviceUrl = urlBuilder.build('sampleproduct/test/addtocart?id=' + id);
               console.log(id);
               return storage.post(  //post url
                   serviceUrl,
                   ''
               ).done(
                   function (response) {
                       alert("Add to cart successful => Refresh cart");
                       console.log(response);
                       require([
                           'Magento_Customer/js/customer-data'
                       ], function (customerData) {
                           var sections = ['cart'];
                           customerData.invalidate(sections);
                           customerData.reload(sections, true);
                       });
                   }
               ).fail(
                   function (response) {
                       alert(response);
                   }
               );
               console.log(data);
       }
    });
});
