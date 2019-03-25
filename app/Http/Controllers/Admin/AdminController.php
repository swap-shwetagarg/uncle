<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Services\CarService;
use App\Services\YearService;
use App\Services\ModelService;
use App\Services\CarTrimService;
use App\Services\ServiceTypeService;
use App\Services\CategoryService;
use App\Services\CarServiceService;
use App\Services\SubServiceService;
use App\Services\SubServiceOptService;
use App\Services\UserService;
use App\Services\ZipCodeService;
use BookingCount;
use App\Helpers\CalculateTime;
use App\Models\Booking;
use App\User;
use App\Role;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Mahesh
 */
class AdminController extends Controller {

    private $CarService;
    private $YearService;
    private $ModelService;
    private $CarTrimService;
    private $ServiceTypeService;
    private $CategoryService;
    private $services;
    private $SubServiceService;
    private $SubServiceOptService;
    private $userService;
    private $zipCodeService;

    public function __construct(
    CarService $carService, YearService $yearService, ModelService $modelService, CarTrimService $carTrimService, ServiceTypeService $serviceTypeService, CategoryService $categoryService, SubServiceService $subServiceService, SubServiceOptService $subServiceOptService, UserService $userService, CarServiceService $services, ZipCodeService $zipCodeService
    ) {
        $this->carService = $carService;
        $this->yearService = $yearService;
        $this->modelService = $modelService;
        $this->carTrimService = $carTrimService;
        $this->serviceTypeService = $serviceTypeService;
        $this->categoryService = $categoryService;
        $this->services = $services;
        $this->subServiceService = $subServiceService;
        $this->subServiceOptService = $subServiceOptService;
        $this->userService = $userService;
        $this->zipCodeService = $zipCodeService;
    }

    public function index() {
        $data['page'] = 'dashboard';
        $bookings = BookingCount::createdAt();
        foreach ($bookings as $booking) {
            $time_differ[] = CalculateTime::getTimeDiffer($booking);
        }
        if (isset($time_differ) && count($time_differ) > 0) {
            $data['timeDiffers'] = $time_differ;
        }

        $booking = new Booking();
        $user = new User();
        $role = new Role();

        // Get booking count of all type
        $data['countAll'] = $booking->all()->count();
        $data['countProgressive'] = $booking->ofBookingCount(1)->count();
        $data['countScheduled'] = $booking->ofBookingCount(8)->count();
        $data['countQuoted'] = $booking->ofBookingCount(3)->count();
        $data['countPending'] = $booking->ofBookingCount(4)->count();
        $data['countCompleted'] = $booking->ofBookingCount(6)->count();

        // Get user count
        $data['allUser'] = $user->all()->count();
        $data['countUser'] = $role->OfRoleCount(["type" => 1, "verify" => 1])->count();
        $data['countMechanic'] = $role->OfRoleCount(["type" => 3, "verify" => 1])->count();
        return view('admin/dashboard', $data);
    }

    public function profile() {
        $user = Auth::user();
        return view('admin.user_profile', ['user' => $user]);
    }

    public function changeStatus($id, $status, $type) {
        //dd($id, $status, $type);
        switch ($type) {
            case 'zipcode':
                $result = $this->zipCodeService->update(['status' => $status], $id);
                break;
            case 'car':
                $result = $this->carService->update(['status' => $status], $id);
                break;
            case 'year':
                $result = $this->yearService->update(['status' => $status], $id);
                break;
            case 'carmodel':
                $result = $this->modelService->update(['status' => $status], $id);
                break;
            case 'cartrim':
                $result = $this->carTrimService->update(['status' => $status], $id);
                break;
            case 'servicetype':
                $result = $this->serviceTypeService->update(['status' => $status], $id);
                break;
            case 'category':
                $result = $this->categoryService->update(['status' => $status], $id);
                break;
            case 'service':
                $result = $this->services->update(['status' => $status], $id);
                break;
            case 'subservice':
                $result = $this->subServiceService->update(['status' => $status], $id);
                break;
            case 'subserviceoption':
                $result = $this->subServiceOptService->update(['status' => $status], $id);
                break;
            case 'user':
                $result = $this->userService->update(['verified' => $status], $id);
                break;
            case 'approved':
                (!$status) ?: $this->userService->approvedMechanic($id);
                $result = $this->userService->update(['approved' => $status], $id);
                break;
        }
        if ($result)
            return response()->json(['status' => 'success', 'message' => 'Status saved!']);
        else
            return response()->json(['status' => 'failed', 'message' => 'Some error occured please call admin.']);
    }

    public function changeIsPopular($id, $status) {
        $result = $this->services->update(['is_popular' => $status], $id);
        if ($result)
            return response()->json(['status' => 'success', 'message' => 'Record updated!']);
        else
            return response()->json(['status' => 'failed', 'message' => 'Some error occured please call admin.']);
    }

}
