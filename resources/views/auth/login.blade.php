<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    {{-- 🔹 Login Box --}}
    <div class="fullscreen-container">
        <div class="login-box">
            <h2>Login</h2>

            <form action="{{ route('login.process') }}" method="POST">
    @csrf
    
    <div class="input-group">
        <input type="text" 
               name="login" 
               id="login"
               placeholder="Username / Email"
               required
               value="{{ old('login') }}"
               class="@error('login') is-invalid @enderror">
        @error('login')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="input-group">
        <input type="password" 
               name="password" 
               id="password"
               placeholder="Password"
               required>
    </div>

    <button class="btn-login" type="submit">
        <i class="fa fa-lock"></i> LOGIN
    </button>
</form>

            <p class="note">Gunakan akun yang telah terdaftar</p>
        </div>
    </div>
</body>

{{-- ✅ SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: '{{ session("success") }}',
    confirmButtonColor: '#1c6758'
  });
</script>
@endif

@if(session('loginError'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Login Gagal',
    text: '{{ session("loginError") }}',
    confirmButtonColor: '#d33'
  });
</script>
@endif

@if($errors->any())
<script>
  Swal.fire({
    icon: 'error',
    title: 'Terjadi Kesalahan!',
    html: `{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonColor: '#d33'
  });
</script>
@endif
</html>
