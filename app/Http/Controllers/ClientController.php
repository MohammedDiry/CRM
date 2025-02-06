<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
     // عرض جميع العملاء
     public function index()
     {
         $clients = Client::all();
         return view('clients.index', compact('clients'));
     }

     // عرض نموذج إضافة عميل جديد
     public function create()
     {
         return view('clients.create');
     }

     // تخزين عميل جديد في قاعدة البيانات
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:clients,email',
             'phone' => 'required|string|max:15',
         ]);

         Client::create([
             'name' => $request->name,
             'email' => $request->email,
             'phone' => $request->phone,
             'company_name' => $request->company_name,
             'address' => $request->address,
             'feedback' => $request->feedback,
         ]);

         return redirect()->route('clients.index')->with('success', 'Client created successfully!');
     }

     // عرض نموذج تعديل بيانات العميل
     public function edit(Client $client)
     {
         return view('clients.edit', compact('client'));
     }

     // تحديث بيانات العميل في قاعدة البيانات
     public function update(Request $request, Client $client)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:clients,email,' . $client->id,
             'phone' => 'required|string|max:15',
         ]);

         $client->update([
             'name' => $request->name,
             'email' => $request->email,
             'phone' => $request->phone,
             'company_name' => $request->company_name,
             'address' => $request->address,
             'feedback' => $request->feedback,
         ]);

         return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
     }

     // حذف العميل من قاعدة البيانات
     public function destroy(Client $client)
     {
         $client->delete();
         return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
     }
}
