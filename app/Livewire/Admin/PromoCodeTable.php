<?php

namespace App\Livewire\Admin;

use App\Models\PromoCode;
use Livewire\Component;
use Livewire\WithPagination;

class PromoCodeTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';
    public string $is_active = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 10;
    public array $selected = [];
    public bool $selectAll = false;
    public bool $showTrashed = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'is_active' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDir' => ['except' => 'desc'],
        'showTrashed' => ['except' => false],
        'perPage' => ['except' => 10],
    ];

    public function updatedSelectAll(bool $value): void
    {
        $this->selected = $value
            ? $this->getQuery()->paginate($this->perPage)->pluck('id')->map(fn($id) => (string) $id)->toArray()
            : [];
    }

    public function clearSelection(): void
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }
    public function updatingType(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }
    public function updatingIsActive(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function updatingShowTrashed(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'type', 'is_active', 'showTrashed']);
        $this->selected = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function bulkDelete(): void
    {
        PromoCode::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kode Promo berhasil dihapus!');
    }

    public function bulkRestore(): void
    {
        PromoCode::withTrashed()->whereIn('id', $this->selected)->restore();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kode Promo berhasil direstore!');
    }

    public function restore(int $id): void
    {
        PromoCode::withTrashed()->findOrFail($id)->restore();
        session()->flash('success', 'Kode Promo berhasil direstore!');
    }

    public function forceDelete(int $id): void
    {
        PromoCode::withTrashed()->findOrFail($id)->forceDelete();
        session()->flash('success', 'Kode Promo berhasil dihapus permanen!');
    }

    public function bulkForceDelete(): void
    {
        PromoCode::withTrashed()->whereIn('id', $this->selected)->forceDelete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kode Promo berhasil dihapus permanen!');
    }

    private function getQuery()
    {
        return PromoCode::when($this->showTrashed, fn($q) => $q->onlyTrashed())
            ->with('items')
            ->when($this->search, fn($q) => $q->where('code', 'like', '%' . $this->search . '%'))
            ->when($this->type, fn($q) => $q->where('type', $this->type))
            ->when($this->is_active !== '', fn($q) => $q->where('is_active', $this->is_active))
            ->orderBy($this->sortBy, $this->sortDir);
    }


    public function render()
    {
        $promoCodes = $this->getQuery()->paginate($this->perPage);

        return view('livewire.admin.promo-code-table', compact('promoCodes'));
    }
}
