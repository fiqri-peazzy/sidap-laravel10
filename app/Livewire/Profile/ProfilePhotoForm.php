<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfilePhotoForm extends Component
{
    use WithFileUploads;

    public $photo;

    protected $rules = [
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ];

    protected $messages = [
        'photo.image' => 'File yang dipilih harus berupa gambar.',
        'photo.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF.',
        'photo.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    }

    public function updateProfilePhoto()
    {
        $this->validate();

        if ($this->photo) {
            try {
                Auth::user()->updateProfilePhoto($this->photo);

                $this->dispatch('profile-photo-updated', [
                    'message' => 'Foto profil berhasil diperbarui!'
                ]);
                $this->photo = null;

                $this->dispatch('$refresh');
            } catch (\Exception $e) {
                // Handle error
                session()->flash('error', 'Gagal memperbarui foto profil. Silakan coba lagi.');
            }
        }
    }

    public function deleteProfilePhoto()
    {
        try {
            // Delete profile photo using Jetstream's method
            Auth::user()->deleteProfilePhoto();

            // Dispatch event for success notification
            $this->dispatch('profile-photo-updated', [
                'message' => 'Foto profil berhasil dihapus!'
            ]);

            // Refresh the component
            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            // Handle error
            session()->flash('error', 'Gagal menghapus foto profil. Silakan coba lagi.');
        }
    }

    public function cancelUpload()
    {
        $this->photo = null;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.profile.profile-photo-form');
    }
}
