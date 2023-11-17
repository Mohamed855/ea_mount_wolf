<!DOCTYPE html>
<html>
    <head>
        <style>
            h2{text-align:center;text-decoration:underline}
            .details{text-align:left}
            table{text-align: center;margin: 0 auto;border-collapse: collapse;width: 100%}
            th, td{text-align: center;padding:8px}
            th{background-color:#030101;color:white}
        </style>
    </head>
    <body>
        <h2>{{ ( $table == 'file_views' ? 'File' : 'Video' ) . ' Views Report' }}</h2>
        <div class="details">
            <h3>Name: {{ ucfirst($fileOrVideo->name) }}</h3>
            <h3>Sector: {{ ucfirst($fileOrVideo->sector_name) }}</h3>
            <h3>Line: {{ ucfirst($fileOrVideo->line_name) }}</h3>
        </div>
        <table>
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Viewed At</th>
            </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                    <tr>
                        <td>{{ $user->role == 1 ? ucfirst($user->first_name) : ucfirst($user->first_name) . ' ' . ucfirst($user->middle_name) . ' ' . ucfirst($user->last_name) }}</td>
                        <td>{{ $user->role == 1 ? '_____' : ucfirst($user->user_name) }}</td>
                        <td>
                            @if($user->role == 1)
                                Admin
                            @elseif($user->role == 2)
                                Manager
                            @else
                                Employee
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
