<x-layout>
    <x-page-heading>Register</x-page-heading>
    <x-forms.form method="POST" action="/register" enctype="multipart/form-data">
        <x-forms.input label="Your Name" name="username" required/>
        <x-forms.input label="Email" name="email" type="email" required/>
        <x-forms.input label="Password" name="password" type="password" required/>
        <x-forms.input label="Password Confirmation" name="password_confirmation" type="password" required/>

        <x-forms.select label="Account Type" name="account_type">
            <option>Personal</option>
            <option>Corporate</option>
        </x-forms.select>

        <x-forms.button>Create Account</x-forms.button>
    </x-forms.form>
</x-layout>