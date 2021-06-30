<?php

namespace App\Http\Livewire;

use App\Models\Office;
use App\Traits\WithSortTable;
use Livewire\Component;
use Livewire\WithPagination;

class OfficesTable extends Component
{
    use WithPagination;
    use WithSortTable;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.offices-table', [
            'offices' => Office::search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate(),
        ]);
    }
}
