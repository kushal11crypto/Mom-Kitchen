<x-app-layout>
<div class="p-6">

    <h2 class="text-xl font-bold mb-4">Earnings</h2>

    <div class="mb-4 text-green-600 font-bold">
        Total Earnings: Rs. {{ $totalEarnings }}
    </div>

    <div class="bg-white shadow rounded-lg">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Amount</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $tx)
                <tr class="border-t">
                    <td class="p-2">Rs. {{ $tx->amount }}</td>
                    <td class="p-2">{{ $tx->status }}</td>
                    <td class="p-2">{{ $tx->transaction_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>