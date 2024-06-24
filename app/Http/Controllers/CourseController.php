<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pdf;
use App\Models\Voices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Role;

class CourseController extends Controller
{
    public function index( Request $request)
    {
        return view('vendor.voyager.slug-name.course');
    }
    public function uploadFiles(Request $request)
    {

                // Validate the form data
                $request->validate([
                    'course' => 'required',
                    'pdf_file' => 'mimes:pdf',
                    //'voice_file' => 'required|mimetypes:audio/mpeg,audio/wav',
                ]);

                // Get the selected course
                $course = $request->input('course');
                $course_id = Course::where('course_name',$course)->first()->id;
                // Get the PDF file
                if($request->file('pdf_file') != null)
                {
                    $pdfFile = $request->file('pdf_file');
                    $pdfFileName = $pdfFile->getClientOriginalName();
                    $pdfPath = $pdfFile->store('pdfs');
                    $createdPdf = [
                        'file_name' => $pdfFileName,
                        'path' => $pdfPath,
                        'course_id' => $course_id
                    ];
                    $pdf = Pdf::create($createdPdf);
                }


                // Get the voice file
                if($request->file('voice_file') != null)
                {
                    $voiceFile = $request->file('voice_file');
                    $voiceFileName = $voiceFile->getClientOriginalName();
                    $voicePath = $voiceFile->store('voices');
                    $createdVoice = [
                     'file_name' => $voiceFileName,
                     'path' => $voicePath,
                     'course_id' => $course_id
                    ];
                    $voice = Voices::create($createdVoice);
                }
                // Redirect the user or return a response
                return redirect()->back()->with('success', 'Files uploaded successfully.');
    }
   public function viewFilesPdf()
        {
           // $user =auth()->user();
            $user=Auth::user();

            $role_id = $user->role_id;
            $role = Role::find($role_id);
            $permissions = $role->permissions;
           // dd( sizeof($permissions));
            if(sizeof($permissions) != 0)
            {
                $roleName = Role::find($role_id)->with('permissions')->name;
                $cours_id = Course::where('name',$roleName)->first()->id;
                $pdfs = Pdf::where('course_id',$cours_id)->get();
                $pdfs = Pdf::all();
                $Responsepdfs = [];
                foreach($pdfs as $key => $pdf)
                {
                    $name = $pdf['file_name'];
                  //$fullPath = storage_path('app\\' . $pdf['path']);
                //  dd($pdf['path']);
                    $Responsepdfs[$key] = [
                        'file_name' =>$name ,
                        'path' =>'app\\'.$pdf['path'],
                    ];

                }
            //    $voice = Voices::where('course_id',$cours_id)->get();
                return response()->json([
                    'Pdfs'=> $Responsepdfs,
                ]);
            }



        }
        public function viewFilesVoice()
        {
            // $user = Auth::user();
            // $role_id = $user->role;
            // $roleName = Role::find($role_id)->name;
            // $cours_id = Course::where('name',$roleName)->first()->id;
            // $pdfs = Pdf::where('course_id',$cours_id)->get();
            $voices = Voices::all();
            $Responsevoices = [];

            foreach($voices as $key => $voice)
            {
                $name = $voice['file_name'];
              //$fullPath = storage_path('app\\' . $pdf['path']);
            //  dd($pdf['path']);
                $Responsevoices[$key] = [
                    'file_name' =>$name ,
                    'path' =>'app\\'.$voice['path'],
                ];

            }
        //    $voice = Voices::where('course_id',$cours_id)->get();
            return response()->json([
                'voice'=> $Responsevoices,
            ]);


        }
}
