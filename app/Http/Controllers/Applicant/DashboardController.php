<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show applicant dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)
            ->with(['verifier', 'pathway'])
            ->first();

        // Calculate profile completion
        $requiredFields = [
            'nisn', 'full_name', 'birth_place', 'birth_date', 'gender',
            'address', 'phone', 'parent_name', 'parent_phone', 'photo'
        ];
        
        $filledFields = 0;
        foreach ($requiredFields as $field) {
            if (!empty($applicant->$field)) {
                $filledFields++;
            }
        }
        
        $completionPercentage = count($requiredFields) > 0 
            ? round(($filledFields / count($requiredFields)) * 100) 
            : 0;

        $pathways = [];
        if ($completionPercentage == 100) {
            $academicYear = \App\Models\SystemSetting::get('academic_year_active', date('Y') . '/' . (date('Y') + 1));
            $pathways = \App\Models\PpdbPathway::byAcademicYear($academicYear)
                ->active()
                ->get();
        }

        return view('applicant.dashboard', compact('applicant', 'completionPercentage', 'pathways'));
    }

    /**
     * Update applicant profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'phone' => 'required|string',
            'parent_name' => 'required|string',
            'parent_phone' => 'required|string',
            'photo' => 'required|image|max:2048', // Max 2MB
        ]);

        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();

        $data = $request->only([
            'birth_place', 'birth_date', 'gender', 'address', 'phone', 'parent_name', 'parent_phone'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        $applicant->update($data);

        return redirect()->route('applicant.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
    
    /**
     * Select PPDB pathway.
     */
    public function selectPathway(Request $request)
    {
        $request->validate([
            'ppdb_pathway_id' => 'required|exists:ppdb_pathways,id'
        ]);
        
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        // Check if already selected a pathway
        if ($applicant->ppdb_pathway_id) {
            return redirect()->route('applicant.dashboard')
                ->with('info', 'Anda sudah memilih jalur pendaftaran.');
        }
        
        $pathway = \App\Models\PpdbPathway::findOrFail($request->ppdb_pathway_id);
        
        $applicant->update([
            'ppdb_pathway_id' => $request->ppdb_pathway_id,
            'registration_number' => \App\Models\Applicant::generateRegistrationNumber($pathway->name)
        ]);
        
        // Redirect to registration step 1
        return redirect()->route('applicant.registration.step', 1)
            ->with('success', 'Jalur pendaftaran berhasil dipilih. Silakan lengkapi pendaftaran Anda.');
    }
}
