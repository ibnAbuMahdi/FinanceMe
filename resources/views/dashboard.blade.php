<x-layout>
    <x-page-heading>
        Dashboard
    </x-page-heading>
    <x-forms.label label="Total Transactions" name="total_transactions"></x-forms.label>
    <x-panel class="flex gap-x-6">
        <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
            <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                style="width: 45%"> 45%</div>
        </div>

    </x-panel>

    <div class="mt-6 space-y-6 grid lg:grid-cols-2 gap-4">       
        <x-graph-card></x-graph-card>
        <x-graph-card></x-graph-card>
    </div>
</x-layout>