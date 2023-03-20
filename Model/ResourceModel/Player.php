<?php

namespace ALevel\PublicCache\Model\ResourceModel;

use ALevel\PublicCache\Api\Schema\PlayerSchemaInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Player extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(PlayerSchemaInterface::TABLE_NAME, PlayerSchemaInterface::ID_COLUMN_NAME);
    }
}
