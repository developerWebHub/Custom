<?php
class Weber_Best_Adminhtml_Best_BestController extends Weber_Best_Controller_Adminhtml_Best
{
    protected function _initBest()
    {
        $bestId  = (int) $this->getRequest()->getParam('id');
        $best    = Mage::getModel('weber_best/best');
        if ($bestId) {
            $best->load($bestId);
        }
        Mage::register('current_best', $best);
        return $best;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('weber_best')->__('Best'))
             ->_title(Mage::helper('weber_best')->__('Bests'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function editAction()
    {
        $bestId    = $this->getRequest()->getParam('id');
        $best      = $this->_initBest();
        if ($bestId && !$best->getId()) {
            $this->_getSession()->addError(
                Mage::helper('weber_best')->__('This best no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getBestData(true);
        if (!empty($data)) {
            $best->setData($data);
        }
        Mage::register('best_data', $best);
        $this->loadLayout();
        $this->_title(Mage::helper('weber_best')->__('Best'))
             ->_title(Mage::helper('weber_best')->__('Bests'));
        if ($best->getId()) {
            $this->_title($best->getTitle());
        } else {
            $this->_title(Mage::helper('weber_best')->__('Add best'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

   public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('best')) {
            try {
                $best = $this->_initBest();
                $best->addData($data);
                $imageName = $this->_uploadAndGetName(
                    'image',
                    Mage::helper('weber_best/best_image')->getImageBaseDir(),
                    $data
                );
                $best->setData('image', $imageName);
                $best->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('weber_best')->__('Best was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $best->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['image']['value'])) {
                    $data['image'] = $data['image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setBestData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['image']['value'])) {
                    $data['image'] = $data['image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('weber_best')->__('There was a problem saving the best.')
                );
                Mage::getSingleton('adminhtml/session')->setBestData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('weber_best')->__('Unable to find best to save.')
        );
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $best = Mage::getModel('weber_best/best');
                $best->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('weber_best')->__('Best was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('weber_best')->__('There was an error deleting best.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('weber_best')->__('Could not find best to delete.')
        );
        $this->_redirect('*/*/');
    }
 

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('weber_best/best');
    }
}
