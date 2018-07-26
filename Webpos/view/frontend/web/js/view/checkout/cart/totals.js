define([
    'ko',
    'jquery',
    'uiComponent',
    'Magestore_Webpos/js/model/checkout/cart',
    'Magestore_Webpos/js/model/checkout/cart/totals',
    'Magestore_Webpos/js/model/checkout/cart/items',
    'Magestore_Webpos/js/model/event-manager'
], function (ko, $, Component, CartModel, Totals, Items, Event) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magestore_Webpos/checkout/cart/totals'
        },
        isZeroTotal: ko.pureComputed(function(){
            return (Totals.grandTotal())?false:true;
        }),
        isOnCartPage: ko.pureComputed(function(){
            return (CartModel.currentPage() == CartModel.PAGE.CART)?true:false;
        }),
        isOnCheckoutPage: ko.pureComputed(function(){
            return (CartModel.currentPage() == CartModel.PAGE.CHECKOUT)?true:false;
        }),
        totals: Totals.totals,
        backToCart: function(){
            console.log("backToCart....");
            Event.dispatch('go_to_cart_page', '', true);
        },
        saveCart: function(){
            if(Items.isEmpty()){
                alert("Please add item(s) to cart!");
            }else{
                CartModel.saveQuoteBeforeCheckout();
            }
        }
    });
});
