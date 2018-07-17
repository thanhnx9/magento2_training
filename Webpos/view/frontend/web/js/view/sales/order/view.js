define(
    [
        'require',
        'jquery',
        'ko',
        'uiComponent',
        'mage/translate',
        'Magestore_Webpos/js/model/sales/order/total',
        'Magestore_Webpos/js/model/sales/order/status',
        'Magestore_Webpos/js/model/url-builder',
        'mage/storage',
        'Magestore_Webpos/js/helper/alert',
        'Magestore_Webpos/js/view/sales/order/list',
        'Magento_Catalog/js/price-utils'

    ],
    function (require, $, ko, Component, $t, orderTotal, orderStatus, urlBuilder,
              storage, alertHelper, List, priceHelper
    ) {
        "use strict";

        return Component.extend({
            orderData: ko.observable(null),
            orderListView: ko.observable(''),
            isShowActionPopup: ko.observable(false),
            totalValues: ko.observableArray([]),
            statusObject: orderStatus.getStatusObjectView(),
            isCanceled: ko.observable(true),
            canInvoice: ko.observable(true),
            canCancel: ko.observable(true),
            canShip: ko.observable(true),
            canCreditmemo: ko.observable(true),
            canSync: ko.observable(true),
            canTakePayment: ko.observable(false),
            canUnhold: ko.observable(false),
            isFirstLoad: true,
            defaults: {
                template: 'Magestore_Webpos/sales/order/view',
                templateTop: 'Magestore_Webpos/sales/order/view/top',
                templateBilling: 'Magestore_Webpos/sales/order/view/billing',
                templateShipping: 'Magestore_Webpos/sales/order/view/shipping',
                templateShippingMethod: 'Magestore_Webpos/sales/order/view/shipping-method',
                templatePaymentMethod: 'Magestore_Webpos/sales/order/view/payment-method',
                templateTotal: 'Magestore_Webpos/sales/order/view/total',
                templateItems: 'Magestore_Webpos/sales/order/view/items'
            },
            initialize: function () {
                this._super();
                var self = this;
                ko.pureComputed(function () {
                    return self.orderData();
                }).subscribe(function () {
                });
                self.cannotSync = ko.pureComputed(function () {
                    return (self.orderData() && self.orderData().state) ? self.orderData().state != 'notsync' : false;
                });

                self.showInvoiceButton = ko.pureComputed(function () {
                    var orderData = self.orderData();
                    if (orderData.state === 'complete' || orderData.state === 'closed')
                        return false;
                    var allInvoiced = true;
                    $.each(orderData.items, function (index, value) {
                        if (parseFloat(value.qty_ordered) - parseFloat(value.qty_invoiced) - parseFloat(value.qty_canceled) > 0)
                            allInvoiced = false;
                    });
                    if (!allInvoiced)
                        return true;
                    return false;
                });

                self.showShipmentButton = ko.pureComputed(function () {
                    var orderData = self.orderData();
                    var allShip = true;
                    $.each(orderData.items, function (index, value) {
                        if (parseFloat(value.qty_ordered) - parseFloat(value.qty_shipped) - parseFloat(value.qty_refunded) - parseFloat(value.qty_canceled) > 0)
                            allShip = false;
                    });
                    if (!allShip)
                        return true;
                    return false;
                });

                if (this.isFirstLoad) {
                    $("body").click(function () {
                        self.isShowActionPopup(false);
                    });
                    this.isFirstLoad = false;
                }
            },
            invoice: function (data) {
                var orderData = this.orderData();
                var orderId = orderData.entity_id;
                var itemsOrder = orderData.items;
                var items = {};
                var i = 0;
                $.each(itemsOrder, function (index, value) {
                    var itemsData = {};
                    itemsData.qty = value.qty_ordered;
                    itemsData.order_item_id = value.item_id;
                    items[i] = itemsData;
                    i++;
                });
                var self = this;
                var itemsOrder = [];
                var params = {};
                var serviceUrl = urlBuilder.createUrl('/webpos/invoices/create', params);
                console.log(serviceUrl);
                var payload = {entity: {orderId: orderId, items: items}};
                storage.post(
                    serviceUrl, JSON.stringify(payload)
                ).done(function (response) {
                    self.setData(response);
                    // List().test();
                    alertHelper({
                        priority: 'success',
                        title: 'sucess',
                        message: $t('Create invoice successfully!')
                    });
                }).fail(function (response) {
                    alertHelper({
                        priority: 'warning',
                        title: 'Error',
                        message: $t('Cannot create invoice!')
                    });
                });
            },
            setData: function (data, object) {
                this.orderData(data);
                this.orderListView(object);
                this.isShowActionPopup(false);
                var self = this;
                this.totalValues([]);
                var totalArray = orderTotal.getTotalOrderView();
                if (self.orderData())
                    $.each(totalArray, function (index, value) {
                        var order_currency_code = self.orderData().order_currency_code;

                        var current_currency_code = window.webposConfig.currentCurrencyCode;

                        if (
                            order_currency_code == current_currency_code
                        ) {
                            if ((self.orderData()[value.totalName] && self.orderData()[value.totalName] != 0) || value.required) {
                                var totalCode = value.totalName.replace("base_", "");
                                self.totalValues.push(
                                    {
                                        totalValue: (value.isPrice) ? priceUtils.formatPrice(self.orderData()[totalCode]) : self.orderData()[totalCode] + ' ' + value.valueLabel,
                                        totalLabel: value.totalName == 'base_discount_amount' &&
                                        (self.orderData().discount_description || self.orderData().coupon_code) ?
                                            $t(value.totalLabel) + ' (' + (self.orderData().discount_description ?
                                            self.orderData().discount_description : self.orderData().coupon_code) +
                                            ')' : $t(value.totalLabel)
                                    }
                                );
                            }
                        } else {
                            if ((self.orderData()[value.totalName] && self.orderData()[value.totalName] != 0) || value.required) {
                                self.totalValues.push(
                                    {
                                        totalValue: (value.isPrice) ? self.convertAndFormatPrice(self.orderData()[value.totalName]) : self.orderData()[value.totalName] + ' ' + value.valueLabel,
                                        totalLabel: value.totalName == 'base_discount_amount' &&
                                        (self.orderData().discount_description || self.orderData().coupon_code) ?
                                            $t(value.totalLabel) + ' (' + (self.orderData().discount_description ?
                                            self.orderData().discount_description : self.orderData().coupon_code) +
                                            ')' : $t(value.totalLabel)
                                    }
                                );
                            }
                        }
                    });
            },
            shipment: function (data) {
                var orderData = this.orderData();
                var orderId = orderData.entity_id;
                var itemsOrder = orderData.items;
                var items = {};
                var i = 0;
                $.each(itemsOrder, function (index, value) {
                    var itemsData = {};
                    itemsData.qty = value.qty_ordered;
                    itemsData.order_item_id = value.item_id;
                    items[i] = itemsData;
                    i++;
                });
                var self = this;
                var itemsOrder = [];
                var params = {};
                var serviceUrl = urlBuilder.createUrl('/webpos/shipment/create', params);
                var payload = {entity: {orderId: orderId, items: items}};
                storage.post(
                    serviceUrl, JSON.stringify(payload)
                ).done(function (response) {
                    self.setData(response);
                    alertHelper({
                        priority: 'success',
                        title: 'sucess',
                        message: $t('Create shipment successfully!')
                    });
                }).fail(function (response) {
                    alertHelper({
                        priority: 'warning',
                        title: 'Error',
                        message: $t('Cannot create shipment!')
                    });
                });
            },
            getData: function () {
                return this.orderData();
            },
            getPrice: function (label) {
                if (this.orderData().order_currency_code == window.webposConfig.currentCurrencyCode) {
                    return priceHelper.formatPrice(this.orderData()[label]);
                }
                return this.convertAndFormatPrice(
                    this.orderData()['base_' + label],
                    this.orderData().base_currency_code
                );
            },
            getStatus: function () {
                var self = this;
                return _.find(self.statusObject, function (obj) {
                    return obj.statusClass == self.orderData().status
                }).statusLabel;
            },
            convertAndFormatPrice: function (price) {
                return priceHelper.formatPrice(price);
            },
            getCustomerName: function (type) {
                var address = this.getAddressType(type);
                return address.firstname + ' ' + address.lastname;
            },
            getAddress: function (type) {
                var address = this.getAddressType(type);
                var city = address.city ? address.city + ', ' : '';
                var region = address.region && typeof address.region == 'string' ? address.region + ', ' : '';
                var postcode = address.postcode ? address.postcode + ', ' : '';
                return city + region + postcode + address.country_id;
            },
            getAddressType: function (type) {
                switch (type) {
                    case 'billing':
                        return this.orderData.call().billing_address;
                        break;
                    // case 'shipping':
                    //     return this.orderData.call().extension_attributes.shipping_assignments[0].shipping.address;
                    //     break;
                    case 'shipping':
                        return this.orderData.call().billing_address;
                        break;
                }
            },
            showIntegration: function () {
                var hasGiftcard = this.orderData().base_gift_voucher_discount && this.orderData().base_gift_voucher_discount < 0;
                var hasRewardpoints = this.orderData().rewardpoints_base_discount && this.orderData().rewardpoints_base_discount < 0;
                var isPosPayment = this.orderData().payment && this.orderData().payment.method == 'multipaymentforpos';
                return ((hasGiftcard || hasRewardpoints) && isPosPayment);
            },
            showWebposPayment: function () {
                var hasPayment = this.hasWebposPayment();
                var showIntegration = this.showIntegration();
                return (hasPayment || showIntegration);
            },
            hasWebposPayment: function () {
                var hasPayment = this.orderData().webpos_order_payments && this.orderData().webpos_order_payments.length > 0;
                return hasPayment;
            },

        });
    });

