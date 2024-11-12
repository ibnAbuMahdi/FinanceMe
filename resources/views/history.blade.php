<x-layout>
    <x-page-heading>
        History
    </x-page-heading>
    <x-history-chart :$data></x-history-chart>

    <x-forms.label label="Inactive Budgets" name="inactive_budgets"></x-forms.label>
    <x-budgets-table>
        @if (count($data))
            @foreach ($data as $row)
                @php
                    $id = $row['id'];
                @endphp
                <tr>
                    <td class="font-medium text-black bg-white whitespace-nowrap dark:text-white">{{ $row['title'] }}</td>
                    <td>{{ $row['category'] }}</td>
                    <td>{{ $row['amount'] }}</td>
                    <td>{{ ucfirst($row['period']) }}</td>
                    <td>
                        <x-menu-icon :$id>
                            <li>
                                <a href="/budgets/{{$id}}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-center dark:hover:text-white">View</a>
                            </li>
                            <li>
                                <form method="POST" action="/budgets/{{$id}}">
                                    @csrf
                                    @method('DELETE')
                                    <a class="block px-4 py-2 bg-red-300 dark:hover:bg-gray-600 dark:hover:text-white"><button
                                            class="w-full">Delete</button></a>
                                </form>

                            </li>
                        </x-menu-icon>
                    </td>
                </tr>
            @endforeach
        @endif
    </x-budgets-table>
</x-layout>