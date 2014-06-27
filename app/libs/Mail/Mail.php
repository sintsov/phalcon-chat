<?php
/**
 * Class released basic method work with mail
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Mail;

use Phalcon\Mvc\User\Component;
use Swift_Message as Message;
use Phalcon\Mvc\View;

require_once __DIR__ . '/../../vendor/SwiftMailer/swift_required.php';

class Mail extends Component{

    protected $transport;

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array $params
     */
    public function getTemplate($name, $params){
        $parameters = array_merge(array(
            'publicUrl' => $this->config->application->production->staticBaseUri
        ), $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function ($view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });
    }

    /**
     * Sends e-mails
     *
     * @param array $to
     * @param string $subject
     * @param string $name
     * @param array $params
     * @return bool
     */
    public function send($to, $subject, $name, $params){

        // Settings
        $mailSettings = $this->config->mail;

        $template = $this->getTemplate($name, $params);

        // Create the message
        $message = Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom(array(
                $mailSettings->fromEmail => $mailSettings->fromName
            ))
            ->setBody($template, 'text/html')
            ->setCharset('cp1251');


        if (!$this->transport) {
            $this->transport = \Swift_MailTransport::newInstance();
        }
        // Create the Mailer using your created Transport
        $mailer = \Swift_Mailer::newInstance($this->transport);

        return $mailer->send($message);
    }

} 