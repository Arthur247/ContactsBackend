<?php

return [
    'contacts/getList' => 'contacts/getList',
    'contacts/search' => 'contacts/search',
    'contacts/view/([0-9]+)' => 'contacts/view/$1',
    'contacts/create' => 'contacts/create',
    'contacts/update/([0-9]+)' => 'contacts/update/$1',
    'contacts/delete/([0-9]+)' => 'contacts/delete/$1',

    'phoneNumbers/create/([0-9]+)' => 'phoneNumbers/createContactNumber/$1'
];