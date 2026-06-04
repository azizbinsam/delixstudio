<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 10;
    public array $selected = [];
    public bool $selectAll = false;
    public bool $showTrashed = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDir' => ['except' => 'desc'],
        'showTrashed' => ['except' => false],
        'perPage' => ['except' => 10],
    ];

    public function updatedSelectAll(bool $value): void
    {
        $this->selected = $value
            ? $this->getQuery()
            ->where('is_admin', false)
            ->paginate($this->perPage)
            ->pluck('id')
            ->map(fn($id) => (string) $id)
            ->toArray()
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
        $this->reset(['search']);
        $this->resetPage();
    }

    public function bulkDelete(): void
    {
        User::whereIn('id', $this->selected)
            ->where('is_admin', false)
            ->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'User berhasil dihapus!');
    }

    public function bulkRestore(): void
    {
        User::withTrashed()->whereIn('id', $this->selected)->restore();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'User berhasil direstore!');
    }

    public function restore(int $id): void
    {
        User::withTrashed()->findOrFail($id)->restore();
        session()->flash('success', 'Kode Promo berhasil direstore!');
    }

    public function forceDelete(int $id): void
    {
        User::withTrashed()->findOrFail($id)->forceDelete();
        session()->flash('success', 'Kode Promo berhasil dihapus permanen!');
    }

    public function bulkForceDelete(): void
    {
        User::withTrashed()->whereIn('id', $this->selected)->forceDelete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('success', 'Kode Promo berhasil dihapus permanen!');
    }

    public function promote(int $id): void
    {
        // Hanya super admin yang bisa promote
        if (Auth::user()->email !== env('ADMIN_EMAIL', 'admin@delixstudio.com')) {
            session()->flash('error', 'Hanya super admin yang bisa promote user.');
            return;
        }

        $user = User::findOrFail($id);
        $user->is_admin = true;
        $user->save();
        session()->flash('success', "{$user->name} sekarang adalah admin.");
    }

    public function demote(int $id): void
    {
        // Hanya super admin yang bisa demote
        if (Auth::user()->email !== env('ADMIN_EMAIL', 'admin@delixstudio.com')) {
            session()->flash('error', 'Hanya super admin yang bisa demote user.');
            return;
        }

        $adminCount = User::where('is_admin', true)->count();
        if ($adminCount <= 1) {
            session()->flash('error', 'Harus ada minimal 1 admin aktif.');
            return;
        }

        $user = User::findOrFail($id);
        $user->is_admin = false;
        $user->save();
        session()->flash('success', "{$user->name} bukan admin lagi.");
    }

    private function getQuery()
    {
        return User::withCount(['orders', 'orders as paid_orders_count' => fn($q) => $q->where('status', 'paid')])
            ->when($this->showTrashed, fn($q) => $q->onlyTrashed())
            ->withSum(['orders as total_spending' => fn($q) => $q->where('status', 'paid')], 'total')
            ->when(
                $this->search,
                fn($q) => $q
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
            )
            ->orderBy($this->sortBy, $this->sortDir);
    }
    public function render()
    {
        $users = $this->getQuery()
            ->paginate($this->perPage);

        return view('livewire.admin.user-table', compact('users'));
    }
}
