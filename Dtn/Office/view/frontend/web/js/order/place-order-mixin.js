define([
    'jquery',
    'mage/utils/wrapper',
    'Dtn_Office/js/order/orderrequest-assigner'
], function ($, wrapper, orderrequestAssigner) {
    'use strict';

    return function (placeOrderAction) {
        /** Override Place Order Action and add special request to request body */
        return wrapper.wrap(placeOrderAction, function(originalAction, paymentData, messageContainer){
            orderrequestAssigner(paymentData);

            return originalAction(paymentData, messageContainer);
        });
    };
});