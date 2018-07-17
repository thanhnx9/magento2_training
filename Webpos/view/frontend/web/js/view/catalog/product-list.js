define([
    'jquery',
    'uiComponent',
    'mage/storage', // use to call api
    'ko',
    'Magestore_Webpos/js/model/url-builder', // create url for api
    'Magestore_Webpos/js/model/checkout/cart', // model cart
    'Magento_Catalog/js/price-utils', // has function which use to format price
    'Magestore_Webpos/js/model/catalog/product/detail-popup', // model of detail popu
    'Magestore_Webpos/js/model/event-manager'
], function ($, Component, storage, ko, urlBuilder, CartModel, priceUtils, detailPopup, eventManager) {

    'use strict';

    return Component.extend({


        defaults: {
            template: 'Magestore_Webpos/catalog/product-list'
        },
        product: ko.observableArray([]), // array element
        curPage: ko.observable(1),      // first value = 1 => page 1
        numberOfProduct: ko.observable(0),  // count of all product
        numberOfPage: ko.observable(0), //count of all page
        searchKey: ko.observable(''),   // key  search
        quote: ko.observableArray([]),

        initialize: function () {
            var self = this;
            this._super();
            self.showProduct(1);
        },

        showProduct: function (curPage) {// show list product from  current page number
            var self = this;
            var params = {};
            console.log("VAO showProduct(1)");
            var serviceUrl = urlBuilder.createUrl('/webpos/products?searchCriteria[pageSize]=16' +
                '&searchCriteria[currentPage]='+curPage +
                '&searchCriteria[filterGroups][0][filters][0][field]=type_id' +
                '&searchCriteria[filterGroups][0][filters][0][value]=simple' +
                '&searchCriteria[filterGroups][0][filters][0][conditionType]=eq'
                , params);

            var payload = {};
            $('#product-list-overlay').show();
            storage.get(
                serviceUrl, JSON.stringify(payload)
            ).done(function (response) {

                self.product(response.items);
                console.log(response.items);
                self.numberOfProduct(response.total_count);
                self.numberOfPage(response.total_count/16 + 1);
                self.curPage(curPage);
                $('#product-list-overlay').hide();
                //self.hideLoader();
            }).fail(function (response) {
                $('#product-list-overlay').hide()
            });
        },


        searchProduct: function (key, curPage) {// show list product from key search  and current page number
            var self = this;
            var params = {};
            var serviceUrl = urlBuilder.createUrl('/webpos/products?searchCriteria[pageSize]=16' +
                '&searchCriteria[currentPage]='+curPage +
                '&searchCriteria[filterGroups][0][filters][0][field]=type_id' +
                '&searchCriteria[filterGroups][0][filters][0][value]=simple' +
                '&searchCriteria[filterGroups][0][filters][0][conditionType]=eq' +
                '&searchKey=' + key
                , params);
            var payload = {};
            $('#product-list-overlay').show();
            storage.get(
                serviceUrl, JSON.stringify(payload)
            ).done(function (response) {
                self.product(response.items);
                self.numberOfProduct(response.total_count);
                self.numberOfPage(response.total_count/16 + 1);
                self.curPage(curPage);
                //self.hideLoader();
                $('#product-list-overlay').hide();
            }).fail(function (response) {
                $('#product-list-overlay').hide();
            });
        },

        formatPrice: function (price) {
            return priceUtils.formatPrice(price, window.webposConfig.priceFormat);
        },

        filter: function () { // search product from key
            this.curPage(1);
            this.searchProduct(this.searchKey(), this.curPage());
        },

        next: function () { // next page
            var curPage = this.curPage();
            this.searchProduct(this.searchKey(), curPage + 1);
        },

        previous: function () { // previous page
            var curPage = this.curPage();
            this.searchProduct(this.searchKey(), curPage - 1);
        },
        getAllCategories: function () {
            eventManager.dispatch('load_product_by_category', {"catagory":{}});
        },
        showPopupDetails: function (item,event) { // show detail of product
            detailPopup.itemData(item); // set data from item to model detail product
            $("#popup-product-detail").show();
            $("#popup-product-detail").removeClass("fade");
            $(".wrap-backover").show();

            $(document).click(function(e) {
                if( e.target.id == 'popup-product-detail') {
                    $("#popup-product-detail").hide();
                    $(".wrap-backover").hide();
                    $('.notification-bell').show();
                    $('#c-button--push-left').show();
                }
            });
        },
        addToCart: function (data) {
            console.log(data);
            var infoBuy = {
                'product_id': data.id,
                'name': data.name,
                'qty': 1,
                'unit_price': data.price,
                'image_url': data.image,
                'is_virtual': false
            };
            CartModel.addProduct(infoBuy);
        }

    });
})
