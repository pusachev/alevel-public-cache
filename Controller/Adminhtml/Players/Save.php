<?php

namespace ALevel\PublicCache\Controller\Adminhtml\Players;

use ALevel\PublicCache\Api\Data\PlayerInterface;
use ALevel\PublicCache\Controller\Adminhtml\Players;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Save extends Players
{
    const ACL_RESOURCE_ADD = 'ALevel_PublicCache::players_add';
    const ACL_RESOURCE_EDIT = 'ALevel_PublicCache::players_edit';

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue();

        if (!empty($data)) {
            /** @var PlayerInterface $model */
            $model = $this->playerFactory->create();

            $id = $this->getRequest()->getParam('player_id');
            if (!empty($id)) {
                try {
                    $model = $this->repository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This player no longer exists.'));
                    $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the player %1.', $model->getFullName()));
                $this->dataPersistor->clear('player');
                return $this->processReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the user.'));
            }

            $this->dataPersistor->set('user', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/listing');
    }

    protected function _isAllowed()
    {
        if ($this->_authorization->isAllowed($this->getAclResource()) ||
            $this->_authorization->isAllowed(self::ACL_RESOURCE_ADD)) {
            return parent::_isAllowed();
        }

        return false;
    }

    protected function getAclResource()
    {
        return self::ACL_RESOURCE_EDIT;
    }

    private function processReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        return ($redirect ==='continue') ? $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()])
                                         :  $resultRedirect->setPath('*/*/');
    }
}
