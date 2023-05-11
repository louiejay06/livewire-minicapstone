<div>
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-header">
                <h1>Create Account</h1>
            </div>
            <div class="card-body">
                <form wire:submit.prevent='register'>
                    <div class="form-group mb-2">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" wire:model='name'>
                        @error('name')
                        <span class="text-danger text-lg">{{$message}}</span>
                        @enderror
                    </div>


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

                    <div class="form-group mb-3">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" id="confirmPassword" class="form-control" wire:model='password_confirmation'>
                    </div>



            </div>
            <div class="card-footer">
                <a href="/login" class="btn btn-success">Sign Up</a>
                <button type="submit" class="btn btn-primary float-end">Create</button>
            </div>
        </form>
        </div>
    </div>
</div>
