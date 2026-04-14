@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Payments Overview</h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Total Revenue</h5>
                <h3>Rs. {{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h5>Total Pending</h5>
                <h3>Rs. {{ number_format($totalPending, 2) }}</h3>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order</th>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>#{{ $payment->order_id }}</td>
                    <td>{{ $payment->order->user->name ?? 'N/A' }}</td>
                    <td>Rs. {{ $payment->payment_amount }}</td>
                    <td>
                        <span class="badge bg-{{ $payment->payment_status == 'pending' ? 'warning' : 'success' }}">
                            {{ ucfirst($payment->payment_status) }}
                        </span>
                    </td>
                    <td>{{ $payment->payment_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection