<x-weight title="แก้ไขข้อมูลน้ำหนัก - Weight Tracker">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">แก้ไขข้อมูลน้ำหนัก</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('weights.update', $weight->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="recorded_on" class="form-label">วันที่</label>
                            <input type="date" class="form-control @error('recorded_on') is-invalid @enderror" id="recorded_on" name="recorded_on" value="{{ old('recorded_on', $weight->recorded_on) }}">
                            @error('recorded_on')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">น้ำหนัก (กิโลกรัม)</label>
                            <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $weight->weight) }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('weights.index') }}" class="btn btn-secondary">กลับ</a>
                            <button type="submit" class="btn btn-warning">อัปเดตข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-weight>