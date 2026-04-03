<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\Member;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $email, $phone, $address;
    public $selected_id;
    public $isEditMode = false;

    public function render()
    {
        $members = Member::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.members.index', [
            'members' => $members,
        ])->layout('components.layouts.app', ['title' => 'Manage Members']);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->selected_id = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:mongodb.members,email',
        ]);

        Member::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'join_date' => now()->toDateString(),
        ]);

        $this->resetFields();
        session()->flash('message', 'Member Registered Successfully.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $member->name;
        $this->email = $member->email;
        $this->phone = $member->phone;
        $this->address = $member->address;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('mongodb.members', 'email')->ignore($this->selected_id, '_id'),
            ],
        ]);

        if ($this->selected_id) {
            $member = Member::find($this->selected_id);
            $member->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);
            $this->resetFields();
            session()->flash('message', 'Member Updated Successfully.');
        }
    }

    public function delete($id)
    {
        Member::find($id)->delete();
        session()->flash('message', 'Member Deleted Successfully.');
    }
}
