<?php

namespace ALevel\PublicCache\UI\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    const URL_PATH_EDIT = 'alevel_publiccache/player/edit';
    const URL_PATH_DELETE = 'alevel_publiccache/player/delete';

    /** @var UrlInterface */
    protected $urlBuilder;

    /** @var string  */
    private $editUrl;

    /**
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param UrlInterface          $urlBuilder
     * @param array                 $components
     * @param array                 $data
     * @param string                $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /** {@inheritdoc} */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['player_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['player_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item['player_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.first_name }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.first_name }" record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
