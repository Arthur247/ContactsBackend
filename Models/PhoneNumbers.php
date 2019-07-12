<?php


namespace Contacts\Models;

use Contacts\Components\DB;
use Exception;

class PhoneNumbers
{
    /**
     * @return string
     */
    public static function createQuery()
    {
        return 'INSERT INTO contact_phone_numbers (contact_id, phone_number) VALUES (?,?)';
    }

    /**
     * @return string
     */
    public static function updateQuery()
    {
        return 'UPDATE contact_phone_numbers SET phone_number = ? WHERE id = ?';
    }

    /**
     * @param $contactId
     * @param $phoneNumber
     */
    public static function createPhoneNumber($contactId, $phoneNumber)
    {
        $db = DB::getConnection();

        $query = $db->prepare(self::createQuery());
        $query->execute([$contactId, $phoneNumber]);
    }
}