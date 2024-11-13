<x-layout>
    <x-page-heading>Login</x-page-heading>
    <x-forms.form method="POST" action="/login" >
        <x-forms.input label="Username" name="username" type="text" required/>
        <x-forms.input label="Password" name="password" type="password" required/>
        <x-forms.select label="Account Type" name="account_type">
            <option value="personal">Personal</option>
            <option value="corporate">Corporate</option>
        </x-forms.select>
        <x-forms.button>Log In</x-forms.button>
    </x-forms.form>
</x-layout>