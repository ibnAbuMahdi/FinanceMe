<x-layout>
    <x-page-heading>
        Transactions
    </x-page-heading>
    <x-transactions-table>
        @if (count($data))
            @foreach ($data as $row)
                <tr>
                    <td class="font-medium bg-white text-black whitespace-nowrap dark:text-white">{{ $row['title'] }}</td>
                    <td>{{ $row['category'] }}</td>
                    <td>{{ $row['description'] }}</td>
                    <td>{{ $row['amount'] }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['budget_title'] }}</td>
                </tr>
            @endforeach
        @endif
    </x-transactions-table>
</x-layout>