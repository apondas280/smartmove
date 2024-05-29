<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    public function index()
    {
        $contacts = Contact::get();
        return self::sendRes('Contacts fetched successfully.', $contacts);
    }

    public function store(Request $request)
    {
        $contact['name']    = $request->name;
        $contact['email']   = $request->email;
        $contact['phone']   = $request->phone;
        $contact['address'] = $request->address;
        $contact['message'] = $request->message;

        Contact::insert($contact);

        // send email to the client
        self::sendMail($contact, 'ContactMail');
        return self::sendRes('Contact has been added.');
    }
    
    public function delete($id)
    {
        // check data exists or not
        $contact = Contact::find($id);
        if (! $contact) {
            return self::sendErr('Data not found.');
        }

        // delete contact record
        $contact->delete();
        return self::sendRes('Contact has been deleted.');
    }
}
