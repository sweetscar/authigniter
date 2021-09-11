<?php

namespace SweetScar\AuthIgniter\Libraries\Email;

use Error;
use SweetScar\AuthIgniter\Libraries\Email\EmailInterface;
use SweetScar\AuthIgniter\Libraries\Email\BaseEmail;

class NetcoreEmail extends BaseEmail implements EmailInterface
{
    /**
     * {@inheritdoc}
     */
    public function send(
        string $fromEmail,
        string $fromName,
        string $toEmail,
        string $toName,
        string $subject,
        string $content
    ): bool {

        $netcoreURL = $this->emailConfig->netcore['url'];
        $netcoreAPIKEY = $this->emailConfig->netcore['api_key'];

        if (is_null($netcoreURL) || is_null($netcoreAPIKEY)) {
            throw new Error("Netcore email configuration error");
        }

        $curl = curl_init();

        $postFields = array(
            'from' => array(
                'email' => $fromEmail,
                'name' => $fromName,
            ),
            'subject' => $subject,
            'content' => array(
                0 => array(
                    'type' => 'html',
                    'value' => $content,
                ),
            ),
            'personalizations' => array(
                0 => array(
                    'to' => array(
                        0 => array(
                            'email' => $toEmail,
                            'name' => $toEmail,
                        ),
                    ),
                ),
            ),
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => $netcoreURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array(
                "api_key:" . $netcoreAPIKEY,
                "content-type: application/json"
            ),
        ));

        curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $this->setError($err);
            return false;
        }
        return true;
    }
}
