<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User
        <small>profile</small>
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
            <form role="form" action="{{ route('backend.user.profile.put') }}" method="post">
            <!-- general form elements disabled -->
                <div class="box box-warning">
                    {{--<div class="box-header with-border">
                        <h3 class="box-title">General Elements</h3>
                    </div><!-- /.box-header -->--}}
                    <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <div class="form-group">
                            <label>Firstname</label>
                            <input type="text" class="form-control" placeholder="Firstname"  name="first_name" value="{{ old('first_name', $user->first_name) }}">
                        </div>

                        <div class="form-group">
                            <label>Lastname</label>
                            <input type="text" class="form-control" placeholder="Lastname"  name="last_name" value="{{ old('last_name', $user->last_name) }}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>

                        <div class="form-group">
                            <label>Retype password</label>
                            <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation">
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ route('backend.dashboard.index.get') }}" class="btn btn-default">Cancel</a>

                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="put">
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </form>
        </div>
    </div>

</section><!-- /.content -->