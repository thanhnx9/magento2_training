define([
    'jquery',
    'uiComponent',
    'mage/storage',
    'ko',
    'Magestore_Webpos/js/model/url-builder',
    'Magestore_Webpos/js/view/customer/customer-view'
], function ($, Component, storage, ko, urlBuilder, CustomerView) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magestore_Webpos/customer/customer-list'
        },
        customers: ko.observable([]),
        searchKey: ko.observable(''),
        pageSize: 10,
        curPage: ko.observable(1),
        isLoading: false,
        stopLazyLoad: false,

        initialize: function () {
            var self = this;
            this._super();
            self.showList(1);
        },

        addItemsToList: function(items){
            var customers = this.customers();
            for(var i in items){
                customers.push(items[i]);
            }
            this.customers(customers);
        },

        showList: function (pageNumber) {
            var self = this;
            var params = {};
            this.customerView=CustomerView();
            var serviceUrl = urlBuilder.createUrl('/webpos/customers?searchCriteria[pageSize]='+this.pageSize+'&searchCriteria[currentPage]='+pageNumber, params);
            var payload = {};
            this.isLoading = true;
            storage.get(
                serviceUrl, JSON.stringify(payload)
            ).done(function (response) {
                self.addItemsToList(response.items);
                self.curPage(pageNumber);
                if(pageNumber * self.pageSize >= response.total_count) {
                    self.stopLazyLoad = true;
                }
                if(!self.customerView.getData() || self.customerView.getData().id){
                    self.customerView.setData(response.items[0]);
                }
            }).fail(function (response) {

            }).always(function (response){
                self.isLoading = false;
            });
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
                self.customers(response.items);
                self.curPage(1);

            }).fail(function (response) {

            }).always(function (response){
                self.isLoading = false;
            });
        },
        lazyload: function() {
            if(this.isLoading) {
                return;
            }
            if(this.stopLazyLoad) {
                return;
            }
            var curPage = this.curPage() + 1;
            this.showList(curPage);
        },
        loadCustomer: function (data) {
            CustomerView().setData(data);
        }


    });
});

