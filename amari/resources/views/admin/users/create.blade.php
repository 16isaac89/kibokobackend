@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                        name="password" id="password" required>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]"
                        id="roles" multiple required>
                        @foreach ($roles as $id => $roles)
                            <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>
                                {{ $roles }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                        <div class="invalid-feedback">
                            {{ $errors->first('roles') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="username">{{ trans('cruds.user.fields.username') }}</label>
                    <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text"
                        name="username" id="username" value="{{ old('username', '') }}">
                    @if ($errors->has('username'))
                        <div class="invalid-feedback">
                            {{ $errors->first('username') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.username_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="phonenumber">{{ trans('cruds.user.fields.phonenumber') }}</label>
                    <input class="form-control {{ $errors->has('phonenumber') ? 'is-invalid' : '' }}" type="text"
                        name="phonenumber" id="phonenumber" value="{{ old('phonenumber', '') }}">
                    @if ($errors->has('phonenumber'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phonenumber') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.phonenumber_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="picture">{{ trans('cruds.user.fields.picture') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('picture') ? 'is-invalid' : '' }}"
                        id="picture-dropzone">
                    </div>
                    @if ($errors->has('picture'))
                        <div class="invalid-feedback">
                            {{ $errors->first('picture') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.picture_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="roles">Select User Type</label>
                    <select class="custom-select" id="designation" name="designation">
                        <option selected value="">Choose...</option>
                        <option value="1">Admin</option>
                        <option value="2">Supervisor</option>
                    </select>
                </div>
                <div class="form-group" id="dealer_select">
                    <label class="required" for="roles">Select Dealers</label>
                    <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="dealers[]"
                        id="dealers" multiple>
                        @foreach ($dealers as $dealer)
                            <option value="{{ $dealer->id }}"
                                {{ in_array($dealer->id, old('dealers', [])) ? 'selected' : '' }}>{{ $dealer->tradename }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.options.pictureDropzone = {
            url: '{{ route('admin.users.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function(file, response) {
                $('form').find('input[name="picture"]').remove()
                $('form').append('<input type="hidden" name="picture" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="picture"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($user) && $user->picture)
                    var file = {!! json_encode($user->picture) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="picture" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        //hide dealer select on page load
        $(document).ready(function() {
            $('#dealer_select').hide();
        });
        //on select user type change
        $('#designation').change(function() {
            if ($(this).val() == 2) {
                $('#dealer_select').show();
            } else {
                $('#dealer_select').hide();
            }
        });
    </script>
@endsection
