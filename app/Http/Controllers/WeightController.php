<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 1. อย่าลืมนำเข้า Auth ตรงนี้นะครับ

class WeightController extends Controller
{
    // แสดงข้อมูลทั้งหมด และส่งข้อมูลให้ Google Chart
    public function index()
    {
        // 2. ดึงข้อมูลเฉพาะของคนที่ล็อกอินอยู่ (กรองด้วย user_id)
        $weights = Weight::where('user_id', Auth::id())
                        ->orderBy('recorded_on', 'asc')
                        ->get();

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

        // 3. ยัด user_id ของคนที่ล็อกอิน เข้าไปในชุดข้อมูลก่อนเซฟลงฐานข้อมูล
        $validated['user_id'] = Auth::id();

        Weight::create($validated);
        return redirect()->route('weights.index')->with('success', 'เพิ่มข้อมูลน้ำหนักสำเร็จ');
    }

    // หน้าฟอร์มแก้ไขข้อมูล
    public function edit(Weight $weight)
    {
        // 4. เช็คความปลอดภัย: ถ้าข้อมูลนี้ไม่ใช่ของคนที่ล็อกอินอยู่ ให้เตะออก (ป้องกันการเดา URL)
        if ($weight->user_id !== Auth::id()) {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขข้อมูลของผู้อื่น');
        }

        return view('weights.edit', compact('weight'));
    }

    // อัปเดตข้อมูลพร้อม Validation
    public function update(Request $request, Weight $weight)
    {
        // เช็คความปลอดภัยก่อนอัปเดต
        if ($weight->user_id !== Auth::id()) {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขข้อมูลของผู้อื่น');
        }

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
        // เช็คความปลอดภัยก่อนลบ
        if ($weight->user_id !== Auth::id()) {
            abort(403, 'คุณไม่มีสิทธิ์ลบข้อมูลของผู้อื่น');
        }

        $weight->delete();
        return redirect()->route('weights.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}