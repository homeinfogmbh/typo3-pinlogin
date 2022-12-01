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

class PINElement extends AbstractFormElement
{
   public function render(): array
   {
      $row = $this->data['databaseRow'];
      $parameterArray = $this->data['parameterArray'];
      $color = $parameterArray['fieldConf']['config']['parameters']['color'];
      $size = $parameterArray['fieldConf']['config']['parameters']['size'];

      $fieldInformationResult = $this->renderFieldInformation();
      $fieldInformationHtml = $fieldInformationResult['html'];
      $resultArray = $this->mergeChildReturnIntoExistingResult($this->initializeResultArray(), $fieldInformationResult, false);

      $fieldId = StringUtility::getUniqueId('formengine-textarea-');

      $attributes = [
         'id' => $fieldId,
         'name' => htmlspecialchars($parameterArray['itemFormElName']),
         'size' => $size,
         'data-formengine-input-name' => htmlspecialchars($parameterArray['itemFormElName'])
      ];

      $attributes['placeholder'] = 'Enter special value for user "'.htmlspecialchars(trim($row['username'])).
         '" in size '. $size;
      $classes = [
         'form-control',
         't3js-formengine-textarea',
         'formengine-textarea',
      ];
      $itemValue = $parameterArray['itemFormElValue'];
      $attributes['class'] = implode(' ', $classes);

      $html = [];
      $html[] = '<div class="formengine-field-item t3js-formengine-field-item" style="padding: 5px; background-color: ' . $color . ';">';
      $html[] = $fieldInformationHtml;
      $html[] =   '<div class="form-wizards-wrap">';
      $html[] =      '<div class="form-wizards-element">';
      $html[] =         '<div class="form-control-wrap">';
      $html[] =            '<input type="text" value="' . htmlspecialchars($itemValue, ENT_QUOTES) . '" ';
      $html[]=               GeneralUtility::implodeAttributes($attributes, true);
      $html[]=            ' />';
      $html[] =         '</div>';
      $html[] =      '</div>';
      $html[] =   '</div>';
      $html[] = '</div>';
      $resultArray['html'] = implode(LF, $html);

      return $resultArray;
   }

   private function getUniquePIN(): string
   {
      while (true) {
         $pin = this->generateRandomPIN();

         if (this->isPINUnique($pin)) {
            return $pin;
         }
      }
   }

   private function isPINUnique($pin): bool
   {
      return GeneralUtility::makeInstance(ObjectManager::class)
         ->get(PINRepository::class)
         ->findByPinAndPid($pin, intval(GeneralUtility::_GP('pageId')))
         == 0;
   }

   private function generateRandomPIN(): string
   {
      $pin = '';

      for ($i = 0; $i < $n; $i++) {
         $pin .= $PIN_CHARS[rand(0, strlen($PIN_CHARS) - 1)];
      }

      return $pin;
   }
}
