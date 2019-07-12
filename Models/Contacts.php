<?php

namespace Contacts\Models;

use Contacts\Components\DB;
use Exception;

class Contacts
{
    /**
     * @return string
     */
    public static function getContactQuery()
    {
        return 'SELECT cont.*,
                      JSON_OBJECTAGG(cont_numb.id, cont_numb.phone_number) as phone_numbers
             FROM contacts cont
             JOIN contact_phone_numbers cont_numb ON cont.id = cont_numb.contact_id ';
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $db = DB::getConnection();

        $query = $db->prepare(
            self::getContactQuery() .
            'GROUP BY cont.id ' .
            'ORDER BY cont.first_name'
        );
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $data
     * @return array
     */
    public static function search($data)
    {
        $db = DB::getConnection();

        $query = $db->prepare(
            self::getContactQuery() .
            'WHERE first_name LIKE ? ' .
            'OR last_name LIKE ? ' .
            'GROUP BY cont.id ' .
            'ORDER BY cont.first_name'
        );
        $query->execute(["%$data%", "%$data%"]);
        return $query->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public static function getOneById($id)
    {
        $db = DB::getConnection();

        $query = $db->prepare(
            self::getContactQuery() .
            'WHERE cont.id = ? ' .
            'GROUP BY cont.id ' .
            'ORDER BY cont.first_name'
        );
        $query->execute([$id]);
        return $query->fetch();
    }

    /**
     * @param $data
     * @throws Exception
     */
    public static function create($data)
    {
        $db = DB::getConnection();

        try {
            $db->beginTransaction();

            $query = $db->prepare(
                'INSERT INTO contacts (first_name, last_name) VALUES (?,?)'
            );
            $query->execute([$data['first_name'], $data['last_name']]);
            $contactId = $db->lastInsertId();

            foreach ($data['phone_numbers']['toCreate'] as $phoneNumber) {

                $query = $db->prepare(PhoneNumbers::createQuery());
                $query->execute([$contactId, $phoneNumber]);
            }
            $db->commit();
        } catch (Exception $exception) {

            $db->rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param $id
     * @param $data
     * @throws Exception
     */
    public static function update($id, $data)
    {
        $db = DB::getConnection();

        try {
            $db->beginTransaction();

            $query = $db->prepare(
                'UPDATE contacts SET first_name = ?, last_name = ? WHERE id = ?'
            );
            $query->execute([$data['first_name'], $data['last_name'], $id]);

            if (isset($data['phone_numbers']['toCreate'])) {
                foreach ($data['phone_numbers']['toCreate'] as $phoneNumber) {

                    $query = $db->prepare(PhoneNumbers::createQuery());
                    $query->execute([$id, $phoneNumber]);
                }
            }

            foreach ($data['phone_numbers']['toUpdate'] as $key => $phoneNumber) {

                $query = $db->prepare(PhoneNumbers::updateQuery());
                $query->execute([$phoneNumber, $key]);
            }
            $db->commit();
        } catch (Exception $exception) {
            $db->rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function delete($id)
    {
        $db = DB::getConnection();

        $query = $db->prepare(
            'DELETE FROM contacts WHERE id = ?'
        );
        $query->execute([$id]);
        return $query->fetch();
    }
}