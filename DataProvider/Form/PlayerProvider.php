<?php

namespace ALevel\PublicCache\DataProvider\Form;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use ALevel\PublicCache\Api\Data\PlayerInterface;
use ALevel\PublicCache\Model\ResourceModel\Player\Collection;
use ALevel\PublicCache\Model\ResourceModel\Player\CollectionFactory;

class PlayerProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    private $colleciton;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    private $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var PlayerInterface $player */
        foreach ($items as $player) {
            $this->loadedData[$player->getId()] = $player->getData();
        }

        $data = $this->dataPersistor->get('player');
        if (!empty($data)) {
            $player = $this->collection->getNewEmptyItem();
            $player->setData($data);
            $this->loadedData[$player->getId()] = $player->getData();
            $this->dataPersistor->clear('player');
        }

        return $this->loadedData;
    }
}
