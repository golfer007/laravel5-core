<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User
        <small>list</small>
    </h1>

    {!! Theme::breadcrumb()->render() !!}
</section>

<!-- Main content -->
<section class="content">

    @if (Session::has('messages'))
        @foreach (Session::get('messages') as $key => $val)
        <div class="alert alert-{{ $key }} alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @foreach ($val as $message)
                    <p>{{ $message }}</p>
                @endforeach
        </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                    <div class="box-tools">
                        @if (Auth::user()->can('user-create'))
                        <a href="{{ route('backend.user.create.get') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Create user</a>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <?php
                                        $count = count($user->roles);
                                        $i = 0;
                                    ?>
                                    @foreach($user->roles as $role)
                                        {{ $role->display_name }}
                                        @if ((++$i) < $count)
                                            ,&nbsp;
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $user->active ? 'active' : 'inactive' }}</td>
                                <td>
                                    @if (Auth::user()->can('user-update'))
                                    <a href="{{ route('backend.user.edit.get', $user->id) }}" class="btn btn-warning inline"><i class="fa fa-edit"></i> Edit</a>
                                    @endif

                                    @if (Auth::user()->can('user-suspend') && $user->id != 1)
                                    <form method="post" action="{{ route('backend.user.destroy.delete', $user->id) }}" class="inline">
                                        <input type="hidden" name="_method" value="delete">
                                        {!! csrf_field() !!}
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Suspend</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">User is empty.</td>
                            </tr>
                        @endforelse
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    $users->appends(Input::query());
                    echo $users->render();
                    ?>
                </div><!-- /.box-footer -->
            </div><!-- /.box -->
        </div>
    </div>

</section><!-- /.content -->