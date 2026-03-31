@extends('layouts.admin')
@section('title', 'Manage Users')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name/email..." class="border rounded-lg px-4 py-2 text-sm w-64 focus:outline-blue-500">
            <select name="role" class="border rounded-lg px-4 py-2 text-sm focus:outline-blue-500">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Filter</button>
        </form>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Add New User
        </a>
    </div>

    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Role</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Joined</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($users as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">{{ $user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $user->username }}</div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                        {{ $user->role == 'admin' ? 'bg-red-100 text-red-600' : ($user->role == 'vendor' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600') }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                        @if($user->role !== 'admin')
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete user?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="p-4 border-t">
        {{ $users->links() }}
    </div>
</div>
@endsection