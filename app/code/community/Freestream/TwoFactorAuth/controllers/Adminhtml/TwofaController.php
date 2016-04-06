<?php
/**
 * Google Two-Factor Authentication.
 *
 * @package Freestream_TwoFactorAuth
 * @module  Freestream
 * @author  Anton Samuelsson <samuelsson.anton@gmail.com>
 */
class Freestream_TwoFactorAuth_Adminhtml_TwofaController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * Generate new secret for admin user.
     */
    public function generateAction()
    {
        $secret = Mage::getModel('fstwofactorauth/admin_factory')->generateSecretKey();
        $userId = $this->getRequest()->getParam('user_id');

        Mage::getModel('fstwofactorauth/admin_hash')
            ->loadByAdminId($userId)
            ->setHash($secret)
            ->save();

        $this->_redirect('*/permissions_user/edit', array('user_id' => $userId));
    }

    /**
     * Only for allowed users.
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/acl/users');
    }
}
