define([
    'jquery',
    'mage/translate',
    'Magestore_Webpos/js/model/url-builder',
    'mage/storage',
    'jquery/ui'
], function ($, Translate, urlBuilder, storage) {
    $.widget("magestore.webposLogin", {
        _create: function () {
            var self = this;
            $.extend(this, {

            });
            $(this.element).mage('validation', {
                submitHandler: function (form) {
                    self.ajaxLogin();
                }
            });

        },

        ajaxLogin: function () {
            var serviceUrl,
                payload;
            serviceUrl = urlBuilder.createUrl('/webpos/staff/login', {});
            payload = {
                username: $(this.element).find('#username').val(),
                password: $(this.element).find('#pwd').val()
            };
            return storage.post(
                serviceUrl, JSON.stringify(payload)
            ).fail(
                function (response) {
                    alert(Translate("Your login information is wrong!"));
                }
            ).success(
                function (response) {
                    if(response==true) {
                        alert(Translate("Dang nhap thanh cong kia"))
                        window.location.reload();
                    }
                    else
                        alert(Translate("Your login information is wrong!"))
                }
            );
        }
    });

    return $.magestore.webposLogin;

});
