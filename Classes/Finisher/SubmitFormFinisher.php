<?php

namespace TRAW\PowermailJira\Finisher;

use TRAW\PowermailJira\Events\PowermailSubmitEvent;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class SubmitFormFinisher
 * @package TRAW\PowermailJira\Finisher
 */
class SubmitFormFinisher extends \In2code\Powermail\Finisher\AbstractFinisher
{
    /**
     * @return void
     * @throws \TYPO3\CMS\Frontend\ContentObject\Exception\ContentRenderingException
     */
    public function myFinisher()
    {
        $mail = $this->getMail();
        //Dispatch the event only if a jira configuration is selected
        if (!empty($mail->getForm()->getJiraTarget())) {
            $eventDispatcher = GeneralUtility::makeInstance(EventDispatcher::class);
            $eventDispatcher->dispatch(new PowermailSubmitEvent($mail, $this->getSettings(), $this->contentObject->getRequest()->getUri()));
        }
    }
}