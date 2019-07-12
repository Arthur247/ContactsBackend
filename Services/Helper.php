<?php


namespace Contacts\Services;


class Helper
{
    /**
     * @param $requestData
     * @return array
     */
    public function generateData($requestData)
    {
        $data = [];

        foreach ($requestData as $datum) {

            if (strpos($datum['name'], 'phone_number') !== false ) {

                if (!empty($phoneNumberId = str_replace("phone_number_","", $datum['name']))) {

                    if (!empty($datum['value'])) {
                        $data['phone_numbers']['toUpdate'][$phoneNumberId] = $datum['value'];
                    }
                } else {

                    if (!empty($datum['value'])) {
                        $data['phone_numbers']['toCreate'][] = $datum['value'];
                    }
                }
                continue;
            }
            $data[$datum['name']] = $datum['value'];
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}