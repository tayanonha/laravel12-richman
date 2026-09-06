<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    // แสดงข้อมูลทั้งหมด และส่งข้อมูลให้ Google Chart
    public function index()
    {
        $weights = Weight::orderBy('recorded_on', 'asc')->get();

        // เตรียมข้อมูล Array สำหรับ Google Chart
        $chartData = [['วันที่', 'น้ำหนัก (กก.)']];
        foreach ($weights as $w) {
            $chartData[] = [$w->recorded_on, (float)$w->weight];
        }

        return view('weights.index', compact('weights', 'chartData'));
    }

    // หน้าฟอร์มเพิ่มข้อมูล
    public function create()
    {
        return view('weights.create');
    }

    // บันทึกข้อมูลพร้อม Validation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:1|max:300',
            'recorded_on' => 'required|date',
        ], [
            'weight.required' => 'กรุณากรอกน้ำหนักร่างกาย',
            'weight.numeric' => 'น้ำหนักต้องเป็นตัวเลขเท่านั้น',
            'recorded_on.required' => 'กรุณาระบุวันที่บันทึก',
        ]);

        Weight::create($validated);
        return redirect()->route('weights.index')->with('success', 'เพิ่มข้อมูลน้ำหนักสำเร็จ');
    }

    // หน้าฟอร์มแก้ไขข้อมูล
    public function edit(Weight $weight)
    {
        return view('weights.edit', compact('weight'));
    }

    // อัปเดตข้อมูลพร้อม Validation
    public function update(Request $request, Weight $weight)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:1|max:300',
            'recorded_on' => 'required|date',
        ]);

        $weight->update($validated);
        return redirect()->route('weights.index')->with('success', 'แก้ไขข้อมูลน้ำหนักสำเร็จ');
    }

    // ลบข้อมูล
    public function destroy(Weight $weight)
    {
        $weight->delete();
        return redirect()->route('weights.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}

