<?php

declare(strict_types=1);

namespace App\Helpers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use SendGrid\Mail\Mail as SendGridMail;
use SendGrid;

class Mail
{

    public $to = '';
    public $toName = '';

    public function __construct($to, $toName)
    {
        $this->to = $to;
        $this->toName = $toName;
    }

    public function loadTemplate($tmpName, $args)
    {
        $loader = new FilesystemLoader(SYS_ROOT . '/src/Template/Mail/');
        $twig = new Environment($loader);
        $template = $twig->load($tmpName);
        $args['siteUrl'] = siteUrl();
        $args['siteName'] = $_ENV['SITE_NAME'];
        return $template->render($args);
    }

    public function orderCreate($orderNo, $orderList, $total)
    {
        $body = $this->loadTemplate('order.html', [
            'list' => $orderList,
            'total' => $total,
            'orderNo' => $orderNo
        ]);
        return $this->send('Your order #' . $orderNo . ' is create', $body);
    }

    public function send($title, $body)
    {
        $email = new SendGridMail();
        $email->setFrom($_ENV['MAIL_FROM'], $_ENV['SITE_NAME']);
        $email->setSubject($title);
        $email->addTo($this->to, $this->toName);
        $email->addContent(
            "text/html",
            $body
        );
        $sendgrid = new SendGrid($_ENV['SENDGRID_API_KEY']);
        try {
            $response = $sendgrid->send($email);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
