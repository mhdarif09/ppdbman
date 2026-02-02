<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\ApplicantParent;
use App\Models\ApplicantHobby;
use App\Models\ApplicantDevelopment;
use App\Models\ApplicantGrade;
use App\Models\ApplicantCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationStepController extends Controller
{
    /**
     * Show registration step
     */
    public function show($step)
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        // Check if pathway selected
        if (!$applicant->ppdb_pathway_id) {
            return redirect()->route('applicant.dashboard')
                ->with('error', 'Silakan pilih jalur PPDB terlebih dahulu.');
        }
        
        // Check if registration already completed
        // Allow access if status is 'rejected' so they can fix data
        if ($applicant->registration_completed_at && $applicant->status !== 'rejected') {
            return redirect()->route('applicant.dashboard')
                ->with('info', 'Pendaftaran sudah selesai dan tidak dapat diubah.');
        }
        
        $step = (int) $step;
        if ($step < 1 || $step > 5) {
            return redirect()->route('applicant.registration.step', 1);
        }
        
        // Load step data
        $data = $this->getStepData($applicant, $step);
        
        return view('applicant.registration.step' . $step, [
            'applicant' => $applicant,
            'step' => $step,
            'data' => $data,
        ]);
    }
    
    /**
     * Save registration step
     */
    public function save(Request $request, $step)
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        if ($applicant->registration_completed_at && $applicant->status !== 'rejected') {
            return redirect()->route('applicant.dashboard');
        }
        
        $step = (int) $step;
        
        // Validate and save based on step
        switch ($step) {
            case 1:
                $this->saveStep1($request, $applicant);
                break;
            case 2:
                $this->saveStep2($request, $applicant);
                break;
            case 3:
                $this->saveStep3($request, $applicant);
                break;
            case 4:
                $this->saveStep4($request, $applicant);
                break;
            case 5:
                $this->saveStep5($request, $applicant);
                return $this->submit($request);
        }
        
        // Update registration step
        if ($step < 5) {
            $applicant->update(['registration_step' => $step + 1]);
            return redirect()->route('applicant.registration.step', $step + 1)
                ->with('success', 'Data berhasil disimpan!');
        }
        
        // If step 5, submit
        return redirect()->route('applicant.registration.step', 5)
            ->with('success', 'Data berhasil disimpan! Silakan submit pendaftaran.');
    }
    
    /**
     * Final submission
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        // Generate verification token if not exists
        if (!$applicant->verification_token) {
            $verificationToken = Applicant::generateVerificationToken();
            $applicant->verification_token = $verificationToken;
        }
        
        $updateData = [
            'registration_completed_at' => now(),
            'status' => 'pending',
            'rejection_reason' => null,
        ];

        if ($applicant->verification_token) {
            $updateData['verification_token'] = $applicant->verification_token;
        }

        $applicant->update($updateData);
        
        return redirect()->route('applicant.dashboard')
            ->with('success', 'Pendaftaran berhasil disubmit! Silakan unduh Kartu Bukti Pendaftaran Anda.');
    }
    
    // Step 1: Biodata
    private function saveStep1($request, $applicant)
    {
        $validated = $request->validate([
            // Personal
            'nik' => 'required|string|size:16',
            'nickname' => 'nullable|string|max:255',
            'nis' => 'nullable|string|max:20',
            'religion' => 'required|string',
            'nationality' => 'required|string',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'language' => 'nullable|string',
            
            // Family
            'child_order' => 'nullable|integer|min:1',
            'siblings_count' => 'nullable|integer|min:0',
            'half_siblings_count' => 'nullable|integer|min:0',
            'adopted_siblings_count' => 'nullable|integer|min:0',
            'child_status' => 'nullable|in:lengkap,yatim,piatu,yatim_piatu',

            // Contact
            'address' => 'required|string',
            'current_address' => 'required|string',
            'whatsapp_number' => 'nullable|string|max:20',
            
            // Health
            'blood_type' => 'nullable|in:A,B,AB,O',
            'diseases' => 'nullable|array',
            'allergies' => 'nullable|string',
            'physical_defects' => 'nullable|string',
            'height' => 'required|integer|min:50|max:250',
            'weight' => 'required|integer|min:10|max:200',
            
            // Psikis & Intellectual
            'psikis' => 'nullable|string',
            'intellectual' => 'nullable|string',
        ]);
        
        $validated['biodata_completed_at'] = now();
        
        $applicant->update($validated);
    }
    
    // Step 2: Education + Grades + Competitions (Merged)
    private function saveStep2($request, $applicant)
    {
        // Education
        $educationValidated = $request->validate([
            'previous_school_name' => 'required|string',
            'school_address' => 'nullable|string',
            'school_type' => 'nullable|in:negeri,swasta',
            'school_npsn' => 'nullable|string',
            'sttb_number' => 'nullable|string',
            'sttb_date' => 'nullable|date',
            'study_duration' => 'required|integer',
            'is_transfer' => 'required|boolean',
            'transfer_from_school' => 'nullable|string',
            'transfer_class' => 'nullable|string',
            'transfer_date' => 'nullable|date',
            'transfer_program' => 'nullable|string',
            'transfer_reason' => 'nullable|string',
            'transfer_from_grade' => 'nullable|string',
        ]);
        
        $applicant->education()->updateOrCreate(
            ['applicant_id' => $applicant->id],
            $educationValidated
        );
        
        // Grades
        $gradesValidated = $request->validate([
            'grades' => 'required|array',
        ]);
        
        // Delete existing grades and recreate
        $applicant->grades()->delete();
        
        foreach ($gradesValidated['grades'] as $subject => $semesters) {
            foreach ($semesters as $semester => $score) {
                if ($score !== null && $score !== '') {
                    $applicant->grades()->create([
                        'subject' => $subject,
                        'semester' => $semester,
                        'grade' => $score,
                    ]);
                }
            }
        }
        
        // Competitions
        $competitionsValidated = $request->validate([
            'competitions' => 'nullable|array',
            'competitions.*.competition_name' => 'required|string',
            'competitions.*.year' => 'required|integer|min:2010|max:' . (date('Y') + 1),
            'competitions.*.level' => 'required|in:kecamatan,kota,provinsi,nasional',
        ]);
        
        // Delete existing competitions and recreate
        $applicant->competitions()->delete();
        
        if (!empty($competitionsValidated['competitions'])) {
            foreach ($competitionsValidated['competitions'] as $comp) {
                if (!empty($comp['competition_name'])) {
                    $applicant->competitions()->create($comp);
                }
            }
        }
    }
    
    
    // Step 3: Parents (Data Orang Tua)
    private function saveStep3($request, $applicant)
    {
        $validated = $request->validate([
            'father_name' => 'required|string',
            'father_nik' => 'required|string|size:16',
            'father_birth_place' => 'nullable|string',
            'father_birth_date' => 'nullable|date',
            'father_religion' => 'required|string',
            'father_nationality' => 'required|string',
            'father_education' => 'required|string',
            'father_job' => 'required|string',
            'father_income' => 'required|numeric',
            'father_address' => 'nullable|string',
            'father_phone' => 'required|string',
            'father_status' => 'required|in:hidup,meninggal',
            'mother_name' => 'required|string',
            'mother_nik' => 'required|string|size:16',
            'mother_birth_place' => 'nullable|string',
            'mother_birth_date' => 'nullable|date',
            'mother_religion' => 'required|string',
            'mother_nationality' => 'required|string',
            'mother_education' => 'required|string',
            'mother_job' => 'required|string',
            'mother_income' => 'required|numeric',
            'mother_address' => 'nullable|string',
            'mother_phone' => 'required|string',
            'mother_status' => 'required|in:hidup,meninggal',
            'guardian_name' => 'nullable|string',
            'guardian_job' => 'nullable|string',
            'guardian_occupation' => 'nullable|string',
            'guardian_birth_place' => 'nullable|string',
            'guardian_birth_date' => 'nullable|date',
            'guardian_religion' => 'nullable|string',
            'guardian_nationality' => 'nullable|string',
            'guardian_income' => 'nullable|numeric',
            'guardian_phone' => 'nullable|string',
            'guardian_address' => 'nullable|string',
        ]);
        
        // Map job to occupation to satisfy DB strict mode
        $validated['father_occupation'] = $validated['father_job'];
        $validated['mother_occupation'] = $validated['mother_job'];
        if (isset($validated['guardian_job'])) {
            $validated['guardian_occupation'] = $validated['guardian_job'];
        }

        $applicant->parents()->updateOrCreate(
            ['applicant_id' => $applicant->id],
            $validated
        );
    }
    
    // Step 4: Hobbies (Minat & Bakat)
    private function saveStep4($request, $applicant)
    {
        $validated = $request->validate([
            'hobby_art' => 'nullable|string',
            'hobby_sports' => 'nullable|string',
            'hobby_social' => 'nullable|string',
            'hobby_other' => 'nullable|string',
        ]);
        
        $applicant->hobby()->updateOrCreate(
            ['applicant_id' => $applicant->id],
            $validated
        );
    }
    
    
    // Step 5: Documents Checklist & Final Submission
    private function saveStep5($request, $applicant)
    {
        $isPmpa = \Illuminate\Support\Str::contains(strtoupper($applicant->pathway->name ?? ''), 'PMPA');

        $rules = [
            'checklist_kk' => 'required|accepted',
            'checklist_akte' => 'required|accepted',
            'checklist_photo_3x4' => 'required|accepted',
            'checklist_photo_2x3' => 'required|accepted',
            'checklist_printout' => 'required|accepted',
            'checklist_sertifikat' => 'nullable|accepted',
            'checklist_raport' => 'required|accepted',
        ];

        if ($isPmpa) {
            $rules['checklist_rekomendasi'] = 'required|accepted';
        } else {
            $rules['checklist_rekomendasi'] = 'nullable';
        }

        $validated = $request->validate($rules);
        
        $applicant->update([
            'documents_checklist' => $validated
        ]);
    }
    
    /**
     * Get step data
     */
    private function getStepData($applicant, $step)
    {
        switch ($step) {
            case 1:
                return $applicant; // Biodata with psikis & intellectual
            case 2:
                $education = $applicant->education;
                $existingGrades = $applicant->grades;
                $competitions = $applicant->competitions;
                return compact('education', 'existingGrades', 'competitions');
            case 3:
                return $applicant->parents; // Parents (Data Orang Tua)
            case 4:
                return $applicant->hobby; // Hobbies (Minat & Bakat)
            case 5:
                return $applicant->documents_checklist; // Finalization
            default:
                return null;
        }
    }
}
