<?php

namespace App\Service;

use \Mailjet\Resources;

class Mailjet
{
    private $api_key = "72b930f23e747971a743f46cf0acf827";
    private $api_key_private = "5bf38e53a6a07ccd773063829440cb51";

    public function sendEmail($emailTo, $name, $subject, $content, $templateId) {
        
        $mj = new \Mailjet\Client($this->api_key, $this->api_key_private, true,['version' => 'v3.1']);
$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => 'kadance972@hotmail.com',
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
dump($response, $response->getData());die;
$response->success() && var_dump($response->getData());
    }
}
?>