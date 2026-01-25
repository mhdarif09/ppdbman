<?php

namespace App\Imports;

use App\Models\AnnouncementResult;
use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AnnouncementResultsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $announcementId;

    public function __construct($announcementId)
    {
        $this->announcementId = $announcementId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find applicant by NISN or Registration Number
        $applicant = Applicant::where('nisn', $row['nisn'])
            ->orWhere('registration_number', $row['no_pendaftaran'])
            ->first();

        if (!$applicant) {
            return null; // Skip if not found
        }

        // Determine result enum
        $result = strtolower($row['status']);
        if (!in_array($result, ['accepted', 'rejected', 'waiting_list'])) {
            $result = 'rejected'; // Default fallback
        }

        return new AnnouncementResult([
            'announcement_id' => $this->announcementId,
            'applicant_id'    => $applicant->id,
            'result'          => $result,
            'rank'            => $row['ranking'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required_without:no_pendaftaran',
            'no_pendaftaran' => 'required_without:nisn',
            'status' => 'required|in:accepted,rejected,waiting_list,Accepted,Rejected,Waiting_List,Diterima,Ditolak',
        ];
    }
}
