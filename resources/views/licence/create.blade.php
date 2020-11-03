@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="background-color: palegreen">
                    <div class="card-header" style="text-align: center">{{ __('Create Licence') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="form-group row">
                            <div class="col-md-8" style="margin-left: 80px">
                                <table class="table table-bordered w-auto temp"
                                       style="display: none; background-color: white">
                                    <tbody>
                                    <tr>
                                        <td>First Name</td>
                                        <td id="firstName"></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td id="lastName"></td>
                                    </tr>
                                    <tr>
                                        <td>Name of Organization</td>
                                        <td id="nameOfOrganization"></td>
                                    </tr>

                                    <tr>
                                        <td>Street</td>
                                        <td id="street">the Bird</td>
                                    </tr>

                                    <tr>
                                        <td>City</td>
                                        <td id="city">the Bird</td>
                                    </tr>

                                    <tr>
                                        <td>Phone</td>
                                        <td id="phone">the Bird</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td id="email">the Bird</td>
                                    </tr>
                                    <tr>
                                        <td>Licence Key</td>
                                        <td id="licenceKey1"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="clientId"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Client ID') }}</label>
                            <div class="col-md-6">
                                <input id="clientId" type="text"
                                       class="form-control @error('clientId') is-invalid @enderror" name="clientId"
                                       value="{{ old('clientId') }}" required autocomplete="clientId" autofocus>

                                @error('clientId')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

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
                                <button type="button" class="btn btn-primary btn-lg btn-block">Save</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="licenceMonthSelection"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Licence For') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" id="licenceMonthSelection"
                                        style="width: 150px; float:right">
                                    <option value="1">1</option>
                                    <option value="3">3</option>
                                    <option value="6">6</option>
                                </select>
                            </div>
                            Months
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                            <button id="create-key" class="" style="float: right;">Create Key</button>
                        </div>
                        <p style="text-align: right">Return to <a href="{{ route('login') }}" style="color: yellow">Login</a> page </p>
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
            // $("#temp").hide();
            $("#clientId").on('keypress', function (e) {
                // e.preventDefault();
                if (e.which == 13) {
                    let clientId = $("#clientId").val();
                    const formData = {'clientId': clientId};
                    console.log("test 1");
                    // toastr.success('/user/'.clientId);
                    console.log('/user/' + clientId);
                    $.ajax({
                        url: '/user/' + clientId,
                        type: 'GET',
                        data: formData,
                        datatype: 'json'
                    })
                        .done(function (data) {
                            if (data.success == 1) {
                                console.log("Success");
                                console.log(data.message['firstName']);
                                toastr.success('Have fun storming the castle!', 'Miracle Max Says');
                                $('.temp').css({'display': ''});
                                $('#firstName').html(data.message['firstName']);
                                $('#lastName').html(data.message['lastName']);
                                $('#nameOfOrganization').html(data.message['nameOfOrganization']);
                                $('#street').html(data.message['street']);
                                $('#city').html(data.message['city']);
                                $('#email').html(data.message['email']);
                                $('#phone').html(data.message['mobileNumber']);
                                $('#licenceKey1').html(data.decryptedLicenceKey);
                            } else {
                                toastr.error(data.message);
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            // danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                            console("fail to return response");
                        });
                }
            });
            $("#create-key").on("click", function (e) {
                let key = $("#licenceKey").val();
                let clientId = $("#clientId").val();
                let month = $("#licenceMonthSelection").val();
                if(clientId == ""){
                    toastr.error("Please Enter a client id");
                }
                else if (key !="") {
                    const formData = {'clientId': clientId,'licenceKey':key,'month':month,_token: '{{csrf_token()}}'};
                    {{--_token: '{{csrf_token()}}'--}}
                    $.ajax({
                        url: '/user/save-key',
                        type: 'POST',
                        data: formData,
                        datatype: 'json'
                    }).done(function (data) {
                            if (data.success == 1) {
                                toastr.success('Licence Key Create for '+data.message['firstName']);
                                $('.temp').css({'display': ''});
                                $('#firstName').html(data.message['firstName']);
                                $('#lastName').html(data.message['lastName']);
                                $('#nameOfOrganization').html(data.message['nameOfOrganization']);
                                $('#street').html(data.message['street']);
                                $('#city').html(data.message['city']);
                                $('#email').html(data.message['email']);
                                $('#phone').html(data.message['mobileNumber']);
                                $('#licenceKey1').html(data.decryptedLicenceKey);
                            } else {
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            toastr.error('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                        });
                }
                else {
                    toastr.error("Please enter a Licence key");
                }
            })
        })
    </script>
@endsection
