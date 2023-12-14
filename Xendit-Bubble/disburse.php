<?php
$errors = [];

header('Access-Control-Allow-Origin: https://app.xenditapi.com');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

use Xendit\Xendit;
require 'vendor/autoload.php';

if(isset($_POST)){
    $_POST = json_decode(file_get_contents("php://input"), true);
    echo $_POST["refer_url"];
    if(strpos($_POST["refer_url"], "version-test")) {
        Xendit::setApiKey('xnd_development_mIl03LUk18tvo0Q7fksBONNScztFdQhepEWIRDbSIkWJSnJXSfVFNBiSOVp4c');
        echo "yes-Development";
         $params = [
        'external_id' => $_POST["user_id"],
        'amount' => $_POST["amount"],
        'bank_code' => $_POST["bank_code"],
        'account_holder_name' => $_POST["owner_name"],
        'account_number' => $_POST["account_number"],
        'description' => $_POST["descr"],
         ];
    } 
    else if(strpos($_POST["refer_url"], "version-uat")) {
        Xendit::setApiKey('xnd_development_mIl03LUk18tvo0Q7fksBONNScztFdQhepEWIRDbSIkWJSnJXSfVFNBiSOVp4c');
        echo "yes-UAT";
         $params = [
        'external_id' => $_POST["user_id"],
        'amount' => $_POST["amount"],
        'bank_code' => $_POST["bank_code"],
        'account_holder_name' => $_POST["owner_name"],
        'account_number' => $_POST["account_number"],
        'description' => $_POST["descr"],
         ];
    } 
    else {
        Xendit::setApiKey('xnd_production_vFNqtPlWfizyC6Su2nk5AMuesLzIgRK4W3DqDZxKT5AS4AZw81u9C3NVXtmw0V');
        $params = [
        'external_id' => $_POST["user_id"],
        'amount' => $_POST["amount"],
        'bank_code' => $_POST["bank_code"],
        'account_holder_name' => $_POST["owner_name"],
        'account_number' => $_POST["invoice"],
        'description' => $_POST["descr"],
        ];
    }

   

    try {
        $createDisbursements = \Xendit\Disbursements::create($params);
        var_dump($createDisbursements);
    } catch (\Xendit\Exceptions\ApiException $e) {
        $errors = $e;
        var_dump($e->getMessage());
        die();
    }
}
