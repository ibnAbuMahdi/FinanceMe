<x-layout>
    <x-page-heading>
        Budgets
    </x-page-heading>
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
                    <td>{{ ucwords($row['period']) }}</td>
                    <td>
                        <x-menu-icon :$id>
                            <li>
                                <a href="/budgets/{{ $id }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-center dark:hover:text-white">View</a>
                            </li>
                            <li>
                                <a
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <button class="w-full" data-modal-target='crud-modal' onclick="openModal(
                                    {{htmlspecialchars($row['id'])}},
                                    '{{htmlspecialchars($row['title'])}}',
                                    {{htmlspecialchars($row['amount'])}},
                                    '{{htmlspecialchars($row['category'])}}',
                                    '{{htmlspecialchars(ucfirst($row['period']))}}'
                                     )">Edit</button>
                                </a>
                                
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
    <x-budget-modal status="active"></x-budget-modal>
    @push('scripts')
    <script>
        function openModal(id, title, amount, category, period){
            document.getElementById('id').value = id
            document.getElementById('title').value = title
            document.getElementById('amount').value = amount
            document.getElementById('category').value = category
            document.getElementById('period').value = period
            document.getElementById('crud-modal').classList.remove('hidden')
        }

        function closeModal(){
            document.getElementById('crud-modal').classList.add('hidden')

        }
    </script>
    @endpush
</x-layout>