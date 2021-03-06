<?php

namespace Dtn\Office\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;

class SaveShipper extends \Magento\Shipping\Model\Carrier\AbstractCarrier
implements \Magento\Shipping\Model\Carrier\AbstractCarrierInterface
{


    protected $_code = 'saveshipper';
    protected $_isFixed = false;
    protected $_rateResultFactory;
    protected $_rateMethodFactory;
    protected $cart;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        array $data = [],
        \Magento\Checkout\Model\CartFactory $cart
    ) {
        $this->cart = $cart;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function collectRates(RateRequest $request)
    {
        $cart = $this->cart->create();

        $subTotal = $cart->getQuote()->getSubtotalWithDiscount();

        $grandTotal = $cart->getQuote()->getGrandTotal();

        $freePrice = $this->getConfigData('free_price');

        $normalPrice = $this->getConfigData('price');

        $shippingPrice = $normalPrice;

        if (!$this->getConfigFlag('active')) {
            return false;
        }

        if ($subTotal > $freePrice) {
            $shippingPrice = 0;
        }

        $shippingPrice = $shippingPrice;
        $result = $this->_rateResultFactory->create();

        $method = $this->_rateMethodFactory->create();

        $method->setCarrier('saveshipper');

        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod('saveshipper');
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);

        $result->append($method);

        return $result;
    }

    public function getAllowedMethods()
    {
        return ['saveshipper' => $this->getConfigData('name')];
    }
}
