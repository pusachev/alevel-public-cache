<?php

namespace ALevel\PublicCache\Model\ResourceModel\Player;

use ALevel\PublicCache\Model\Data\Player as Model;
use ALevel\PublicCache\Model\ResourceModel\Player as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
