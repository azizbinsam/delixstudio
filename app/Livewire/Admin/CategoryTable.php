<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 10;
    public array $selected = [];
    public bool $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDir' => ['except' => 'desc'],
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
        $this->reset(['search', 'type']);
        $this->selected = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function bulkDelete(): void
    {
        Category::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kategori berhasil dihapus!');
    }

    private function getQuery()
    {
        return Category::withCount(['courses', 'products'])
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->type, fn($q) => $q->where('type', $this->type))
            ->orderBy($this->sortBy, $this->sortDir);
    }

    public function render()
    {
        $categories = $this->getQuery()->paginate($this->perPage);

        return view('livewire.admin.category-table', compact('categories'));
    }
}
