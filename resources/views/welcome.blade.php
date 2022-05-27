<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Styles -->
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Notification') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('notification.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="title" class="col-md-4 col-form-label text-md-end">
                                    {{ __('Message Title') }} <span class="text-danger">*</span>
                                </label>

                                <div class="col-md-6">
                                    <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="body" class="col-md-4 col-form-label text-md-end">
                                    {{ __('Message Body') }} <span class="text-danger">*</span>
                                </label>

                                <div class="col-md-6">
                                    <textarea 
                                        name="body" 
                                        id="body" 
                                        class="form-control @error('body') is-invalid @enderror" 
                                        cols="30" 
                                        rows="10"
                                        required></textarea>

                                    @error('body')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="data" class="col-md-4 col-form-label text-md-end">
                                    {{ __('Data (JSON)') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="data" type="data" class="form-control @error('data') is-invalid @enderror" name="data" value="{{ old('data') }}">

                                    @error('data')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">
                                    {{ __('Notification Types') }}
                                </label>

                                <div class="col-md-6">
                                    <select class="form-control" id="notification_type" name="notification_type">
                                        <option value="1">Individual User</option>
                                        <option value="2">Channel</option>
                                    </select>

                                    @error('notification_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="userDropdown">
                                 <div class="row mb-3">
                                    <label for="user_id" class="col-md-4 col-form-label text-md-end">
                                        {{ __('To (Individual user)') }} <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{$user->email }})</option>
                                            @endforeach
                                        </select>

                                        @error('user_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
                            </div>

                            <div id="channelDropdown">
                                <div class="row mb-3">
                                    <label for="channel" class="col-md-4 col-form-label text-md-end">
                                        {{ __('Channel') }} <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-md-6">
                                        <select class="form-control" id="channel" name="channel" required>
                                            <option value="All">All</option>
                                            <option value="Android">Android</option>
                                            <option value="IOS">IOS</option>
                                        </select>

                                        @error('channel')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script>
            $(function () {
                $("#channelDropdown").hide();

                $('#notification_type').change(function () {
                    if ($(this).val() == 1) {
                        $("#userDropdown").show();
                        $("#channelDropdown").hide();
                    } else {
                        $("#channelDropdown").show();
                        $("#userDropdown").hide();
                    }
                });

                
            });
        </script>
    </body>
</html>
