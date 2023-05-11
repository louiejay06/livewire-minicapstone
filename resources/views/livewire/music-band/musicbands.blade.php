
<div style="">
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@if (session()->has('delete-info'))
    <div class="alert alert-danger">
        {{ session('delete-info') }}
    </div>
@endif
@if (session()->has('edit-info'))
    <div class="alert alert-warning">
        {{ session('edit-info') }}
    </div>
@endif
<div class="">


 <div class="w-25">

       <div class="card-body shadow-lg p-5 rounded m-2" style="background-color: rgb(200, 244, 255)">
        <h1>Filters</h1>
                    <input type="text" name="" id="" placeholder="Search Band Name" class="form-control" wire:model='bandSearch'>

                    <div class="checkbox d-block">

                    <label for="genre">Genre:</label> <br>
                        <input type="checkbox" name="" id="" wire:model='genRock' value="Rock"> &nbsp; Rock <br>
                        <input type="checkbox" name="" id="" wire:model='genPop' value="Pop"> &nbsp; Pop <br>
                        <input type="checkbox" name="" id="" wire:model='genReggae' value="Reggae"> &nbsp; Reggae <br>
                        <input type="checkbox" name="" id="" wire:model='genAcoustic' value="Acoustic"> &nbsp; Acoustic <br>
                        <input type="checkbox" name="" id="" wire:model='genClassical' value="Classical" class="mb-4"> &nbsp; Classical <br>
                    </div>


                    <div>
                        <select wire:model="bandLocation" class="form-select">
                            <option value="all">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                   <div class="" style="">
                        <label for="">Rate:</label><br>
                        <input style="width: 350px;" type="range" id="sortRangeInput" name="sortRangeInput" min="0" max="100"
                        oninput="showSortValue(this.value)" wire:model='sortRate'> <br>

                        ₱ <output class="" id="sortRangeInput" for="sortRangeInput">{{ number_format(floatval($sortRate), 2) }}</output>
                   </div>
                   <br>
                        <select name="" id="" class="form-select" style="" wire:model='sortBy'>
                            <option value=''>Sort By</option>
                            <option value="Lowest to Highest Fee">Lowest to Highest Fee</option>
                            <option value="Highest to Lowest Fee">Highest to Lowest Fee</option>
                        </select>


                        <button class="btn btn-primary mt-3" wire:click='resetFilter'>Reset</button>

                </div>
            </div>


            <button class="btn btn-primary float-start m-2" style="" data-bs-toggle="modal" data-bs-target="#addNew">
               Create New
              </button>
              <div class="mt-3" style="margin-left: 1755px">

                {{$musicbands->links()}}
            </div>
            <div class="m-2 d-flex shadow" style="background-color: rgb(105, 170, 193)">


                @if ($musicbands->count() > 0)
                  @foreach ($musicbands as $musicbar)
                    <div class="card m-lg-5 d-flex flex-column justify-content-between" style="width: 300px;">
                      <img class="card-img-top rounded" data-bs-toggle="modal" data-bs-target="#view" wire:click='viewBar({{$musicbar->id}})'
                        src="{{asset('uploads/image_uploads')}}/{{$musicbar->image}}" alt="" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <h5 class="card-title">{{ $musicbar->name }}</h5>
                        <p class="card-text">Location: {{ $musicbar->location }}</p>
                        <p class="card-text">Rate: {{ number_format($musicbar->rate, 2) }}</p>
                        <p class="card-text">Genre: {{ $musicbar->genre }}</p>
                      </div>
                      <div class="card-footer">
                        <button class="alert alert-success" data-bs-toggle="modal" data-bs-target="#edit" wire:click='editBar({{$musicbar->id}})'>Edit</button>
                        <button class="alert alert-danger" data-bs-toggle="modal" data-bs-target="#delete" wire:click='deleteConfirm({{$musicbar->id}})'>Delete</button>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>

        </div>






  <div wire:ignore.self class="modal text-black fade" id="addNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title fs-10" id="staticBackdropLabel">Create</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color: rgb(177, 220, 227)">


            <form wire:submit.prevent='addBar'>
                <div class="elements mb-3">
                    <input type="file" name="" id="" class="form-control" wire:model='image'>
                    @if ($image && $image instanceof \Illuminate\Http\UploadedFile)
                        <img src="{{$image->temporaryUrl()}}" width="200" alt="" class="mt-3 rounded-circle" style="margin-left: 125px">
                    @endif
                    @error('image')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="name">Name:</label><br>
                    <input type="text" name="" id="name" class="form-control" wire:model='name' placeholder="Name">
                    @error('name')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="loc">Location:</label><br>
                    <input type="text" name="" id="loc" class="form-control" wire:model='location' placeholder="Location">
                    @error('location')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="rate d-inline-block mt-2">
                    <label for="">Rate:</label><br>
                    <input type="number" wire:model='rate' class="form-control">

                    @error('rate')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
               </div>

                <div class="elements">
                    <label for="gen">Genre:</label><br>


                    <select name="" id="" wire:model='genre' class="form-select">
                        <option value="">Select Genre</option>
                        <option value="Rock">Rock</option>
                        <option value="Pop">Pop</option>
                        <option value="Reggae">Reggae</option>
                        <option value="Acoustic">Acoustic</option>
                        <option value="Classical">Classical</option>
                    </select>


                    @error('genre')
                        <span class="text-danger text-lg">{{ $message }}</span>
                    @enderror


                </div>

        </div>
        <div class="modal-footer" style="background-color: rgb(213, 249, 255)">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"> Add</button>
          </div>
    </form>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade text-black" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title fs-10" id="staticBackdropLabel">Edit Bar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color: rgb(177, 220, 227)">
            <form wire:submit.prevent='updateBarData'>
                <div class="elements mb-3">


                    @foreach ($musicbands as $musicbar)
                        @if ($musicbar->id === $selectedMusicBarId)
                            <img src="{{ asset('uploads/image_uploads/' . $musicbar->image) }}" width="250" class="rounded-circle" style="margin-left: 125px" alt="">
                        @endif
                    @endforeach

                    @error('image')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="name">Name:</label><br>
                    <input type="text" name="" id="name" class="form-control" wire:model='name'>
                    @error('name')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="loc">Location:</label><br>
                    <input type="text" name="" id="loc" class="form-control" wire:model='location'>
                    @error('location')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="rate d-inline-block mt-2" style="transform: translateX(6px);">
                    <label for="">Rate</label><br>
                    <input type="number" name="" id="" wire:model='rate' class="form-control">

                    @error('rate')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
               </div>

                <div class="elements">
                    <label for="gen">Genre:</label><br>

                    <select name="" id="" wire:model='genre' class="form-select">
                        <option value="">Select Genre</option>
                        <option value="Rock">Rock</option>
                        <option value="Pop">Pop</option>
                        <option value="Reggae">Reggae</option>
                        <option value="Acoustic">Acoustic</option>
                        <option value="Classical">Classical</option>


                    </select>
                    @error('genre')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>

        </div>
        <div class="modal-footer" style="background-color: rgb(213, 249, 255)">
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal"> <i class="fa fa-cancel"></i> Cancel</button>
            <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-disk"></i> Update</button>
          </div>
    </form>

      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade text-black" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title fs-10" id="staticBackdropLabel">Delete Bar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color: rgb(177, 220, 227)">
            <h1 class="text-black">Click Yes To Delete</h1>
        </div>
        <div class="modal-footer" style="background-color: rgb(213, 249, 255)">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i class="fa fa-close"></i> No</button>
          <button type="button" class="btn btn-danger" wire:click='deleteBardata' data-bs-dismiss="modal"> <i class="fa fa-trash"></i> Yes</button>
        </div>
      </div>
    </div>
  </div>


  <div wire:ignore.self class="modal fade text-black" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body p-5" style="background-color: rgb(177, 220, 227)">
            <button type="button" class="alert alert-secondary float-end" data-bs-dismiss="modal">X</button> <br> <br> <br> <br> <br> <br>
            <div class="imageView text-center">
                @if ($musicbands->count() > 0)
                    @foreach ($musicbands as $musicbar)

                    @if ($musicbar->id === $selectedMusicBarId)
                        <img src="{{ asset('uploads/image_uploads/' . $musicbar->image) }}" width="250" class="rounded-circle mb-5" alt=""> <br>
                         <h1>Rate: {{$musicbar->rate}}</h1>
                    @endif
                    @endforeach
                @endif
            <h4><i style="">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo adipisci amet perferendis eos? Molestias adipisci maxime saepe enim officia sapiente molestiae dolore, necessitatibus aperiam excepturi veritatis doloribus, fugiat voluptate inventore.</i></h4>
                <button class="btn btn-success"> <i class="fa fa-book"></i> Book Now</button>
            </div>


            <br> <br> <br>






        </div>

      </div>
    </div>
  </div>
  <style>


    </style>

    <script>


