<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BBLK - Report Sampel</title>

    <style>
        .page-break {
            page-break-after: always;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">based on the category</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Category</th>
                <th>Total Book</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->book_category_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h1 style="text-align: center;">based on the publisher</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Publisher</th>
                <th>Total Book</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publishers as $publisher)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $publisher->name }}</td>
                    <td>
                        {{ $publisher->book_publisher_count }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h1 style="text-align: center;">based on the writer</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Writer</th>
                <th>Total Book</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($writers as $writer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $writer->name }}</td>
                    <td>{{ $writer->book_writer_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
