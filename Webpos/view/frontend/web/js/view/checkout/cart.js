define([
    'ko',
    'jquery',
    'uiComponent',
    'Magestore_Webpos/js/model/checkout/cart',
    'Magestore_Webpos/js/model/checkout/cart/items',
    'Magestore_Webpos/js/model/appConfig',
    'Magestore_Webpos/js/model/event-manager'
], function (ko, $, Component, CartModel, Items, AppConfig, Event) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magestore_Webpos/checkout/cart'
        },
        /**
         * Show ajax loader
         */
        loading: CartModel.loading,
        /**
         * Current page (cart/checkout)
         */
        currentPage: CartModel.currentPage,
        /**
         * Check if is on checkout page
         */
        isOnCheckoutPage: CartModel.isOnCheckoutPage,
        /**
         * Cart title (number of items in cart)
         */
        cartTitle: ko.pureComputed(function() {
            return "Cart ("+ CartModel.totalItems() + ")";
        }),
        /**
         * Constructor
         */
        initialize: function () {
            this._super();
            var self = this;
            if(!this.currentPage()){
                this.currentPage(CartModel.PAGE.CART);
            }
            this.createdOrder = ko.pureComputed(function(){
                return false;
            });

            /**
             * Go to checkout
             */
            Event.observer('go_to_checkout_page', function(){
                self.switchToCheckout();
            });
            /**
             * Go to cart
             */
            Event.observer('go_to_cart_page', function(){
                self.switchToCart();
            });
            /**
             * Clear cart and go to cart page after click New Order button on Success
             */
            Event.observer('start_new_order', function(){
                self.switchToCart();
                self.emptyCart();
            });
            /**
             * Go to checkout page after save
             */
            Event.observer('save_cart_after', function(event, data){
                if(data && data.response && data.response.status){
                    Event.dispatch('go_to_checkout_page', '', true);
                }
            });
        },
        /**
         * Animate container to checkout page
         */
        goToCheckoutPage: function(){
            var checkoutSection = $(AppConfig.ELEMENT_SELECTOR.CHECKOUT_SECTION);
            if(checkoutSection.length > 0){
                checkoutSection.addClass(AppConfig.CLASS.ACTIVE);
                var mainContainer = $(AppConfig.MAIN_CONTAINER);
                if(mainContainer.length > 0) {
                    var categoryWith = mainContainer.find(AppConfig.ELEMENT_SELECTOR.COL_LEFT).width();
                    mainContainer.css({
                        left: "-" + categoryWith + "px"
                    });
                }
            }
        },
        /**
         * Animate container to cart page
         */
        goToCartPage: function(){
            var checkoutSection = $(AppConfig.ELEMENT_SELECTOR.CHECKOUT_SECTION);
            if(checkoutSection.length > 0){
                checkoutSection.removeClass(AppConfig.CLASS.ACTIVE);
                var mainContainer = $(AppConfig.MAIN_CONTAINER);
                if(mainContainer.length > 0) {
                    mainContainer.css({
                        left: "0px"
                    });
                }
            }
        },
        /**
         * Hide menu button
         */
        hideMenuButton: function(){
            var showMenuButton = $(AppConfig.ELEMENT_SELECTOR.SHOW_MENU_BUTTON);
            if(showMenuButton.length > 0){
                showMenuButton.hide();
                showMenuButton.addClass(AppConfig.CLASS.HIDE);
            }
        },
        /**
         * Show menu button
         */
        showMenuButton: function(){
            var showMenuButton = $(AppConfig.ELEMENT_SELECTOR.SHOW_MENU_BUTTON);
            if(showMenuButton.length > 0){
                showMenuButton.show();
                showMenuButton.removeClass(AppConfig.CLASS.HIDE);
            }
        },
        /**
         * Animate UI
         */
        transformInterface: function(){
            var self = this;
            switch(self.currentPage()){
                case CartModel.PAGE.CART:
                    self.goToCartPage();
                    self.showMenuButton();
                    break;
                case CartModel.PAGE.CHECKOUT:
                    self.goToCheckoutPage();
                    self.hideMenuButton();
                    break;
            }
        },
        /**
         * Start switch to cart page
         */
        switchToCart: function(){
            this.currentPage(CartModel.PAGE.CART);
            this.transformInterface();
            var mainContainer = $(AppConfig.MAIN_CONTAINER);
            if(mainContainer.length > 0){
                mainContainer.addClass(AppConfig.CLASS.SHOW_MENU);
            }
        },
        /**
         * Start switch to checkout page
         */
        switchToCheckout: function(){
            if(Items.isEmpty()){
                return;
            }else{
                this.currentPage(CartModel.PAGE.CHECKOUT);
                this.transformInterface();
                var mainContainer = $(AppConfig.MAIN_CONTAINER);
                if(mainContainer.length > 0){
                    mainContainer.removeClass(AppConfig.CLASS.SHOW_MENU);
                }
            }
        },
        /**
         * Empty cart
         */
        emptyCart: function(){
            if(CartModel.hasQuote()){
                CartModel.removeQuote();
            }else{
                CartModel.emptyCart();
            }
        }
    });
});
