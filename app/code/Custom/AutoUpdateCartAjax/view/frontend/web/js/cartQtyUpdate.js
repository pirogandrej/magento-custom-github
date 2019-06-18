define([
    'jquery',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data'
], function($, getTotalsAction, customerData) {
    "use strict";
    $.widget('custom.autoupdatecartajax', {
        options: {
            triggerEvent: 'change',
            elementInput: 'input[name$="[qty]"]'
        },

        _create: function() {
            console.log('_create');
            this._bind();
        },

        _bind: function() {
            console.log('_bind');
            var self = this;
            $(document).ready(function(){
                $(document).on(self.options.triggerEvent, self.options.elementInput, function(){
                    self._ajaxSubmit();
                });
            });
        },

        _ajaxSubmit: function() {
            console.log('_ajaxSubmit');
            var form = $('form#form-validate');
            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (res) {
                    var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find("#form-validate");
                    var sections = ['cart'];

                    $("#form-validate").replaceWith(result);

                    /* Minicart reloading */
                    customerData.reload(sections, true);

                    /* Totals summary reloading */
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred);
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        }
    });

    return $.custom.autoupdatecartajax;
});
