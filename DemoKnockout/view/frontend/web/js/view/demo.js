define(
    [   'ko',
        'uiComponent',
        'mage/url',
        'mage/storage',
    ],function (ko, Component, urlBuilder,storage) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Magestore_DemoKnockout/demo',
            },


            productList: ko.observableArray([]), //khai bao array product

            initialize:function () {
                this._super();
                this.sayhello = "Hello this is content populated with KO!";
                this.time=Date();
                this.observe(['time']);
                setInterval(this.flush.bind(this),1000);
                this.king="kokokokokokko";
                this.theValue=ko.observable('1'); //khai bao voi ko

            },
            flush:function(){
                this.time(Date());
            },
            getTitle: function () {
                return "*********Hello world******";
            },
            PickRandomValue:function () {
                var self=this;
                var val=Math.floor(Math.random()*3+1);
                this.theValue(val);
                console.log(val);
                var id=val;
                var serviceUrl = urlBuilder.build('demoknockout/index/product?id='+id);
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
    });
});