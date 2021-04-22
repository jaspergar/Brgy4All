<?php

namespace App\Http\Controllers;

use App\Models\Brgy_Announcement;
use App\Models\Brgy_Worker;
use App\Models\Citizen;
use App\Models\Service;
use App\Models\Sector;
use App\Models\ServiceAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{


    // ----------------CITIZEN------------- //

    public function getAllCitizen()
    {
        return Citizen::orderBy('created_at', 'Desc')->get();
    }
    public function updataStatus(Request $req)
    {
        $this->validate($req, [
            'id' => 'required'
        ]);

        //editing the Citizen Status with the new image
        Citizen::where('id', $req->id)->update([
            'status' => 'verified',
        ]);
        return Citizen::find($req->id);
    }

    // public function getCitizen()
    // {
    //     $request = ["solo parent", "senior", "no job"];
    //     $getCitizenId = Sector::select('citizen_id')
    //         ->whereIn('sectorType', $request)
    //         ->distinct()
    //         ->get();

    //     $getCitizen = Citizen::select()
    //         ->whereIn('id', $getCitizenId)
    //         ->where('status', 'verified')
    //         ->get();


    //     return $getCitizen;
    // }


    //    ----------------- END CITIZEN ----------------//



    // ------------ WORKER ------------- //
    public function addWorkerToDb(Request $req)
    {
        //validate 
        $this->validate($req, [
            'brgy_worker_username' => 'required',
            'brgy_worker_fullname' => 'required|unique:brgy__workers',
            'brgy_worker_email' => 'bail|required|email|unique:brgy__workers',
            'brgy_worker_password' => 'bail|required|min:8',
        ]);

        return  Brgy_Worker::create([
            'brgy_worker_username' => $req->brgy_worker_username,
            'brgy_worker_fullname' => $req->brgy_worker_fullname,
            'brgy_worker_email' => $req->brgy_worker_email,
            'brgy_worker_password' => $req->brgy_worker_password,
        ]);
    }
    public function getAllWorkerFromDb()
    {
        return Brgy_Worker::orderBy('created_at', 'Desc')->get();
    }
    public function editWorkerFromDb(Request $req)
    {
        $this->validate($req, [
            'brgy_worker_username' => 'required',
            'brgy_worker_fullname' => 'required|unique:brgy__workers,id,$req->id',
            'brgy_worker_email' => 'bail|required|email|unique:brgy__workers,id,$req->id',
            'brgy_worker_password' => 'bail|required|min:8',
            'id' => 'required'
        ]);


        //editing the category with the new image
        Brgy_Worker::where('id', $req->id)->update([
            'brgy_worker_username' => $req->brgy_worker_username,
            'brgy_worker_fullname' => $req->brgy_worker_fullname,
            'brgy_worker_email' => $req->brgy_worker_email,
            'brgy_worker_password' => $req->brgy_worker_password,
        ]);

        return Brgy_Worker::where('id', $req->id)->get();
    }
    public function deleteWorkerFromDb(Request $req)
    {
        // $this->deleteFile($req->serviceImage);

        $this->validate($req, [
            'brgy_worker_username' => 'required',
            'brgy_worker_fullname' => 'required',
            'brgy_worker_email' => 'required',
            'brgy_worker_password' => 'required',
            'id' => 'required'
        ]);

        Brgy_Worker::where('id', $req->id)->delete();

        return 'Deleted Successfuly';
    }
    // -------------- END WORKER ------------//






    //------- SERVICE  --------//

    public function addServiceToDb(Request $req)
    {
        //validate 
        $this->validate($req, [
            'serviceType' => 'required',
            'serviceTitle' => 'required',
            'serviceDescription' => 'required',
            'serviceImage' => 'required',
            'user_id' => 'required',
            'barangay_id' => 'required'
        ]);

        return  Service::create([
            'serviceType' => $req->serviceType,
            'serviceTitle' => $req->serviceTitle,
            'serviceDescription' => $req->serviceDescription,
            'serviceImage' => $req->serviceImage,
            'serviceStatus' => 'not started',
            'numberOfBeneficiaries' => 0,
            'user_id' => $req->user_id,
            'barangay_id' => $req->barangay_id
        ]);
    }
    public function getAllServicesFromDb()
    {
        return Service::orderBy('created_at', 'Desc')->get();
    }
    public function deleteServiceFromDb(Request $req)
    {
        $this->deleteFile($req->serviceImage);

        $this->validate($req, [
            'serviceType' => 'required',
            'serviceTitle' => 'required',
            'serviceDescription' => 'required',
            'serviceImage' => 'required',
            'id' => 'required'
        ]);

        Service::where('id', $req->id)->delete();

        return 'Deleted Successfuly';
    }

    public function editServiceFromDb(Request $req)
    {
        $this->validate($req, [
            'serviceType' => 'required',
            'serviceTitle' => 'required',
            'serviceDescription' => 'required',
            'serviceImage' => 'required',
            'id' => 'required'
        ]);


        //delete the previous image in the public directory
        $fileName = $req->prevServiceIconImage;
        $this->deleteFile($fileName, false);

        //editing the category with the new image
        Service::where('id', $req->id)->update([
            'serviceType' => $req->serviceType,
            'serviceTitle' => $req->serviceTitle,
            'serviceDescription' => $req->serviceDescription,
            'serviceImage' => $req->serviceImage,
        ]);

        return Service::where('id', $req->id)->get();
    }

    public function generateAttendance(Request $req)
    {

        $getCitizenId = Sector::select('citizen_id')
            ->whereIn('sectorType', $req)
            ->distinct()
            ->get();

        $getCitizen = Citizen::select()
            ->whereIn('id', $getCitizenId)
            ->where('status', 'verified')
            ->get();



        return $getCitizen;
    }

    public function getSectorsById(Request $req)
    {
        return Sector::where('citizen_id', $req->id)->get();
    }

    public function createAttendance(Request $req)
    {
        $lists = $req->citizenList;
        $serId = $req->serviceId;

        for ($i = 0; $i < count($lists); $i++) {
            extract($lists[$i]);

            $data[] = [
                'citizen_id' => $id,
                'service_id' => $serId
            ];
        }
        $chunks = array_chunk($data, count($data));
        foreach ($chunks as $chunk) {
            // return $chunk;
            ServiceAttendance::insert($chunk);
        }

        $attendanceCount = ServiceAttendance::where('service_id', $serId)->count();

        Service::where('id', $serId)->update([
            'numberOfBeneficiaries' => $attendanceCount,
        ]);
        return 'created';
    }

    public function getFullServiceDetails($id)
    {
        return Service::find($id);
    }
    public function getServiceAttendanceList($id)
    {
        $getCitizenId = ServiceAttendance::select('citizen_id', 'status')
            ->where('service_id', $id)
            ->distinct()
            ->get();

        for ($i = 0; $i < count($getCitizenId); $i++) {
            $item = $getCitizenId[$i];

            $response = Citizen::find($item->citizen_id);

            $data[] = [
                'list' => $response,
                'status' => $item->status
            ];
        }
        return $data;
    }

    //count number of citizen attendance in a service
    // public function countAllNumOfCitAttendance(Request $req)
    // {

    //     $id = $req->service_id;
    //     for ($i = 0; $i < count($id); $i++) {
    //         $data[] = [
    //             'service_id' => $id[$i]
    //         ];
    //     }

    //     foreach ($data as $chunk) {
    //         $response = ServiceAttendance::where('service_id', $chunk)->count();
    //         extract($chunk);
    //         $count[] = [
    //             'numberOfBeneficiaries' => $response,
    //             'service_id' => $service_id
    //         ];
    //     }

    //     return $count;
    // }


    // Image upload and delete from server
    public function uploadFileToServer(Request $req)
    {
        $this->validate($req, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time() . '.' . $req->file->extension();
        $req->file->move(public_path('uploads'), $picName);

        return $picName;
    }

    public function deleteFileFromServer(Request $req)
    {
        $fileName = $req->imageName;
        $this->deleteFile($fileName, false);
        return 'done';
    }

    public function deleteFile($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $filePath = public_path() . $fileName;
        }

        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
    // ----- END SERVICE ------ //


    // ------------ ANNOUNCEMENT ------------- //
    public function addAnnouncementToDb(Request $req)
    {
        //validate 
        $this->validate($req, [
            'subject' => 'required',
            'description' => 'required',
        ]);

        return  Brgy_Announcement::create([
            'subject' => $req->subject,
            'description' => $req->description,
        ]);
    }
    public function getAllAnnouncementFromDb()
    {
        return Brgy_Announcement::orderBy('created_at', 'Desc')->get();
    }
    public function editAnnouncementFromDb(Request $req)
    {
        $this->validate($req, [
            'subject' => 'required',
            'description' => 'required',
            'id' => 'required'
        ]);


        //editing the category with the new image
        Brgy_Announcement::where('id', $req->id)->update([
            'subject' => $req->subject,
            'description' => $req->description
        ]);

        return Brgy_Announcement::where('id', $req->id)->get();
    }
    public function deleteAnnouncementFromDb(Request $req)
    {
        // $this->deleteFile($req->serviceImage);

        $this->validate($req, [
            'subject' => 'required',
            'description' => 'required',
            'id' => 'required'
        ]);

        Brgy_Announcement::where('id', $req->id)->delete();

        return 'Deleted Successfuly';
    }
    // -------------- END ANNOUNCEMENT ------------//
}
