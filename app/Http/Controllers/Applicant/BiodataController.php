<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    /**
     * Show biodata form.
     */
    public function edit()
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        // Check if applicant has selected a pathway
        if (!$applicant->ppdb_pathway_id) {
            return redirect()->route('applicant.dashboard')
                ->with('error', 'Silakan pilih jalur PPDB terlebih dahulu.');
        }
        
        $isReadonly = !is_null($applicant->biodata_completed_at);
        
        return view('applicant.biodata.edit', compact('applicant', 'isReadonly'));
    }
    
    /**
     * Update biodata.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        // Check if biodata already completed
        if ($applicant->biodata_completed_at) {
            return redirect()->route('applicant.dashboard')
                ->with('info', 'Biodata sudah pernah dilengkapi dan tidak dapat diubah.');
        }
        
        $request->validate([
            'nickname' => 'required|string|max:255',
            'nis' => 'required|string|max:20',
            'religion' => 'required|string',
            'nationality' => 'required|string',
            'language' => 'nullable|string',
            'child_order' => 'required|integer|min:1',
            'siblings_count' => 'nullable|integer|min:0',
            'half_siblings_count' => 'nullable|integer|min:0',
            'adopted_siblings_count' => 'nullable|integer|min:0',
            'child_status' => 'nullable|in:lengkap,yatim,piatu,yatim_piatu',
            'current_address' => 'required|string',
            'whatsapp_number' => 'nullable|string|max:20',
            'blood_type' => 'required|in:A,B,AB,O',
            'diseases' => 'nullable|array',
            'allergies' => 'nullable|string',
            'physical_defects' => 'nullable|string',
            'height' => 'required|integer|min:50|max:250',
            'weight' => 'required|integer|min:10|max:200',
        ]);
        
        $data = $request->only([
            'nickname', 'nis', 'religion', 'nationality', 'language',
            'child_order', 'siblings_count', 'half_siblings_count', 'adopted_siblings_count', 'child_status',
            'current_address', 'whatsapp_number',
            'blood_type', 'diseases', 'allergies', 'physical_defects', 'height', 'weight'
        ]);
        
        $data['biodata_completed_at'] = now();
        
        $applicant->update($data);
        
        return redirect()->route('applicant.dashboard')
            ->with('success', 'Biodata berhasil dilengkapi!');
    }
}
