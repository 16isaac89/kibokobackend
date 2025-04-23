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
            @foreach($dealer->users as  $user)
                <tr >
                    <td></td>
                    <td>{{ $user->id ?? '' }}</td>
                    <td>{{ $user->username ?? '' }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('admin.dealer.updateuserview',$user->id) }}">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </td>

                   </tr>
            @endforeach
        </tbody>
    </table>
</div>
