<?php

namespace App\Service;

use \Mailjet\Resources;

class Mailjet
{
    /**
     * mailjetKey
     *
     * @var string
     */
    private $mailjetKey;

    /**
     * mailjetSecretKey
     *
     * @var string
     */
    private $mailjetSecretKey;

    /**
     * emailAdmin
     *
     * @var string
     */
    private $emailAdmin;

    /**
     * __construct
     *
     * @param $mailjetKey       mailjetKey
     * @param $mailjetSecretKey mailjetSecretKey
     * @param $emailAdmin       emailAdmin
     * @return void
     */
    public function __construct(
        $mailjetKey,
        $mailjetSecretKey,
        $emailAdmin,
    ) {
        $this->mailjetKey = $mailjetKey;
        $this->mailjetSecretKey = $mailjetSecretKey;
        $this->emailAdmin = $emailAdmin;

    }

    /**
     * sendEmail
     *
     * @param  string $emailTo    EmailTo
     * @param  string $name       Name
     * @param  string $subject    Subject
     * @param  string $content    Content
     * @param  int    $templateId TemplateId
     * @return void
     */
    public function sendEmail($emailTo, $name, $subject, $content, $templateId)
    {
        $mjet = new \Mailjet\Client($this->mailjetKey, $this->mailjetSecretKey, true, ['version' => 'v3.1']);
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
        $response = $mjet->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }

    /**
     * getEmailMessage
     *
     * @param  string $from       from
     * @param  string $name       Name
     * @param  string $subject    Subject
     * @param  string $content    Content
     * @param  int    $templateId TemplateId
     * @return void
     */
    public function getEmailMessage($from, $name, $subject, $content, $templateId)
    {
        $mjet = new \Mailjet\Client($this->mailjetKey, $this->mailjetSecretKey, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $from,
                        'Name' => $name
                    ],
                    'To' => [
                        [
                            'Email' => $this->emailAdmin,
                            'Name' => ''
                        ]
                    ],
                    'TemplateID' => $templateId,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'fullname' => $name,
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mjet->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }
}
