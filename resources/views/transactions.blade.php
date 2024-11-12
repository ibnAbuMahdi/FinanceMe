<x-layout>
    <x-page-heading>
        @if ($title)
            {{ "$title  Transactions" }}
        @else
            {{ "Recent Transactions" }}
        @endif
    </x-page-heading>
    <x-transactions-table>
        @if (count($data))
            @foreach ($data as $row)
                @php
                    $id = $row['id'];

                @endphp
                <tr>
                    <td class="font-medium bg-white text-black whitespace-nowrap dark:text-white">{{ $row['title'] }}</td>
                    <td>{{ $row['category'] }}</td>
                    <td>{{ $row['description'] }}</td>
                    <td>{{ $row['amount'] }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['budget_title'] }}</td>
                    <td>
                        <x-menu-icon :$id>
                            @php
                                $date = DateTime::createFromFormat('d M Y h:ia', $row['date']);
                                $formattedDate = $date->format('Y-m-d H:i');
                                $row['date'] = explode(' ', $formattedDate)[0];
                                $row['time'] = explode(' ', $formattedDate)[1];
                            @endphp
                            <li>
                                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <button class="w-full" data-modal-target='crud-modal' onclick="openModal(
                                                    {{htmlspecialchars($row['id'])}},
                                                    '{{htmlspecialchars($row['title'])}}',
                                                    {{htmlspecialchars($row['amount'])}},
                                                    '{{htmlspecialchars($row['category'])}}',
                                                    '{{htmlspecialchars($row['description'])}}',
                                                    '{{htmlspecialchars($row['date'])}}',
                                                    '{{htmlspecialchars($row['time'])}}'
                                                     )">Edit</button>
                                </a>

                            </li>
                            <li>
                                <form method="POST" action="/transactions/{{$id}}">
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
    </x-transactions-table>
    <x-transaction-modal></x-transaction-modal>
    @push('scripts')
        <script>
            function openModal(id, title, amount, category, description, date, time) {
                document.getElementById('id').value = id
                document.getElementById('title').value = title
                document.getElementById('amount').value = amount
                document.getElementById('category').value = category
                document.getElementById('description').value = description
                document.getElementById('date').value = date
                document.getElementById('time').value = time
                document.getElementById('crud-modal').classList.remove('hidden')
            }

            function closeModal() {
                document.getElementById('crud-modal').classList.add('hidden')

            }
        </script>
    @endpush
</x-layout>