<nav class="">
    <header class="d-flex shadow-lg p-5" style="background-color: rgb(173, 228, 255)">


        <h1 class="float-start" style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif"> <i class="fa fa-music"></i> Music Bar</h1>

        @if(auth()->check())
        <div class="" style="margin-left: 1500px">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item"><h1 class="btn btn-danger">Logout</h1></button>
            </form>
        </div>

        @endif




    </header>

</nav>

<style>

    .page{
        cursor: pointer;
        transition: 0.5s;
        padding: 10px;
    }
    .page:hover{
        background-color: white;
        box-shadow: 0px 10px 0px 0px rgb(118, 118, 118);
        color: black;
        transform: translateY(-10px);
    }
</style>
