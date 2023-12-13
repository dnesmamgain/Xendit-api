<?php
$errors = [];

header('Access-Control-Allow-Origin: https://app.kocostar.id');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

use Xendit\Xendit;
require 'vendor/autoload.php';

#Configure package with your account's secret key obtained from Xendit Dashboard. 8WEHx2vsUNbVQlZIlDKweLd3kkgjdVEGI7A87EHBhSZbi7kS

if(isset($_POST)){
    $_POST = json_decode(file_get_contents("php://input"), true);

    if(strpos($_POST["refer_url"], "version-test")) {
        Xendit::setApiKey('xnd_development_mIl03LUk18tvo0Q7fksBONNScztFdQhepEWIRDbSIkWJSnJXSfVFNBiSOVp4c');
    } elseif(strpos($_POST["refer_url"], "version-uat")) {
        Xendit::setApiKey('xnd_development_mIl03LUk18tvo0Q7fksBONNScztFdQhepEWIRDbSIkWJSnJXSfVFNBiSOVp4c');
    }
    else Xendit::setApiKey('xnd_production_vFNqtPlWfizyC6Su2nk5AMuesLzIgRK4W3DqDZxKT5AS4AZw81u9C3NVXtmw0V');

    $params = [
        'external_id' =>  $_POST["user_id"],
        'payer_email' => "iamdineshmamgain@gmail.com",
        'description' => $_POST["descr"],
        'amount' => $_POST["amount"],
        'payment_methods' => [ "BCA", "BNI", "BSI", "BRI", "MANDIRI", "PERMATA", "OVO", "DANA", "SHOPEEPAY", "LINKAJA", "QRIS"],
        'customer' => [
            'given_names' => $_POST["customer"]["name"],
            'email' => $_POST["customer"]["email"],
            'mobile_number' => $_POST["customer"]["phone"],
        ],
        'customer_notification_preference' => [
            'invoice_created' => [
                'whatsapp',
                'email',
            ],
            'invoice_reminder' => [
                'whatsapp',
                'email',
            ],
            'invoice_paid' => [
                'whatsapp',
                'email',
            ],
            'invoice_expired' => [
                'email',
            ]
        ],
    ];

    try {
        $createInvoice = \Xendit\Invoice::create($params);
        $link = $createInvoice['invoice_url'];
    }
    catch(Exception $e){
        $errors = $e;
        var_dump($errors);
        die();
    }
    #var_dump($createInvoice);
    $response = json_encode($createInvoice);
    echo $response;
}
