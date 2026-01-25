<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{
    protected $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->middleware(['auth', 'role:super_admin']);
        $this->activityLogger = $activityLogger;
    }

    /**
     * Show the system configuration form.
     */
    public function index()
    {
        $settings = [
            'school_name' => SystemSetting::get('school_name', ''),
            'academic_year_active' => SystemSetting::get('academic_year_active', ''),
            'ppdb_status' => SystemSetting::get('ppdb_status', 'open'),
            'ppdb_start_date' => SystemSetting::get('ppdb_start_date', ''),
            'ppdb_end_date' => SystemSetting::get('ppdb_end_date', ''),
            'contact_email' => SystemSetting::get('contact_email', ''),
            'contact_phone' => SystemSetting::get('contact_phone', ''),
        ];

        return view('super-admin.config.index', compact('settings'));
    }

    /**
     * Update system configuration.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'academic_year_active' => ['required', 'string', 'max:20'],
            'ppdb_status' => ['required', 'in:open,closed'],
            'ppdb_start_date' => ['required', 'date'],
            'ppdb_end_date' => ['required', 'date', 'after_or_equal:ppdb_start_date'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:20'],
        ]);

        $oldSettings = [];
        $newSettings = [];

        foreach ($validated as $key => $value) {
            $oldSettings[$key] = SystemSetting::get($key);
            SystemSetting::set($key, $value, $this->getSettingType($key), $this->getSettingDescription($key));
            $newSettings[$key] = $value;
        }

        $this->activityLogger->log(
            'updated',
            null,
            $oldSettings,
            $newSettings
        );

        return back()->with('success', 'Konfigurasi sistem berhasil diperbarui.');
    }

    /**
     * Get setting type based on key.
     */
    protected function getSettingType(string $key): string
    {
        $types = [
            'ppdb_start_date' => 'date',
            'ppdb_end_date' => 'date',
        ];

        return $types[$key] ?? 'string';
    }

    /**
     * Get setting description.
     */
    protected function getSettingDescription(string $key): string
    {
        $descriptions = [
            'school_name' => 'Nama sekolah',
            'academic_year_active' => 'Tahun ajaran yang sedang aktif',
            'ppdb_status' => 'Status PPDB: open atau closed',
            'ppdb_start_date' => 'Tanggal mulai pendaftaran PPDB',
            'ppdb_end_date' => 'Tanggal akhir pendaftaran PPDB',
            'contact_email' => 'Email kontak untuk PPDB',
            'contact_phone' => 'Nomor telepon kontak untuk PPDB',
        ];

        return $descriptions[$key] ?? '';
    }
}
