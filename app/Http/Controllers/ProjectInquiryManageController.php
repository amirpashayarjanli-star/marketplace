<?php

namespace App\Http\Controllers;


use App\Models\ProjectInquiry;



class ProjectInquiryManageController extends Controller
{


    public function accept(ProjectInquiry $inquiry)
    {


        $project = $inquiry->project;



        if(auth()->id() !== $project->employer?->user_id) {

            abort(403);

        }






        if($inquiry->type === 'company') {


            $project->update([

                'company_id' => $inquiry->user->company?->id,

                'status' => 'assigned',

            ]);


        }







        if($inquiry->type === 'technician') {


            $project->update([

                'technician_id' => $inquiry->user->technician?->id,

                'status' => 'assigned',

            ]);


        }







        if($inquiry->type === 'manufacturer') {


            $project->update([

                'manufacturer_id' => $inquiry->user->manufacturer?->id,

                'status' => 'assigned',

            ]);


        }







        $inquiry->update([

            'status' => 'accepted'

        ]);







        $project->inquiries()

            ->where('id','!=',$inquiry->id)

            ->update([

                'status'=>'rejected'

            ]);







        return back()->with(

            'success',

            'درخواست تایید شد و پروژه اختصاص یافت'

        );


    }








    public function reject(ProjectInquiry $inquiry)
    {


        $project = $inquiry->project;




        if(auth()->id() !== $project->employer?->user_id) {

            abort(403);

        }





        $inquiry->update([

            'status'=>'rejected'

        ]);






        return back()->with(

            'success',

            'درخواست رد شد'

        );


    }


}
