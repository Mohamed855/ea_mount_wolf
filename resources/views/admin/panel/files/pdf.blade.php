<!DOCTYPE html>
<html>
    <head>
        <style>
            h1 {
                text-align:center
            }
            table {
                text-align: center;
                margin: 0 auto;
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                text-align: center;
                padding: 8px;
            }

            th {
                background-color: #030101;
                color: white;
            }
        </style>
    </head>
    <body>

        <h1>{{ ucfirst($fileOrVideo->name) . ' Views' }}</h1>

        <table>
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Viewed At</th>
            </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                    <tr>
                        <td>{{ $user->role == 1 ? ucfirst($user->first_name) : ucfirst($user->first_name) . ' ' . ucfirst($user->middle_name) . ' ' . ucfirst($user->last_name) }}</td>
                        <td>{{ $user->role == 1 ? '_____' : ucfirst($user->user_name) }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
