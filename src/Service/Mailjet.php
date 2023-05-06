<?php

namespace App\Service;

use \Mailjet\Resources;

class Mailjet
{
    private $mailjetKey;
    private $mailjetSecretKey;
    private $emailAdmin;

    public function __construct(
        $mailjetKey,
        $mailjetSecretKey,
        $emailAdmin,
    ) {
        $this->mailjetKey = $mailjetKey;
        $this->mailjetSecretKey = $mailjetSecretKey;
        $this->emailAdmin = $emailAdmin;
    }

    public function sendEmail($emailTo, $name, $subject, $content, $templateId)
    {

        $mj = new \Mailjet\Client($this->mailjetKey, $this->mailjetSecretKey, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => '',
                        'Name' => "SnowBoard"
                    ],
                    'To' => [
                        [
                            'Email' => $emailTo,
                            'Name' => $name
                        ]
                    ],
                    'TemplateID' => $templateId,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        //dump($response, $response->getData());die;
        $response->success() && var_dump($response->getData());
    }
}
