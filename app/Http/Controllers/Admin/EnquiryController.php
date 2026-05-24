<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:enquiry-create|enquiry-edit|enquiry-delete|enquiry-publish', ['only' => ['index', 'store']]);
        // $this->middleware('permission:enquiry-create', ['only' => ['store']]);
        // $this->middleware('permission:enquiry-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:enquiry-delete', ['only' => ['destroy']]);
        $this->middleware('permission:enquiry-read', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Enquiry::orderBy('created_at', 'DESC')->where('name', 'LIKE', "%{$request->search}%")
                ->paginate(10);
            return view('admin.enquiry.dataTable', compact('data'))->render();
        } else {
            $data = Enquiry::orderBy('created_at', 'DESC')->paginate(10);
            return view('admin.enquiry.index', compact('data'));
        }
    }

    public function show(Request $request)
    {
        $row = Enquiry::where('id', $request->id)->first();
        echo '<div class="modal-header">
            <h4 class="modal-title">Enquiry Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-borderless">
            <tbody>
            <tr>
              <th>Date</th>
              <td> ' . $row->created_at . '</td>
              <th>Name</th>
              <td> ' . $row->name . '</td>
            </tr>
            <tr>
              <th>Email</th>
              <td> ' . $row->email . '</td>
              <th>Phone</th>
              <td> ' . $row->phone . '</td>
            </tr>
            <tr>
              <th colspan="4">Message</th>
            </tr>
            <tr>
              <td colspan="4"> ' . $row->message . '</td>
            </tr>
            </tbody>
            </table>
        </div>';
    }
}
