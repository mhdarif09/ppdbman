<?php

namespace App\Http\Controllers\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\PpdbPathway;
use App\Models\SystemSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class PpdbPathwayController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->middleware(['auth', 'role:admin_sekolah']);
        $this->activityLogger = $activityLogger;
    }

    /**
     * Display a listing of pathways.
     */
    public function index()
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        
        $pathways = PpdbPathway::byAcademicYear($academicYear)
            ->withCount('applicants')
            ->orderBy('id')
            ->paginate(10);

        return view('admin-sekolah.pathways.index', compact('pathways'));
    }

    /**
     * Show the form for creating a new pathway.
     */
    public function create()
    {
        return view('admin-sekolah.pathways.create');
    }

    /**
     * Store a newly created pathway.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quota' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        $validated['academic_year'] = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        $validated['filled'] = 0;
        $validated['is_active'] = $request->has('is_active');

        $pathway = PpdbPathway::create($validated);

        $this->activityLogger->logCreated($pathway);

        return redirect()
            ->route('admin-sekolah.pathways.index')
            ->with('success', 'Jalur PPDB berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the pathway.
     */
    public function edit(PpdbPathway $pathway)
    {
        return view('admin-sekolah.pathways.edit', compact('pathway'));
    }

    /**
     * Update the specified pathway.
     */
    public function update(Request $request, PpdbPathway $pathway)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quota' => ['required', 'integer', 'min:' . $pathway->filled],
            'is_active' => ['boolean'],
        ], [
            'quota.min' => 'Kuota tidak boleh kurang dari jumlah yang sudah terisi (' . $pathway->filled . ')',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $oldValues = $pathway->getOriginal();
        $pathway->update($validated);

        $this->activityLogger->logUpdated($pathway, $oldValues);

        return redirect()
            ->route('admin-sekolah.pathways.index')
            ->with('success', 'Jalur PPDB berhasil diupdate.');
    }

    /**
     * Remove the specified pathway.
     */
    public function destroy(PpdbPathway $pathway)
    {
        if ($pathway->filled > 0) {
            return back()->with('error', 'Jalur tidak bisa dihapus karena sudah ada pendaftar.');
        }

        $this->activityLogger->logDeleted($pathway);
        $pathway->delete();

        return redirect()
            ->route('admin-sekolah.pathways.index')
            ->with('success', 'Jalur PPDB berhasil dihapus.');
    }
}
