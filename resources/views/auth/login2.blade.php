@extends('layouts.login-ltr')


@section('content')




                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group mb-3">
  

                <input id="email" type="text" placeholder="{{ __('E-Mail or Username') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" require autocomplete="off" autofocus>

                               
                            
                                <div class="input-group-append">
                                   <div class="input-group-text">
                                      <span class="fas fa-envelope"></span>
                                   </div>
                                </div>

                                 @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                       
                           

                        <div class="input-group mb-3">
                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                               
                                <div class="input-group-append">
                                   <div class="input-group-text">
                                     <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                 @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>





                        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
              {{ __('Remember Me') }}
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>





                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                                

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
        
@endsection
