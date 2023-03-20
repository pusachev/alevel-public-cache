<?php


namespace ALevel\PublicCache\Controller\Adminhtml\Players;

use ALevel\PublicCache\Controller\Adminhtml\Players;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Players
{
    const ACL_RESOURCE = 'ALevel_PublicCache::players_delete';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            $id = $this->getRequest()->getParam('player_id', null);
            if (!empty($id)) {
                try {
                    $this->repository->deleteById($id);
                } catch (NoSuchEntityException|CouldNotDeleteException $e) {
                    $this->logger->info(sprintf("item %d already delete", $id));
                }
                $this->messageManager->addSuccessMessage(sprintf("item %d was deleted", $id));
            } else {
                $this->messageManager->addWarningMessage(__("Please select user id"));
            }
        }

        $this->_redirect('*/*/');
    }

    protected function getAclResource()
    {
        return self::ACL_RESOURCE;
    }
}
