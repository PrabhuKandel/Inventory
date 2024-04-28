<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CommonRepository;
use App\Http\Middleware\BranchAccessMiddleware;
use App\Models\Contact;

class ContactController extends Controller
{
    private  $commonRepo;
    private $contactId;
    private $branch;
    public function __construct(Request $request)
    {
        $this->contactId = $request->route('contact');
        $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' ? $request->route()->parameters['id'] : false;
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-contact|create-contact|edit-contact|delete-contact')->only('index');
        $this->middleware('permission:create-contact|edit-contact', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-contact|delete-contact', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-contact', ['only' => ['destroy']]);
        $this->commonRepo = new CommonRepository(new Contact());
    }
    public function index()
    {
        $branch = $this->branch;
        $contacts =  $this->commonRepo->getAll();
        return view('administrator.contact.contact_details', compact('contacts', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $contactId = $this->contactId;
        return view('administrator.contact.create_contact', compact('contactId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $data = $request->validate([

            'name' => 'required|string|unique:contacts',
            'address' => 'required|string',
            'type' => 'required|string',
            'created_date' => 'required',
        ]);

        $response = $this->commonRepo->store($data);

        if ($response) {
            return back()->withSuccess('Contact created !!!!');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $branch = $this->branch;
        $contactId = $request->route('contact');
        $contact = $this->commonRepo->find($contactId);
        //finding products in that warehouse
        return view('administrator.contact.view_contact', compact('contact', 'branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $contactId = $this->contactId;
        $contact = $this->commonRepo->find($id);
        return view('administrator.contact.create_contact', ['contact' => $contact], compact('contactId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  $request->validate([

            'name' => 'required|string|unique:contacts,name,' . $id,
            'address' => 'required|string',
        ]);
        $response = $this->commonRepo->update($data, $id);
        if ($response) {
            return back()->withSuccess('Contact updated succesfully !!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $response = $this->commonRepo->delete($id);
        if ($response) {
            return back()->withSuccess('Deleted Successfully');
        } else {
            return back()->withSuccess('Failed to delete');
        }
    }
}
