<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;


use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectInquiry;



class DashboardController extends Controller
{


    public function index()
    {


        $user = Auth::user();



        return match($user->type) {


            'company' => $this->company($user),


            'manufacturer' => $this->manufacturer($user),


            'store' => $this->store($user),


            'technician' => $this->technician($user),


            'employer' => $this->employer($user),



            default => abort(404),


        };


    }









    private function company($user)
    {


        $company = $user->company;


        $projects = 0;

        $activeProjects = 0;

        $inquiries = 0;

        $reviews = 0;




        if($company) {


            $projects = $company

                ->projects()

                ->count();





            $activeProjects = $company

                ->projects()

                ->where('status','assigned')

                ->count();






            $inquiries = ProjectInquiry::where(

                'user_id',

                $user->id

            )

            ->count();






            if(method_exists($company,'reviews')) {


                $reviews = $company

                    ->reviews()

                    ->count();


            }



        }





        return view(

            'dashboard.company',

            compact(

                'company',

                'projects',

                'activeProjects',

                'inquiries',

                'reviews'

            )

        );


    }









    private function manufacturer($user)
    {


        $manufacturer = $user->manufacturer;



        $products = 0;

        $projects = 0;

        $inquiries = 0;





        if($manufacturer) {


            $products = Product::where(

                'manufacturer_id',

                $manufacturer->id

            )

            ->count();






            $projects = $manufacturer

                ->projects()

                ->count();






            $inquiries = ProjectInquiry::where(

                'user_id',

                $user->id

            )

            ->count();



        }





        return view(

            'dashboard.manufacturer',

            compact(

                'manufacturer',

                'products',

                'projects',

                'inquiries'

            )

        );


    }









    private function store($user)
    {


        $store = $user->store;



        $products = 0;

        $reviews = 0;




        if($store) {


            $products = $store

                ->products()

                ->count();





            $reviews = $store

                ->reviews()

                ->count();


        }





        return view(

            'dashboard.store',

            compact(

                'store',

                'products',

                'reviews'

            )

        );


    }









    private function technician($user)
    {


        $technician = $user->technician;



        $projects = 0;

        $activeProjects = 0;

        $inquiries = 0;

        $reviews = 0;





        if($technician) {


            $projects = $technician

                ->projects()

                ->count();






            $activeProjects = $technician

                ->projects()

                ->where('status','assigned')

                ->count();






            $inquiries = ProjectInquiry::where(

                'user_id',

                $user->id

            )

            ->count();






            $reviews = $technician

                ->reviews()

                ->count();



        }





        return view(

            'dashboard.technician',

            compact(

                'technician',

                'projects',

                'activeProjects',

                'inquiries',

                'reviews'

            )

        );


    }









    private function employer($user)
    {


        $employer = $user->employer;



        $projects = 0;

        $openProjects = 0;

        $assignedProjects = 0;

        $inquiries = 0;






        if($employer) {


            $projects = $employer

                ->projects()

                ->count();






            $openProjects = $employer

                ->projects()

                ->where('status','open')

                ->count();







            $assignedProjects = $employer

                ->projects()

                ->where('status','assigned')

                ->count();






            $inquiries = ProjectInquiry::whereHas(

                'project',

                function($query) use ($employer) {


                    $query->where(

                        'employer_id',

                        $employer->id

                    );


                }

            )

            ->where('status','pending')

            ->count();



        }







        return view(

            'dashboard.employer',

            compact(

                'employer',

                'projects',

                'openProjects',

                'assignedProjects',

                'inquiries'

            )

        );


    }



}
