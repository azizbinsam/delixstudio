<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class CourseTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $level = '';
    public string $category_id = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 10;
    public array $selected = [];
    public bool $selectAll = false;
    public bool $showTrashed = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'level' => ['except' => ''],
        'category_id' => ['except' => ''],
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
    public function updatingStatus(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }
    public function updatingLevel(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }
    public function updatingCategoryId(): void
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
        $this->reset(['search', 'status', 'level', 'category_id', 'showTrashed']);
        $this->selected = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function bulkDelete(): void
    {
        Course::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kelas berhasil dihapus!');
    }

    public function bulkRestore(): void
    {
        Course::withTrashed()->whereIn('id', $this->selected)->restore();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kelas berhasil direstore!');
    }

    public function restore(int $id): void
    {
        Course::withTrashed()->findOrFail($id)->restore();
        session()->flash('success', 'Kelas berhasil direstore!');
    }

    public function forceDelete(int $id): void
    {
        Course::withTrashed()->findOrFail($id)->forceDelete();
        session()->flash('success', 'Kelas berhasil dihapus permanen!');
    }

    public function bulkForceDelete(): void
    {
        Course::withTrashed()->whereIn('id', $this->selected)->forceDelete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kelas berhasil dihapus permanen!');
    }

    private function getQuery()
    {
        return Course::with('category')
            ->when($this->showTrashed, fn($q) => $q->onlyTrashed())
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->level, fn($q) => $q->where('level', $this->level))
            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
            ->orderBy($this->sortBy, $this->sortDir);
    }

    public function render()
    {
        $courses = $this->getQuery()->paginate($this->perPage);
        $categories = Category::where('type', 'course')->get();

        return view('livewire.admin.course-table', compact('courses', 'categories'));
    }
}
