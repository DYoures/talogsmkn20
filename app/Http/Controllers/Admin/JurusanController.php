<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::withCount(['users', 'tugasAkhirs'])->latest()->get();
        return view('admin.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        $presetColors = Jurusan::PRESET_COLORS;
        return view('admin.jurusan.create', compact('presetColors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:jurusans,name',
            'kode'            => 'nullable|string|max:10',
            'accent_color'    => ['nullable', 'string', 'max:10', 'regex:/^#([a-fA-F0-9]{6})$/'],
            'description'     => 'nullable|string',
            'akreditasi'      => 'nullable|string|max:20',
            'kurikulum'       => 'nullable|string',
            'prospek_karir'   => 'nullable|string',
            'tools_industri'  => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['accent_color']   = $validated['accent_color'] ?? '#8B5CF6';
        $validated['kurikulum']      = $this->parseLines($request->input('kurikulum'));
        $validated['prospek_karir']  = $this->parseLines($request->input('prospek_karir'));
        $validated['tools_industri'] = $this->parseLines($request->input('tools_industri'));

        Jurusan::create($validated);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        $presetColors = Jurusan::PRESET_COLORS;
        return view('admin.jurusan.edit', compact('jurusan', 'presetColors'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:jurusans,name,' . $jurusan->id,
            'kode'            => 'nullable|string|max:10',
            'accent_color'    => ['nullable', 'string', 'max:10', 'regex:/^#([a-fA-F0-9]{6})$/'],
            'description'     => 'nullable|string',
            'akreditasi'      => 'nullable|string|max:20',
            'kurikulum'       => 'nullable|string',
            'prospek_karir'   => 'nullable|string',
            'tools_industri'  => 'nullable|string',
        ]);

        // Re-generate slug only if name changed
        if ($jurusan->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['accent_color']   = $validated['accent_color'] ?? $jurusan->accent_color ?? '#8B5CF6';
        $validated['kurikulum']      = $this->parseLines($request->input('kurikulum'));
        $validated['prospek_karir']  = $this->parseLines($request->input('prospek_karir'));
        $validated['tools_industri'] = $this->parseLines($request->input('tools_industri'));

        $jurusan->update($validated);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }

    /**
     * Parse a multi-line textarea into an array of non-empty lines.
     */
    private function parseLines(?string $text): array
    {
        if (empty($text)) {
            return [];
        }
        return array_values(array_filter(
            array_map('trim', explode("\n", str_replace("\r\n", "\n", $text))),
            fn($line) => $line !== ''
        ));
    }
}
