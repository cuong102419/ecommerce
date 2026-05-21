<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Tổng đơn hàng</p>
                    <p class="text-2xl font-bold"></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Doanh thu</p>
                    <p class="text-2xl font-bold">đ</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Sản phẩm</p>
                    <p class="text-2xl font-bold"></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Khách hàng</p>
                    <p class="text-2xl font-bold"></p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
