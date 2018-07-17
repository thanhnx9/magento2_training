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
                template: 'Magestore_KnockoutJS/test',
            },

            productList: ko.observableArray([]),

            getProduct: function () {
                    var self = this;
                    var serviceUrl = urlBuilder.build('knockout/test/product?id=' + id);
                    id++;
                    return storage.post(
                        serviceUrl,
                        ''
                    ).done(
                        function (response) {
                            self.productList.push(JSON.parse(response));
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
            // this.qty= ko.observable();
            //this.price=ko.observable();
             computed = qty * price;
            // var that=this;
            // this.total= ko.computed(function () {
            //     return  that.qty * that.price;
            // });
            document.getElementById('total').innerHTML =computed;
            alert("Total: "+computed);
        }

    });
});