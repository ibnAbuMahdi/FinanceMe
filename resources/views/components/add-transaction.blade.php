@props(['data'])
<x-panel class="basis-1/4">
    <h3 class="font-bold text-lg">Add Transaction</h3>
    <x-forms.form method="POST" action="/transactions">
        <x-forms.input label="Title" name="title" type="text" />
        <x-forms.input label="Amount" name="amount" type="number" step="0.01" min=0 />
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
</x-panel>