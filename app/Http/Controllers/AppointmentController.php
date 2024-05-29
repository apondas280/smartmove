<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends BaseController
{
    // 1. get all appointments
    public function index()
    {
        $appointments = Appointment::join('services', 'appointments.service_id', 'services.id')
            ->select('appointments.*', 'services.title as service_title', 'services.slug as service_slug')->get();
        return self::sendRes('Appointments fetched successfully', $appointments);
    }

    // 2. store appointment data
    public function store(Request $request)
    {
        $appointment['service_id'] = htmlspecialchars($request->service_id);
        $appointment['first_name'] = htmlspecialchars($request->first_name);
        $appointment['last_name']  = htmlspecialchars($request->last_name);
        $appointment['phone']      = htmlspecialchars($request->phone);
        $appointment['email']      = htmlspecialchars($request->email);
        $appointment['location']   = htmlspecialchars($request->location);
        $appointment['message']    = htmlspecialchars($request->message);

        // insert data in appointment table
        Appointment::insert($appointment);

        // send mail
        $service                      = Service::where('id', $appointment['service_id'])->first();
        $appointment['service_title'] = $service->title;
        self::sendMail($appointment, 'AppointmentMail');

        return self::sendRes('Appointment has been added.');
    }

    // 3. show a single appointment
    public function show($id)
    {
        // check data exists or not
        $service = Appointment::join('services', 'appointments.service_id', 'services.id')
            ->select('appointments.*', 'services.title as service_title', 'services.slug as service_slug')
            ->where('appointments.id', $id)->first();
        if (! $service) {
            return self::sendErr('Data not found.');
        }

        return self::sendRes('Appointment fetched successfully.', $service);
    }

    // 4. delete an appointment
    public function delete($id)
    {
        // check data exists or not
        $appointment = Appointment::find($id);
        if (! $appointment) {
            return self::sendErr('Data not found.');
        }

        // delete appointment record
        $appointment->delete();
        return self::sendRes('Appointment has been deleted.');
    }

    // 5. update appointment data
    public function update(Request $request, $id)
    {
        // check data exists or not
        $appointment_details = Appointment::find($id);
        if (! $appointment_details) {
            return self::sendErr('Data not found.');
        }

        $appointment['service_id'] = htmlspecialchars($request->service_id);
        $appointment['first_name'] = htmlspecialchars($request->first_name);
        $appointment['last_name']  = htmlspecialchars($request->last_name);
        $appointment['phone']      = htmlspecialchars($request->phone);
        $appointment['email']      = htmlspecialchars($request->email);
        $appointment['location']   = htmlspecialchars($request->location);
        $appointment['message']    = htmlspecialchars($request->message);

        // update data
        Appointment::where('id', $id)->update($appointment);
        return self::sendRes('Appointment has been updated.');
    }
}
