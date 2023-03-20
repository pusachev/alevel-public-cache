<?php

namespace ALevel\PublicCache\Model\Data;

use ALevel\PublicCache\Api\Data\PlayerInterface;
use ALevel\PublicCache\Model\ResourceModel\Player as ResourceModel;
use ALevel\PublicCache\Api\Schema\PlayerSchemaInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Player extends AbstractModel implements PlayerInterface, IdentityInterface
{
    public function setFirstName(string $firtsName): PlayerInterface
    {
        $this->setData(PlayerSchemaInterface::FIRST_NAME_COLUMN_NAME, $firtsName);

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->getData(PlayerSchemaInterface::FIRST_NAME_COLUMN_NAME);
    }

    public function setLastName(string $lastName): PlayerInterface
    {
        $this->setData(PlayerSchemaInterface::LAST_NAME_COLUMN_NAME, $lastName);

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->getData(PlayerSchemaInterface::LAST_NAME_COLUMN_NAME);
    }

    public function setBloodPoints(int $bloodPoints): PlayerInterface
    {
        $this->setData(PlayerSchemaInterface::BLOOD_POINTS_COLUMN_NAME, $bloodPoints);

        return $this;
    }

    public function getBloodPoints(): ?int
    {
        return $this->getData(PlayerSchemaInterface::BLOOD_POINTS_COLUMN_NAME);
    }

    public function getFullName(): ?string
    {
        return sprintf("%s %s", $this->getFirstName(), $this->getLastName());
    }

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getIdentities()
    {
       return [ sprintf('alevel_public_cache_player_%s', $this->getId())];
    }
}
