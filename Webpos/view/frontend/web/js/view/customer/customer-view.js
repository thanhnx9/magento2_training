define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/storage',
    'Magestore_Webpos/js/model/url-builder',
    'mage/translate',
    'Magestore_Webpos/js/model/customers/customer',
    'Magestore_Webpos/js/action/customer/action'
], function ($, ko, Component, storage, urlBuilder, $t, CustomerModel, CustomerAction) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magestore_Webpos/customer/customer-view'
        },
        customerData: CustomerModel.customerData,
        customerGroupArray: CustomerModel.customerGroupArray,

        currentFirstName: CustomerModel.currentFirstName,
        currentLastName: CustomerModel.currentLastName,
        currentEmail: CustomerModel.currentEmail,
        currentGroupId: CustomerModel.currentGroupId,
        currentWebsiteId: CustomerModel.currentWebsiteId,
        customers: CustomerModel.customers,


        getData: function(){
            return CustomerModel.customerData();
        },

        setData: function(data){
            console.log(data);
            CustomerModel.customerData(data);
            CustomerModel.currentFirstName(data.firstname);
            CustomerModel.currentLastName(data.lastname);
            CustomerModel.currentEmail(data.email);
            CustomerModel.currentGroupId(data.group_id);
            CustomerModel.currentWebsiteId(data.website_id);
        },

        /* Save Customer Information When Edit*/
        saveInformation: function () {
            var self = this;
            if (this.validateForm('#customer-edit-form')) {
                var customerData = CustomerModel.customerData.call();
                customerData.firstname = CustomerModel.currentFirstName();
                customerData.lastname = CustomerModel.currentLastName();
                customerData.full_name = CustomerModel.currentFirstName() + ' ' + CustomerModel.currentLastName();
                customerData.email = CustomerModel.currentEmail();
                customerData.group_id = CustomerModel.currentGroupId();
                customerData.website_id = CustomerModel.currentWebsiteId();

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
                    var customers=CustomerModel.customers();
                    while(customers.length>0) {
                        customers.pop();
                    }
                    CustomerAction().showList(1);
                   //CustomerModel.customers=customerData;
                    console.log(CustomerModel.customers);
                    document.getElementById('customer-title').innerHTML=customerData.firstname +' '+customerData.lastname;
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

