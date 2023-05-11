<div>
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-header">
                <h1>Login Account</h1>
            </div>
            <div class="card-body">
                <form wire:submit.prevent='login'>




                    <div class="form-group mb-2">
                        <label for="email">Email:</label>
                        <input type="email" id="email" class="form-control" wire:model='email'>
                        @error('email')
                        <span class="text-danger text-lg">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="password">Password:</label>
                        <input type="password" id="password" class="form-control" wire:model='password'>
                        @error('password')
                        <span class="text-danger text-lg">{{$message}}</span>
                        @enderror
                    </div>





            </div>
            <div class="card-footer">
                <a href="/register" class="btn btn-success">Create Account</a>
                <button type="submit" class="btn btn-primary float-end">Login</button>
            </div>
        </form>
        </div>
    </div>
</div>
