@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="background-color: palegreen">
                    <div class="card-header" style="text-align: center">{{ __('Enter Licence Key') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="licenceKey"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Licence Key') }}</label>
                            <div class="col-md-6">
                                <input id="licenceKey" type="text"
                                       class="form-control @error('licenceKey') is-invalid @enderror" name="licenceKey"
                                       value="{{ old('licenceKey') }}" required autocomplete="licenceKey" autofocus>

                                @error('licenceKey')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary btn-lg btn-block" id="saveButton">Save
                                </button>
                            </div>
                        </div>
                        <p style="text-align: right">Return to <a href="" style="color: yellow">Login</a> page </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{--    Toaster script--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#saveButton').on('click', function (e) {
                e.preventDefault();
                let key = $('#licenceKey').val();
                const formData = {'licenceKey': key};
                $.ajax({
                    url: 'active-licence-key',
                    type: 'GET',
                    data: formData,
                    datatype: 'json'
                })
                    .done(function (data) {
                        if (data.success == 1) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        // danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                        // console("fail to return response");
                    });

            });
        });

    </script>
@endsection
