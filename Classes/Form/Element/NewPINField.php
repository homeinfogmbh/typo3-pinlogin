<?php
//typo3\sysext\backend\Classes\Form\Element

declare(strict_types = 1);
namespace Homeinfo\Pinlogin\Form\Element;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use Homeinfo\Pinlogin\Domain\Repository\PINRepository;

const PIN_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
const PIN_LENGTH = 4;

class NewPINField extends AbstractFormElement
{
   public function render(): array
   {
      $result['html'] = '<input type="text" value="' . $this->getUniquePIN() . '"/>';
      return $result;
   }

   private function getUniquePIN(): string
   {
      while (true) {
         $pin = $this->generateRandomPIN();

         if ($this->isUnique($pin)) {
            return $pin;
         }
      }
   }

   private function isUnique($pin): bool
   {
      return GeneralUtility::makeInstance(ObjectManager::class)
         ->get(PINRepository::class)
         ->findByPinAndPid($pin, intval(GeneralUtility::_GP('pageId')))
         == 0;
   }

   private function generateRandomPIN(): string
   {
      $pin = '';

      for ($i = 0; $i < $PIN_LENGTH; $i++) {
         $pin .= $PIN_CHARS[rand(0, strlen($PIN_CHARS) - 1)];
      }

      return $pin;
   }
}
