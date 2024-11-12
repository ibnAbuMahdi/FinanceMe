<!-- Modal toggle -->
@props(['data'])
<!-- Main modal -->
<div id="transaction-modal" tabindex="0" aria-hidden="true"
    class="fixed inset-0 z-50 flex overflow-y-auto items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="relative p-4 w-full z-50 max-w-md max-h-full px-10">
        <!-- Modal content -->
        <div class="relative bg-black rounded-lg shadow  dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white dark:text-white">
                    Add Transaction
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="transaction-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <x-forms.form method="POST" action="/transactions">
                <x-forms.input label="Title" name="title" type="text" />
                <x-forms.input label="Amount" name="amount" type="number" step="0.01" min=0 />
                <div class="flex flex-col-2">
                    <x-forms.input label="Date" name="date" type="date" />
                    <x-forms.input label="Time" name="time" type="time" />
                </div>
                <x-forms.input label="Description" name="description" type="text" />
                <x-forms.input label="Category" name="category" type="text" />
                <x-forms.select label="Budget" name="budget">
                    @if ($data['budgets'])
                        @foreach ($data['budgets'] as $budget)
                            <option>{{ $budget['title'] }}</option>
                        @endforeach
                    @else
                        <option selected>Please create a budget</option>
                    @endif
                </x-forms.select>
                @if ($data['budgets'])
                    <x-forms.button>Add</x-forms.button>
                @endif
            </x-forms.form>
        </div>
    </div>
</div>