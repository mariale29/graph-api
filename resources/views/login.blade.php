
@extends('layouts.app')
@section('content')
    <div class="signup-form">
        <br>
        <form method="POST" action="user">
            @csrf
            @if(session()->has('error'))
                <div class="text-danger text-center">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="form-group">
                <label for="email" class="form-label"> Usuario </label>
                <input type="text" name="email" class="form-control" required>           
            </div>
            <div class="form-group">
                <label for="password" class="form-label"> Contraseña </label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-secondary btn-lg btn-block " name="login_user"> Iniciar Sesión </button>
            </div>
        </form>            
    </div>
@endsection

