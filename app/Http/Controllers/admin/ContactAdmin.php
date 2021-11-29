<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactAdmin extends Controller
{
    public function index(Request $request){
        return view('admin.contacts.contacts');
    }
    public function showContacts(Request $request){
        if($request->ajax()){
            $data = Contact::get();

            return DataTables::of($data)
                ->addColumn('transaction', function($row){
                    $editButton = '<a class="editButton" href="/admin/contact-detail/'.$row->id.'" title="Edit">' .
                        '              <i class="fal fa-edit"></i> Edit' .
                        '          </a>';

                    $deleteButton = '<button class="deleteButton" type=button data-id="'.$row->id.'" title="Delete">' .
                        '                <i class="far fa-trash-alt"></i> Delete' .
                        '            </button>';

                    $buttons = $editButton.$deleteButton;

                    return $buttons;
                })
                ->addColumn('created_at', function($row){
                    $date = Carbon::parse($row->created_at)->format('d.m.Y');

                    return $date;
                })
                ->rawColumns(['transaction', 'created_at'])
                ->toJson();

        }
    }
    public function contactDetail($id){
        $contact = Contact::selectRaw('id, name, email, phone, message, created_at')
                        ->where('id', $id)
                        ->get();

        return view('admin.contacts.contact-detail', [
            'contact' => $contact[0]
        ]);
    }
    public function deleteContact(Request $request){
        $contact_id = $request->contactId;

        Contact::where('id', $contact_id)
                ->delete();

        return response()->json([
            'status' => 'successful'
        ]);
    }
}
