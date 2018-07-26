define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/storage',
    'Magestore_Webpos/js/model/url-builder',
    'mage/translate',
    'Magestore_Webpos/js/view/customer/customer-list'
], function ($, ko, Component, storage, urlBuilder, $t, CustomerList) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magestore_Webpos/customer/customer-view'
        },
        customerData: ko.observableArray([]),
        customerGroupArray: [],

        currentFirstName: ko.observable(''),
        currentLastName: ko.observable(''),
        currentEmail: ko.observable(''),
        currentGroupId: ko.observable(''),
        currentWebsiteId: ko.observable(''),


        getData: function(){
            return this.customerData();
        },

        setData: function(data){
            console.log(data);
            this.customerData(data);
            this.currentFirstName(data.firstname);
            this.currentLastName(data.lastname);
            this.currentEmail(data.email);
            this.currentGroupId(data.group_id);
            this.currentWebsiteId(data.website_id);
        },
        /* Save Customer Information When Edit*/
        saveInformation: function () {
            var self = this;
            if (this.validateForm('#customer-edit-form')) {
                var customerData = this.customerData.call();
                customerData.firstname = this.currentFirstName();
                customerData.lastname = this.currentLastName();
                customerData.full_name = this.currentFirstName() + ' ' + this.currentLastName();
                customerData.email = this.currentEmail();
                customerData.group_id = this.currentGroupId();
                customerData.website_id = this.currentWebsiteId();

                var params = {};
                var serviceUrl = urlBuilder.createUrl('/webpos/customers/'+ customerData.id, params);
                console.log(serviceUrl);
                var payload = {
                    customer: {
                        firstname: customerData.firstname,
                        lastname: customerData.lastname,
                        email: customerData.email,
                        group_id: customerData.group_id,
                        website_id: customerData.website_id,
                    }
                };
                storage.put(
                    serviceUrl, JSON.stringify(payload)
                ).done(function (response) {
                    console.log("RESPONSE"+response);
                    console.log(customerData.firstname);
                     // var parsedResponse = $.parseHTML(customerData);
                     // var result = $(parsedResponse).find("#list-customer");
                     // $('#list-customer').replaceWith(result);
                    }).fail(function (response) {

                }).always(function (response){

                });
            }
        },

        /* Validation Form*/
        validateForm: function (form) {
            return true;
            return $(form).validation() && $(form).validation('isValid');
        },

    });


});

