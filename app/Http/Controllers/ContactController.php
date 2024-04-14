<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ContactRepositoryInterface;


class ContactController extends Controller
{
    private ContactRepositoryInterface $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {

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
         $response = $this->contactRepository->store($request); 
                 
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
        $contact = $this->contactRepository->getById($id);
        return view('administrator.contact.edit_contact',['contact'=>$contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = $this->contactRepository->update($request,$id);
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
