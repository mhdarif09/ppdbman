<?php

namespace App\Http\Controllers\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\SystemSetting;
use App\Imports\AnnouncementResultsImport;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AnnouncementController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->middleware(['auth', 'role:admin_sekolah']);
        $this->activityLogger = $activityLogger;
    }

    /**
     * Display a listing of announcements.
     */
    public function index()
    {
        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
        $announcements = Announcement::byAcademicYear($academicYear)->latest()->paginate(10);

        return view('admin-sekolah.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        return view('admin-sekolah.announcements.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'publish_now' => 'boolean',
            'results_file' => 'nullable|file|mimes:xlsx,xls,csv',
        ]);

        $academicYear = SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'academic_year' => $academicYear,
            'published_at' => $request->publish_now ? now() : null,
            'published_by' => auth()->id(),
        ]);

        // Import Results if file provided
        if ($request->hasFile('results_file')) {
            Excel::import(new AnnouncementResultsImport($announcement->id), $request->file('results_file'));
        }

        $this->activityLogger->logCreated($announcement);

        return redirect()->route('admin-sekolah.announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy(Announcement $announcement)
    {
        $this->activityLogger->logDeleted($announcement);
        $announcement->delete();

        return redirect()->route('admin-sekolah.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
