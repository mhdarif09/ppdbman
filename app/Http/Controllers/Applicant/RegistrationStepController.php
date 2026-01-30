<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\ApplicantParent;
use App\Models\ApplicantHobby;
use App\Models\ApplicantDevelopment;
use App\Models\ApplicantGrade;
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
        if ($step < 1 || $step > 7) {
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
                break;
            case 6:
                $this->saveStep6($request, $applicant);
                break;
            case 7:
                $this->saveStep7($request, $applicant);
                return $this->submit($request);
        }
        
        // Update registration step
        if ($step < 7) {
            $applicant->update(['registration_step' => $step + 1]);
            return redirect()->route('applicant.registration.step', $step + 1)
                ->with('success', 'Data berhasil disimpan!');
        }
        
        // If step 7, show final submit button
        return redirect()->route('applicant.registration.step', 7)
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
        ]);
        
        $validated['biodata_completed_at'] = now();
        
        $applicant->update($validated);
    }
    
    // Step 2: Education
    private function saveStep2($request, $applicant)
    {
        $validated = $request->validate([
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
        ]);
        
        $applicant->education()->updateOrCreate(
            ['applicant_id' => $applicant->id],
            [
                'previous_school_name' => $request->previous_school_name,
                'school_address' => $request->school_address,
                'school_type' => $request->school_type,
                'school_npsn' => $request->school_npsn,
                'sttb_number' => $request->sttb_number,
                'sttb_date' => $request->sttb_date,
                'study_duration' => $request->study_duration,
                'is_transfer' => $request->is_transfer,
                'transfer_from_school' => $request->transfer_from_school,
                'transfer_class' => $request->transfer_class,
                'transfer_date' => $request->transfer_date,
                'transfer_program' => $request->transfer_program,
                'transfer_reason' => $request->transfer_reason,
            ]
        );
    }
    
    // Step 3: Parents
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
    
    // Step 4: Hobbies
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
    
    // Step 5: Development
    private function saveStep5($request, $applicant)
    {
        $validated = $request->validate([
            'enrollment_year' => 'required|integer',
            'scholarships' => 'nullable|string',
            'leave_year' => 'nullable|integer',
            'leave_reason' => 'nullable|string',
            'graduation_year' => 'nullable|integer',
            'graduation_sttb_date' => 'nullable|date',
            'graduation_sttb_number' => 'nullable|string',
            'after_graduation_status' => 'nullable|in:melanjutkan,bekerja,lainnya',
            'continued_to' => 'nullable|string',
            'working_at' => 'nullable|string',
        ]);
        
        $applicant->development()->updateOrCreate(
            ['applicant_id' => $applicant->id],
            $validated
        );
    }
    
    // Step 6: Grades
    // Step 6: Grades (Simplified)
    private function saveStep6($request, $applicant)
    {
        $validated = $request->validate([
            'grades' => 'required|array',
        ]);
        
        // Delete existing grades
        $applicant->grades()->delete();
        
        foreach ($validated['grades'] as $subject => $semesters) {
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
    }

    // Step 7: Documents Checklist
    private function saveStep7($request, $applicant)
    {
        $validated = $request->validate([
            'checklist' => 'required|array',
            'checklist.raport' => 'required|accepted',
            'checklist.kk' => 'required|accepted',
            'checklist.akte' => 'required|accepted',
            'checklist.photos_2x3' => 'required|accepted',
            'checklist.photos_3x4' => 'required|accepted',
        ]);
        
        $applicant->update([
            'documents_checklist' => $validated['checklist']
        ]);
    }
    
    /**
     * Get step data
     */
    private function getStepData($applicant, $step)
    {
        switch ($step) {
            case 1:
                return $applicant; // Biodata
            case 2:
                return $applicant->education;
            case 3:
                return $applicant->parents;
            case 4:
                return $applicant->hobby;
            case 5:
                return $applicant->development;
            case 6:
                return $applicant->grades;
            case 7:
                return $applicant->documents_checklist;
            default:
                return null;
        }
    }
}
