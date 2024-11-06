    <x-panel class="basis-1/4">
        <h3 class="font-bold text-lg">Add Transaction</h3>
        <x-forms.form method="POST" action="/add-transaction">
            <x-forms.input label="Title" name="title" type="text" />
            <x-forms.input label="Amount" name="amount" type="number" />
            <x-forms.input label="Description" name="description" type="text" />
            <x-forms.input label="Category" name="category" type="text" />
            <x-forms.select label="Budget" name="budget">
                <option>Budget1</option>
                <option>Budget2</option>
            </x-forms.select>
            <x-forms.button>Add</x-forms.button>
        </x-forms.form>
    </x-panel>