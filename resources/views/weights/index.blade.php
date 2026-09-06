<x-weight title="ประวัติน้ำหนัก - Weight Tracker">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>ข้อมูลน้ำหนักของคุณ</h2>
        <a href="{{ route('weights.create') }}" class="btn btn-primary">บันทึกน้ำหนักเพิ่ม</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div id="curve_chart" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>วันที่บันทึก</th>
                        <th>น้ำหนัก (กิโลกรัม)</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($weights as $item)
                        <tr>
                            <td>{{ $item->recorded_on }}</td>
                            <td>{{ $item->weight }}</td>
                            <td>
                                <a href="{{ route('weights.edit', $item->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                                <form action="{{ route('weights.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ต้องการลบข้อมูลนี้หรือไม่?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">ยังไม่มีข้อมูลน้ำหนัก</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(@json($chartData));
        var options = {
          title: 'กราฟแสดงแนวโน้มน้ำหนัก',
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 5
        };
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
      }
    </script>
</x-weight>