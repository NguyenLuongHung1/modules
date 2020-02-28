<?php

namespace Dtn\Office\Plugin\Checkout;

class PaymentInformationManagementPlugin
{
    protected $orderRepository;

    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function aroundSavePaymentInformationAndPlaceOrder(
        \Magento\Checkout\Model\PaymentInformationManagement $subject,
        \Closure $proceed,
        $cartId,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    ) {
        $result = $proceed($cartId, $paymentMethod, $billingAddress);

        if ($result) {

            $extAttribute = $paymentMethod->getExtensionAttributes();

            $specialRequest = $extAttribute->getSpecialRequest();

            $order = $this->orderRepository->get($result);

            $order->setSpecialRequest($specialRequest);
            
            $order->save();
        }

        return $result;
    }
}
