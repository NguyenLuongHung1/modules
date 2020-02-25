<?

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        die('Die here');
    }
}
