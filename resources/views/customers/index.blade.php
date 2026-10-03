<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .table th { font-weight: 600; color: #495057; }
    </style>
</head>
<body>
    
    @guest
        <div class="container py-5" style="max-width: 1000px;">
            <div class="d-flex flex-column justify-content-center align-items-center text-center mt-5 pt-5">
                <h1 class="fw-bold mb-3" style="font-size: 3.5rem; color: #2c3e50;">Customer Management System</h1>
                <p class="text-muted mb-5 fs-5">ระบบจัดการลูกค้า</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('register', ['source' => 'customers']) }}" class="btn btn-outline-primary rounded-pill px-5 py-2 fw-bold">Register</a>
                    <a href="{{ route('login', ['source' => 'customers']) }}" class="btn btn-primary rounded-pill px-5 py-2 fw-bold">Login</a>
                </div>
            </div>
        </div>
    @endguest

    @auth
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#"><i class="bi bi-people-fill me-2"></i>Customer Management System</a>
                <div class="d-flex align-items-center text-white gap-3">
                    <span><i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light rounded-pill">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container pb-5">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body p-4">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-6">
                            <form action="{{ route('customers.index') }}" method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control" placeholder="ค้นหาชื่อ หรือ เบอร์โทรศัพท์..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                                
                                @if(request('search'))
                                    <a href="{{ route('customers.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i></a>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
                            <a href="{{ route('customers.export') }}" class="btn btn-outline-success">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export
                            </a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                <i class="bi bi-plus-lg me-1"></i> เพิ่มลูกค้าใหม่
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">ชื่อ-นามสกุล</th>
                                    <th width="20%">อีเมล</th>
                                    <th width="15%">เบอร์โทร</th>
                                    <th width="25%">ประวัติการซื้อ</th>
                                    <th width="15%">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($customers->count() > 0)
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="fw-bold">{{ $customer->name }}</td>
                                            <td>{{ $customer->email ?? '-' }}</td>
                                            <td>{{ $customer->phone ?? '-' }}</td>
                                            <td>{{ $customer->purchase_history ?? '-' }}</td>
                                            <td class="text-center d-flex justify-content-center gap-1">
                                                
                                                <button class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลลูกค้ารายนี้?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3-fill"></i></button>
                                                </form>

                                            </td>
                                        </tr>

                                        <!-- Modal สำหรับแก้ไขข้อมูลลูกค้า -->
                                        <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="editCustomerModalLabel{{ $customer->id }}">แก้ไขข้อมูลลูกค้า</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                                                                <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">อีเมล</label>
                                                                <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">เบอร์โทรศัพท์</label>
                                                                <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">ประวัติการซื้อ (ถ้ามี)</label>
                                                                <textarea name="purchase_history" class="form-control" rows="3">{{ $customer->purchase_history }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                            <button type="submit" class="btn btn-warning text-dark fw-bold">อัปเดตข้อมูล</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            @if(request('search'))
                                                ไม่พบข้อมูลที่ค้นหา
                                            @else
                                                ยังไม่มีข้อมูลลูกค้าในระบบ
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal เพิ่มลูกค้าใหม่ -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="addCustomerModalLabel">เพิ่มข้อมูลลูกค้าใหม่</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">อีเมล</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ประวัติการซื้อ (ถ้ามี)</label>
                                <textarea name="purchase_history" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>