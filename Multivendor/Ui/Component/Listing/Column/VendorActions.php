<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/16/2018
 * Time: 3:37 PM
 */
namespace Magestore\Multivendor\Ui\Component\Listing\Column;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class VendorActions extends Column{
    /** @var UrlInterface */
    protected $urlBuilder;
    /** @var string
     */
    private $editUrl;
    private $deleteUrl;

    /**
     * VendorActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(ContextInterface $context,
                                UiComponentFactory $uiComponentFactory,
                                UrlInterface $urlBuilder,
                                array $components = [],
                                array $data = [])
    {
        $this->urlBuilder =$urlBuilder;
        $this->editUrl = $data['vendorUrlPathEdit'];
        $this->deleteUrl =$data['vendorUrlPathDelete'];

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    // lấy data source
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])){
            foreach ($dataSource['data']['items'] as &$item){
                $name = $this->getData('name');
                if(isset($item['vendor_id'])){
                    $item[$name]['edit']=[
                        'href'=>$this->urlBuilder->getUrl($this->editUrl,
                            ['id'=>$item['vendor_id']]),
                        'label'=>__('Edit')
                    ];
                    $item[$name]['delete']=[
                        'href'=>$this->urlBuilder->getUrl($this->deleteUrl,['id'=>$item['vendor_id']]),
                        'label'=>__('Delete')
                    ];
                }
            }
        }
        return  $dataSource;
    }

}
//Đoạn code này cho phép ta truy cập đến url edit của từng vendor.
//Điều này có nghĩa là trình duyệt sẽ đưa ta đến action new hoặc edit qua url:
//admin/multivendor/vendor/new hoặc

