define([
    'jquery',
    'mage/utils/wrapper',
    'Dtn_Office/js/order/orderrequest-assigner'
], function ($, wrapper, orderrequestAssigner) {
    'use strict';

    return function (placeOrderAction) {
        /**Override place order mixin for set-payment-information action as they differs only by method signature */
        return wrapper.wrap(placeOrderAction, function(originalAction, messageContainer, paymentData){
            orderrequestAssigner(paymentData);

            return originalAction(messageContainer, paymentData);
        });
    };
});