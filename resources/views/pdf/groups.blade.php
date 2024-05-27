<!DOCTYPE html>
<html>
<head>
    <title>Groups PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Groups</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Group Name</th>
                <th>Group Set</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{ $group->id }}</td>
                <td>{{ $group->name }}</td>
                <td>{{ $group->groupName }}</td>
                <td>{{ $group->groupSet }}</td>
                <td>{{ $group->created_at }}</td>
                <td>{{ $group->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
