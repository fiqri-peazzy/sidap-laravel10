<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Atlit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilAtlit extends Component
{
    use WithFileUploads;

    public $atlit;
    
    // Fields yang boleh diupdate
    public $alamat;
    public $telepon;
    public $email;
    public $foto;
    public $fotoTemp; // untuk preview foto baru
    
    // Status editing untuk masing-masing field
    public $editingAlamat = false;
    public $editingTelepon = false;
    public $editingEmail = false;
    public $editingFoto = false;
    
    public $showEmailWarning = false;

    protected function rules()
    {
        return [
            'alamat' => 'required|string|max:500',
            'telepon' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::id()),
                Rule::unique('atlit', 'email')->ignore($this->atlit->id),
            ],
            'fotoTemp' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // 2MB
        ];
    }

    protected $messages = [
        'alamat.required' => 'Alamat wajib diisi.',
        'alamat.max' => 'Alamat maksimal 500 karakter.',
        'telepon.required' => 'Nomor telepon wajib diisi.',
        'telepon.regex' => 'Format nomor telepon tidak valid.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'fotoTemp.image' => 'File harus berupa gambar.',
        'fotoTemp.mimes' => 'Foto harus berformat PNG, JPG, atau JPEG.',
        'fotoTemp.max' => 'Ukuran foto maksimal 2MB.',
    ];

    public function mount(Atlit $atlit)
    {
        $this->atlit = $atlit->load(['klub', 'cabangOlahraga', 'kategoriAtlit', 'user']);
        
        // Inisialisasi data yang boleh diupdate
        $this->alamat = $this->atlit->alamat;
        $this->telepon = $this->atlit->telepon;
        $this->email = $this->atlit->email;
    }

    public function toggleEdit($field)
    {
        $property = 'editing' . ucfirst($field);
        $this->$property = !$this->$property;
        
        // Reset data jika cancel edit
        if (!$this->$property) {
            if ($field === 'alamat') {
                $this->alamat = $this->atlit->alamat;
            } elseif ($field === 'telepon') {
                $this->telepon = $this->atlit->telepon;
            } elseif ($field === 'email') {
                $this->email = $this->atlit->email;
                $this->showEmailWarning = false;
            } elseif ($field === 'foto') {
                $this->fotoTemp = null;
            }
            $this->resetErrorBag();
        }
        
        // Show email warning saat mulai edit email
        if ($field === 'email' && $this->editingEmail) {
            $this->showEmailWarning = true;
        }
    }

    public function updateField($field)
    {
        $rules = [];
        $messages = [];

        // Set validation rules berdasarkan field
        if ($field === 'alamat') {
            $rules['alamat'] = $this->rules()['alamat'];
            $messages = array_filter($this->messages, function($key) {
                return str_starts_with($key, 'alamat.');
            }, ARRAY_FILTER_USE_KEY);
        } elseif ($field === 'telepon') {
            $rules['telepon'] = $this->rules()['telepon'];
            $messages = array_filter($this->messages, function($key) {
                return str_starts_with($key, 'telepon.');
            }, ARRAY_FILTER_USE_KEY);
        } elseif ($field === 'email') {
            $rules['email'] = $this->rules()['email'];
            $messages = array_filter($this->messages, function($key) {
                return str_starts_with($key, 'email.');
            }, ARRAY_FILTER_USE_KEY);
        }

        $this->validate($rules, $messages);

        try {
            // Update data atlit
            $this->atlit->update([
                $field => $this->$field
            ]);

            // Jika update email, sinkronkan dengan tabel users
            if ($field === 'email') {
                $user = User::find(Auth::id());
                $user->update([
                    'email' => $this->email
                ]);
                $this->showEmailWarning = false;
            }

            // Refresh data atlit
            $this->atlit->refresh();

            // Turn off editing mode
            $property = 'editing' . ucfirst($field);
            $this->$property = false;

            session()->flash('success', 'Data berhasil diperbarui.');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateFoto()
    {
        $this->validate([
            'fotoTemp' => $this->rules()['fotoTemp']
        ], array_filter($this->messages, function($key) {
            return str_starts_with($key, 'fotoTemp.');
        }, ARRAY_FILTER_USE_KEY));

        try {
            // Hapus foto lama jika ada
            if ($this->atlit->foto && Storage::disk('public')->exists('atlit/foto/' . $this->atlit->foto)) {
                Storage::disk('public')->delete('atlit/foto/' . $this->atlit->foto);
            }

            // Simpan foto baru
            $fotoName = time() . '_' . $this->atlit->id . '.' . $this->fotoTemp->getClientOriginalExtension();
            $this->fotoTemp->storeAs('atlit/foto/', $fotoName, 'public');

            // Update database
            $this->atlit->update([
                'foto' => $fotoName
            ]);

            // Refresh data
            $this->atlit->refresh();

            // Reset form
            $this->fotoTemp = null;
            $this->editingFoto = false;

            session()->flash('success', 'Foto profil berhasil diperbarui.');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat mengupload foto: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.profil-atlit');
    }
}