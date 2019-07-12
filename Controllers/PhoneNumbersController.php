<?php


namespace Contacts\Controllers;


use Contacts\Components\JsonResponse;
use Contacts\Models\PhoneNumbers;
use Contacts\Services\Helper;
use Exception;

class PhoneNumbersController
{

    /** @var Helper */
    private $helperService;

    public function __construct()
    {
        $this->helperService = new Helper();
    }

    /**
     * @param $contact_id
     * @return JsonResponse
     */
    public function actionCreateContactNumber($contact_id)
    {
        try {
            if (!$this->helperService->isPost()) {
                throw new Exception('Wrong request method');
            }

            $requestData = file_get_contents('php://input');

            if (!$requestData) {
                throw new Exception('No data to generate');
            }

            PhoneNumbers::createPhoneNumber($contact_id, $requestData);

            return new JsonResponse('success', 'Phone number created');
        } catch (Exception $exception) {
            return new JsonResponse('exception', $exception->getMessage());
        }
    }
}