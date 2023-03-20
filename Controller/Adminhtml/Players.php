<?php

namespace ALevel\PublicCache\Controller\Adminhtml;

use Magento\Framework\App\Request\DataPersistorInterface;
use Psr\Log\LoggerInterface;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use ALevel\PublicCache\Api\Repository\PlayerRepositoryInterface;
use ALevel\PublicCache\Api\Data\PlayerInterfaceFactory;

abstract class Players extends Action
{
    const MENU_ITEM = 'ALevel_PublicCache::all';

    protected $repository;

    protected $playerFactory;

    /** @var DataPersistorInterface */
    protected $dataPersistor;

    protected $logger;

    public function __construct(
        Context $context,
        PlayerRepositoryInterface $playerRepository,
        PlayerInterfaceFactory $playerFactory,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    ) {
        $this->repository       = $playerRepository;
        $this->playerFactory    = $playerFactory;
        $this->dataPersistor    = $dataPersistor;
        $this->logger           = $logger;

        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }

    abstract protected function getAclResource();

    protected function _isAllowed()
    {
        return parent::_isAllowed() &&
            $this->_authorization->isAllowed($this->getAclResource());
    }
}
