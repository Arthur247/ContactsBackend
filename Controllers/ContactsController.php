<?php

namespace Contacts\Controllers;


use Contacts\Models\Contacts;
use Contacts\Components\JsonResponse;
use Contacts\Services\Helper;
use Exception;

class ContactsController
{
    /** @var Helper  */
    private $helperService;

    public function __construct()
    {
        $this->helperService = new Helper();
    }

    /**
     * @return JsonResponse
     */
    public function actionGetList()
    {
        try {
            if (!$this->helperService->isPost()) {
                throw new Exception('Wrong request method');
            }

            $contacts = Contacts::getList();

            return new JsonResponse('success', '', $contacts);
        } catch (Exception $exception) {
            return new JsonResponse('exception', $exception->getMessage());
        }
    }

    /**
     * @return JsonResponse
     */
    public function actionSearch()
    {
        try {
            if (!$this->helperService->isPost()) {
                throw new Exception('Wrong request method');
            }

            $requestData = file_get_contents('php://input');

            $contacts = Contacts::search($requestData);

            return new JsonResponse('success', '', $contacts);
        } catch (Exception $exception) {
            return new JsonResponse('exception', $exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function actionView($id)
    {
        try {
            if (!$this->helperService->isPost()) {
                throw new Exception('Wrong request method');
            }

            $contact = Contacts::getOneById($id);

            return new JsonResponse('success', '', $contact);
        } catch (Exception $exception) {
            return new JsonResponse('exception', $exception->getMessage());
        }
    }

    /**
     * @return JsonResponse
     */
    public function actionCreate()
    {
        try {
            if (!$this->helperService->isPost()) {
                throw new Exception('Wrong request method');
            }

            $requestData = json_decode(file_get_contents('php://input'), true);

            if (!$requestData) {
                throw new Exception('No data to generate');
            }

            $helperService = new Helper();

            $data = $helperService->generateData($requestData);

            Contacts::create($data);

            return new JsonResponse('success', 'Contact created');
        } catch (Exception $exception) {
            return new JsonResponse('exception', $exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function actionUpdate($id)
    {
        try {
            if (!$this->helperService->isPost()) {
                throw new Exception('Wrong request method');
            }

            $requestData = json_decode(file_get_contents('php://input'), true);

            if (!$requestData) {
                throw new Exception('No data to generate');
            }

            $helperService = new Helper();

            $data = $helperService->generateData($requestData);

            Contacts::update($id, $data);

            return new JsonResponse('success', 'Contact updated');
        } catch (Exception $exception) {
            return new JsonResponse('exception', $exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function actionDelete($id)
    {
        try {
            if (!$this->helperService->isPost()) {
                throw new Exception('Wrong request method');
            }

            Contacts::delete($id);

            return new JsonResponse('success', 'Contact deleted');
        } catch (Exception $exception) {
            return new JsonResponse('exception', $exception->getMessage());
        }
    }
}