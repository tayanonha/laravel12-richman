<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        session(['url.intended' => url('/customers')]);

        if (auth()->check()) {
            $query = request()->user()->customers()->latest();
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }
            $customers = $query->get();
        } else {
            $customers = collect();
        }
        
        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'purchase_history' => 'nullable|string',
        ]);

        $request->user()->customers()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'purchase_history' => $request->purchase_history,
        ]);

        return redirect()->back()->with('success', 'เพิ่มข้อมูลลูกค้าเรียบร้อยแล้ว!');
    }

    public function update(Request $request, Customer $customer)
    {
        if ($customer->user_id !== $request->user()->id) {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขข้อมูลนี้');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'purchase_history' => 'nullable|string',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'purchase_history' => $request->purchase_history,
        ]);

        return redirect()->back()->with('success', 'แก้ไขข้อมูลลูกค้าเรียบร้อยแล้ว!');
    }

    public function destroy(Request $request, Customer $customer)
    {
        if ($customer->user_id !== $request->user()->id) {
            abort(403, 'คุณไม่มีสิทธิ์ลบข้อมูลนี้');
        }

        $customer->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลลูกค้าออกจากระบบแล้ว!');
    }

    public function export(Request $request)
    {
        $customers = $request->user()->customers()->latest()->get();
        $filename = "customers_" . date('Y-m-d_H-i') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ลำดับ', 'ชื่อ-นามสกุล', 'อีเมล', 'เบอร์โทรศัพท์', 'ประวัติการซื้อ', 'วันที่เพิ่มข้อมูล'];

        $callback = function() use($customers, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $columns);

            foreach ($customers as $index => $customer) {
                $row = [
                    $index + 1,
                    $customer->name,
                    $customer->email ?? '-',
                    $customer->phone ?? '-',
                    $customer->purchase_history ?? '-',
                    $customer->created_at->format('d/m/Y H:i')
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}