function showSortValue(val) {
    var sortdecimalPlaces = 2;

    var sortformattedVal = parseFloat(val).toFixed(sortdecimalPlaces);

    document.getElementById("newSortAmount").innerHTML = sortformattedVal;

    }


    function showValue(val) {
    var decimalPlaces = 2;

    var formattedVal = parseFloat(val).toFixed(decimalPlaces);

    document.getElementById("newAmount").innerHTML = formattedVal;

    }

    function editShowValue(val){
        var editDecimalPlaces = 2;

        var editFormattedVal = parseFloat(val).toFixed(editDecimalPlaces);

        document.getElementById("newEditAmount").innerHTML = editFormattedVal;
    }

    window.addEventListener('barSaved', function() {
    // close the modal
    var addNewModal = document.getElementById('edit');
    if (addNewModal) {
        var modal = bootstrap.Modal.getInstance(addNewModal);
        modal.hide();
    }
});

window.addEventListener('barDeleted', function() {
    // close the modal
    var deleteModal = document.getElementById('delete');
    if (deleteModal) {
        var modal = bootstrap.Modal.getInstance(deleteModal);
        modal.hide();
    }
});

window.addEventListener('barCreated', function() {
    // close the modal
    var deleteModal = document.getElementById('addNew');
    if (deleteModal) {
        var modal = bootstrap.Modal.getInstance(deleteModal);
        modal.hide();
    }
});
    </script>
</div>

