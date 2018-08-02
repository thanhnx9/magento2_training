define([
    'jquery',
    'uiComponent',
    'mage/storage',
    'ko',
    'Magestore_Webpos/js/model/url-builder',
    'Magestore_Webpos/js/view/customer/customer-view',
    'Magestore_Webpos/js/model/customers/customer',
    'Magestore_Webpos/js/action/customer/action'
], function ($, Component, storage, ko, urlBuilder, CustomerView, CustomerModel, CustomerAction) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magestore_Webpos/customer/customer-list'
        },
        customers: CustomerModel.customers,
        searchKey: CustomerModel.searchKey,
        pageSize: CustomerModel.pageSize,
        curPage: CustomerModel.curPage,
        isLoading: CustomerModel.isLoading,
        stopLazyLoad: CustomerModel.stopLazyLoad,

        isCustomerSelect: CustomerModel.isCustomerSelect,
        initialize: function () {
            this._super();
            CustomerAction().showList(1);
        },
        filter: function (element, event) {
            if(this.isLoading) {
                return;
            }
            this.stopLazyLoad = false;
            var searchKey = event.target.value;
            var self = this;
            var params = {};
            var serviceUrl = urlBuilder.createUrl('/webpos/customers?searchCriteria[pageSize]='+this.pageSize+
                '&searchCriteria[filterGroups][0][filters][0][field]=email' +
                '&searchCriteria[filterGroups][0][filters][0][value]=%25'+searchKey+'%25'+
                '&searchCriteria[filterGroups][0][filters][0][conditionType]=like'+
                '&searchCriteria[filterGroups][0][filters][1][field]=firstname' +
                '&searchCriteria[filterGroups][0][filters][1][value]=%25'+searchKey+'%25'+
                '&searchCriteria[filterGroups][0][filters][1][conditionType]=like'+
                '&searchCriteria[filterGroups][0][filters][2][field]=lastname' +
                '&searchCriteria[filterGroups][0][filters][2][value]=%25'+searchKey+'%25'+
                '&searchCriteria[filterGroups][0][filters][2][conditionType]=like'
                , params);
            var payload = {};
            storage.get(
                serviceUrl, JSON.stringify(payload)
            ).done(function (response) {
                CustomerModel.customers(response.items);
                CustomerModel.curPage(1);

            }).fail(function (response) {

            }).always(function (response){
                CustomerModel.isLoading = false;
            });
        },
        lazyload: function() {
            if(CustomerModel.isLoading) {
                return;
            }
            if(CustomerModel.stopLazyLoad) {
                return;
            }
            var curPage = CustomerModel.curPage() + 1;
            this.showList(curPage);
        },
        loadCustomer: function (data) {
            // $('.customer-item').removeClass('customer-active');
            // var thisItem = $(event.target);
            // if(thisItem.closest("li.customer-item").length>0){
            //     //nếu click vào cái con, thì bôi màu hết
            //     thisItem.closest("li.customer-item").addClass('customer-active');
            // }else{
            //     //nếu ko phải cái con thì thôi
            //     thisItem.addClass('customer-active');
            // }
             CustomerModel.isCustomerSelect(data.id);
             CustomerView().setData(data);
        },



    });
});

