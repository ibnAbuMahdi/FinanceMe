<x-layout>
    <x-page-heading>
        Budgets
    </x-page-heading>
    <x-budgets-table>
        @if (count($data))
            @foreach ($data as $row)
                <tr>
                    <td class="font-medium text-white whitespace-nowrap dark:text-white">{{ $row['title'] }}</td>
                    <td>{{ $row['category'] }}</td>
                    <td>{{ $row['amount'] }}</td>
                    <td>{{ $row['period'] }}</td>
                    <td>{{ $row['active'] ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        @endif
    </x-budgets-table>
</x-layout>