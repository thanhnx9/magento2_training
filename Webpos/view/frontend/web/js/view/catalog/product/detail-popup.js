define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Catalog/js/price-utils', // has function which use to format price
        'Magestore_Webpos/js/model/catalog/product/detail-popup',
        'Magestore_Webpos/js/model/checkout/cart', // model cart
    ],
    function ($, ko, Component,priceUtils, detailPopup, CartModel) {
        "use strict";
        return Component.extend({

            itemData: ko.pureComputed(function () {
                return detailPopup.itemData();
            }),
                // itemData : reference with element knockout  from detail-popup model
            defaults: {
                template: 'Magestore_Webpos/catalog/product/detail-popup'
            },
            initialize: function () {
                this._super();
                var qty=1;
                console.log(qty);
                console.log("VAO DAY NAO");
            },
            isShowAvailableQty: function(){
                return true;
            },
            formatPrice: function (price) {
                return priceUtils.formatPrice(price, window.webposConfig.priceFormat);
            },
            closeDetailPopup: function() {
                $("#popup-product-detail").hide();
                $(".wrap-backover").hide();
                $('.notification-bell').show();
                $('#c-button--push-left').show();
            },
            descQty : function() {
                var qty = document.getElementById("product_qty").value;
                var qty = qty - 1;
                if (qty < 1)
                {
                    qty = 1;
                }
                $('input[name="product_qty"]').val(qty);

            },
            incQty: function() {
                var qty = document.getElementById("product_qty").value;
                var qty = parseInt(qty) + 1;
                $('input[name="product_qty"]').val(qty);
            },
            focusQtyInput: function () {
                return true;
            },
            // qtyChanged: function () {
            //     // var newQty = parseInt($('input[name="qty"]').val());
            //     // if (isNaN(newQty)) {
            //     //     $('input[name="qty"]').val('1');
            //     //     newQty = 1;
            //     // }
            //     // if (newQty > 100) {
            //     //     newQty = 100;
            //     // }
            //     // this.qty(parseInt(newQty));
            //     // $('input[name="qty"]').val(newQty);
            // },
            prepareAddToCart: function (data) {
                console.log(data);
                var qty = document.getElementById("product_qty").value;
                var infoBuy = {
                    'product_id': data.id,
                    'name': data.name,
                    'qty': parseInt(qty)-1,
                    'unit_price': data.price,
                    'image_url': data.image,
                    'is_virtual': false
                };
               if(data.id !=null) {
                   CartModel.addProduct(infoBuy);
               }
            }
        });
    }
);
