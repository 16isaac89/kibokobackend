<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatable datatable-Customer">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>User Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dealer->users as $key => $user)
                <tr data-entry-id="{{ $user->id }}">
                    <td></td>
                    <td>{{ $user->id ?? '' }}</td>
                    <td>{{ $user->username ?? '' }}</td>

                   </tr>
            @endforeach
        </tbody>
    </table>
</div>
