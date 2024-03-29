<?php
//typo3\sysext\backend\Classes\Form\Element

declare(strict_types = 1);
namespace Homeinfo\Pinlogin\Form\Element;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use Homeinfo\Pinlogin\Domain\Repository\PINRepository;

const MAX_TRIES = 10;
const PIN_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
const PIN_LENGTH = 4;

class NewPINField extends AbstractFormElement
{
   public function render(): array
   {
      $attributes = [
         'name' => htmlspecialchars($this->data['parameterArray']['itemFormElName']),
         'data-formengine-input-name' => htmlspecialchars($this->data['parameterArray']['itemFormElName'])
      ];
      $result['html'] = '<input type="text" value="'
         . $this->getValue()
         . '" '
         . GeneralUtility::implodeAttributes($attributes, true)
         . ' />';
      return $result;
   }

   private function getValue(): string
   {
      if ($this->data['command'] == 'new')
         return $this->getUniquePIN();

      return $this->data['databaseRow']['pin'];
   }

   private function getUniquePIN(): string
   {
      for ($i = 0; $i < MAX_TRIES; $i++) {
         $pin = $this->generateRandomPIN();

         if ($this->isUnique($pin))
            return $pin;
      }

      return '';
   }

   private function isUnique(string $pin): bool
   {
      return GeneralUtility::makeInstance(ObjectManager::class)
         ->get(PINRepository::class)
         ->findByPinAndPid($pin, intval(GeneralUtility::_GP('pageId')))
         ->count()
         < 1;
   }

   private function generateRandomPIN(): string
   {
      $pin = '';

      for ($i = 0; $i < PIN_LENGTH; $i++)
         $pin .= PIN_CHARS[rand(0, strlen(PIN_CHARS) - 1)];

      return $pin;
   }
}
