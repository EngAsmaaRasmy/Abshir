<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
      return view("landing_page.index_ar");
    }
    public function driverPrivacy()
    {
      return view("landing_page.driver_privacy");
    }
    public function privacy()
    {
      return view("landing_page.privacy");
    }
    public function under_maintenance()
    {
      return view("landing_page.under_maintenance");
    }
}
