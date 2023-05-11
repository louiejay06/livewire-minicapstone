<?php

namespace App\Http\Livewire\MusicBand;

use Livewire\Component;
use App\Models\Musicband;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Musicbands extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    use WithFileUploads;

    public $image, $selectedMusicBarId, $name, $location, $rate, $musicbar_edit_id, $musicbar_delete_id;
    public $genre = '';

    public function addBar()
    {

        $this->validate([
            'image' => 'required',
            'name' => 'required',
            'location' => 'required',
            'rate' => 'required',
            'genre' => 'required',

        ]);

        $musicbar = new Musicband();

        $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
        $this->image->storeAs('image_uploads', $imageName);
        $this->checkedFruits = $this->genre;

        $musicbar->image = $imageName;
        $musicbar->name = $this->name;
        $musicbar->location = $this->location;
        $musicbar->rate = $this->rate;
        $musicbar->genre = $this->genre;

        $this->genre = '';
        $musicbar->save();
        $this->dispatchBrowserEvent('barCreated');

        $this->image = '';
        $this->name = '';
        $this->location = '';
        $this->rate = '';
        $this->genre = '';

        session()->flash('add-info', 'New music bar has been added Successfully');
        return redirect('/');

        $this->musicbar = $musicbar;

    }
    public function viewBar($id)
    {
        $this->selectedMusicBarId = $id;

        $musicbar = Musicband::find($id);
        $this->musicbar = $musicbar;

        $image_url = asset('uploads/image_uploads/' . $musicbar->image);
        $script = "$('#modal-image').attr('src', '{$image_url}');";
        $this->dispatchBrowserEvent('update-image', ['script' => $script]);
    }


    public function editBar($id)
    {

        $this->selectedMusicBarId = $id;

        $musicbar = Musicband::where('id', $id)->first();
        $this->musicbar = $musicbar;

        $this->musicbar_edit_id = $musicbar->id;

        $this->name = $musicbar->name;
        $this->location = $musicbar->location;
        $this->rate = $musicbar->rate;
        $this->genre = $musicbar->genre;

    }

    public function updateBarData()
    {
        $this->validate([

            'name' => 'required',
            'location' => 'required',
            'rate' => 'required',
            'genre' => 'required',

        ]);

        $musicbar = Musicband::where('id', $this->musicbar_edit_id)->first();

        if ($this->image) {
            $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
            $this->image->storeAs('image_uploads', $imageName);

            $musicbar->image = $imageName;
        }


        $musicbar->name = $this->name;
        $musicbar->location = $this->location;
        $musicbar->rate = $this->rate;
        $musicbar->genre = $this->genre;

        $musicbar->save();

        $this->dispatchBrowserEvent('barSaved');



        session()->flash('edit-info', 'New Music Bar has been updated Successfully');
        return redirect('/');
    }

    public function deleteConfirm($id)
    {
        $this->musicbar_delete_id = $id;
    }

    public function deleteBardata()
    {
        $musicbar = Musicband::where('id', $this->musicbar_delete_id)->first();
        $musicbar->delete();

        session()->flash('delete-info', 'music bar has been deleted Successfully');
        return redirect('/');

        $this->dispatchBrowserEvent('barDelete');

    }
    public $bandLocation = 'all';
    public $locations;
    public function mount()
    {
        $this->locations = Musicband::pluck('location')->unique()->toArray();
    }

    public function index()
    {

        $query = Musicband::orderby('id')->search($this->bandSearch);
        return view('components.musicband');

    }

    public $bandSearch;
    public $genRock, $genPop, $genReggae, $genAcoustic, $genClassical;

    public $sortBy = 'sortby';
    public $sortRate = 0;

    public function render()
    {
        $query = Musicband::search($this->bandSearch);

        if ($this->sortRate <= 100) {
            $query = $query->where('rate', '>=', $this->sortRate);
        }


        if ($this->bandLocation != 'all') {
            $query->where('location', $this->bandLocation);
        }

        if ($this->sortBy == 'Lowest to Highest Fee') {
            $query = $query->orderBy('rate', 'asc');

        }
        elseif ($this->sortBy == 'Highest to Lowest Fee') {
            $query = $query->orderBy('rate', 'desc');
        }

        $selectedGenres = [];
        if ($this->genRock == 'Rock' || $this->genPop == 'Pop' || $this->genReggae == 'Reggae' || $this->genAcoustic == 'Acoustic' || $this->genClassical == 'Classical') {
            $query->where(function ($q) use ($selectedGenres) {
                if ($this->genRock == 'Rock') {
                    $selectedGenres[] = 'Rock';
                    $q->orWhere('genre', 'Rock');
                }
                if ($this->genPop == 'Pop') {
                    $selectedGenres[] = 'Pop';
                    $q->orWhere('genre', 'Pop');
                }
                if ($this->genReggae == 'Reggae') {
                    $selectedGenres[] = 'Reggae';
                    $q->orWhere('genre', 'Reggae');
                }
                if ($this->genAcoustic == 'Acoustic') {
                    $selectedGenres[] = 'Acoustic';
                    $q->orWhere('genre', 'Acoustic');
                }
                if ($this->genClassical == 'Classical') {
                    $selectedGenres[] = 'Classical';
                    $q->orWhere('genre', 'Classical');
                }
            });
        }

        $musicbar = $query->paginate(5);

        return view('livewire.music-band.musicbands', ['musicbands'=>$musicbar]);
    }
    public function resetFilter(){

        $this->bandSearch = '';

        $this->genRock = null;
        $this->genPop = null;
        $this->genReggae = null;
        $this->genAcoustic = null;
        $this->genClassical = null;

        $this->bandLocation = 'all';

        $this->sortRate = 0;
        $this->sortBy = 'Sort By';
    }
}
