<x-panel class="basis-1/4">
    <div>
    <h3 class="font-bold text-lg">Add Budget</h3>
    <x-forms.form method="POST" action="/add-transaction">
        <x-forms.input label="Title" name="title" type="text" />
        <x-forms.input label="Amount" name="amount" type="number" />
        <x-forms.input label="Category" name="category" type="text" />
        <x-forms.select label="Period" name="period">
            <option>Monthly</option>
            <option>Yearly</option>
        </x-forms.select>
        <x-forms.button>Add</x-forms.button>
    </x-forms.form>
    </div>
</x-panel>