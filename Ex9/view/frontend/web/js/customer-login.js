// define(
//     [
//     'jquery',
//     'jquery/ui'
//     ], function ($) {
//     $.widget('magestore.customerLogin', {
//         options: {},
//         _create: function() {},
//         _destroy: function () {},
//         _setOption: function (key, value) {}
//         });
// });
define([
    'jquery',
    'mage/mage',
    'Magestore_Ex9/js/customer-login'
], function ($) {
    var dataForm = $('#form-login');
    dataForm.mage('validation', {});
    $('.header.links .authorization-link a').on('click', function () {
        $('.popup-login').show();
        return false;
    });
    $('.action-close').on('click',function () {
        $('.popup-login').hide();
    });
    $('.action-login').on('click',function () {
        if(dataForm.validation('isValid')){
            var formData = new FormData();
            formData.append('username', $('#form-login input[name="username"]').val());
            formData.append('password', $('#form-login input[name="password"]').val());
            $.ajax({
                url: '<?php echo $block->getAjaxLoginUrl(); ?>',
                data: formData,
                processData: false,
                contentType: false,
                showLoader: true,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (!response.errors) {
                        location.reload();
                    } else {
                        $('.popup-login .form-login .messages .message div').text(response.message);
                        $('.popup-login .form-login .messages .message').show();
                        setTimeout(function() {
                            $('.popup-login .form-login .messages .message').hide();
                        }, 5000);
                    }
                }
            });
            return false;
        }
    })
});