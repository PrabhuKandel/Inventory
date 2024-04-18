<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ContactRepository;
use App\Http\Middleware\BranchAccessMiddleware; 
class ContactController extends Controller
{
    private  $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-contact|create-contact|edit-contact|delete-contact')->only('index');
        $this->middleware('permission:create-contact|edit-contact', ['only' => ['create','store']]);
        $this->middleware('permission:edit-contact|delete-contact', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-contact', ['only' => ['destroy']]);
        $this->contactRepository = $contactRepository;
    }
    public function index()
    {
        $contacts =  $this->contactRepository->getAll();
        return view('administrator.contact.contact_details',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('administrator.contact.create_contact');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
        $data = $request->validate([

            'name' => 'required|string|unique:contacts',
            'address' => 'required|string',
            'type'=>'required|string',
            'created_date'=>'required',
        ]);
        
         $response = $this->contactRepository->store($data); 
                 
         if($response)
         {
             return back()->withSuccess('Contact created !!!!');

         }
            
        }
        
        
    

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $contacts =  $this->contactRepository->getAll();
        return view('administrator.contact.contact_details',compact('contacts','branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $contact = $this->contactRepository->find($id);
        return view('administrator.contact.edit_contact',['contact'=>$contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $data =  $request->validate([

            'name' => 'required|string|unique:contacts,name,'.$id,
            'address' => 'required|string',
        ]);
        $response = $this->contactRepository->update($data,$id);
        if($response)
        {
            return back()->withSuccess('Contact updated succesfully !!!!');

        }
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
       $response=$this->contactRepository->delete($id);
       if($response)
       {
        return back()->withSuccess('Deleted Successfully');
       }
       else
       {
        return back()->withSuccess('Failed to delete');
       }
    }
}
