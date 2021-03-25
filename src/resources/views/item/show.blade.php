@extends('layouts.master')
@push('css')
<link href="{{ url('assets/vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="page-header no-gutters has-tab">
    <h2 class="font-weight-normal">{{ $detail->name }}</h2>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tab-detail">Detail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab-transaction">Detail Transaksi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab-edit">Edit Item</a>
        </li>
    </ul>
</div>
<div class="container">
    <div class="tab-content m-t-15">
        <div class="tab-pane fade show active" id="tab-detail">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail</h4>
                </div>
                <div class="card-body">
                    <table class="product-info-table">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td class="text-dark font-weight-semibold">{{ $detail->name }}</td>
                            </tr>
                            <tr>
                                <td>Stok</td>
                                <td>{{ $detail->stock }}</td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>{{ number_format($totalPrice) }}</td>
                            </tr>
                            <tr>
                                <td>Expired</td>
                                <td>{{ \Carbon\Carbon::parse($expired)->format('d-m-Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-transaction">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4>List Transaksi</h4>
                            <p>Di bawah ini merupakan list transaksi item.</p>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-primary float-right" href="{{ route('stock.create', $detail->id) }}">Tambah transaksi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Transaksi Item</h4>
                </div>
                <div class="card-body">
                    <table class="table" id="datatable" width="100%">
                        <thead>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Expired</th>
                            <th style="width: 50px;">Total</th>
                            <th style="width: 10px; text-align: center"><i class='anticon anticon-setting'></i></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-edit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Item</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('item.update', $detail->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama item</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama item" value="{{ $detail->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ url('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            paginate: true,
            info: true,
            sort: true,
            processing: true,
            serverSide: true,
            order: [1, 'ASC'],
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('stock.list') }}",
                data: {
                    id: "{{ $detail->id }}"
                },
                method: "POST"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-center',
                    width: '10px'

                },
                {
                    data: 'invoice',
                },
                {
                    data: 'expired',
                },
                {
                    data: 'total',
                    class: 'text-right'
                },
                {
                    data: 'action',
                    class: 'text-center',
                    width: '10px'
                }
            ]
        });

    })
</script>
@endpush