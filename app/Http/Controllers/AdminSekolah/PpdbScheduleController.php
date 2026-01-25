<?php

namespace App\Http\Controllers\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\PpdbSchedule;
use App\Models\SystemSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class PpdbScheduleController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->middleware(['auth', 'role:admin_sekolah']);
        $this->activityLogger = $activityLogger;
    }

    /**
     * Display a listing of schedules.
     */
    public function index()
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        $schedules = PpdbSchedule::byAcademicYear($academicYear)->orderBy('start_date')->get();

        return view('admin-sekolah.schedules.index', compact('schedules'));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['academic_year'] = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));

        $schedule = PpdbSchedule::create($validated);

        $this->activityLogger->logCreated($schedule);

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Update the specified schedule.
     */
    public function update(Request $request, PpdbSchedule $schedule)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
        ]);

        $oldValues = $schedule->getOriginal();
        $schedule->update($validated);

        $this->activityLogger->logUpdated($schedule, $oldValues);

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy(PpdbSchedule $schedule)
    {
        $this->activityLogger->logDeleted($schedule);
        $schedule->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
