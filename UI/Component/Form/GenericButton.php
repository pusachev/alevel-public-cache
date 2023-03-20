<?php

namespace ALevel\PublicCache\UI\Component\Form;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use ALevel\PublicCache\Api\Repository\PlayerRepositoryInterface;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var PlayerRepositoryInterface
     */
    protected $repository;

    /**
     * @param Context $context
     * @param PlayerRepositoryInterface $playerRepository
     */
    public function __construct(
        Context $context,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->context = $context;
        $this->repository = $playerRepository;
    }

    /**
     * Return id
     *
     * @return int|null
     */
    public function getPlayerId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }

        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
