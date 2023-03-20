<?php

namespace ALevel\PublicCache\Controller\Adminhtml\Players;

use ALevel\PublicCache\Controller\Adminhtml\Players;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class MassDelete extends Players
{
    const ACL_RESOURCE = 'ALevel_PublicCache::players_delete';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            $ids = $this->getRequest()->getParam('selected');

            if (!empty($ids)) {
                foreach ($ids as $id) {
                    try {
                        $this->repository->deleteById($id);
                    } catch (NoSuchEntityException|CouldNotDeleteException $e) {
                        $this->logger->info(sprintf("item %d already delete", $id));
                    }
                }
                $this->messageManager->addSuccessMessage(sprintf("items %s was deleted", implode(',', $ids)));
            } else {
                $this->messageManager->addWarningMessage(__("Please select ids"));
            }
        }

        $this->_redirect('*/*/');
    }

    protected function getAclResource()
    {
        return self::ACL_RESOURCE;
    }
}
