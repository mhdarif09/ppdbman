<?php

use App\Models\PpdbPathway;
use Illuminate\Support\Facades\Schema;

echo "Verifying Database State...\n";

// Check Pathways
$pathways = PpdbPathway::pluck('name')->toArray();
echo "Pathways found: " . implode(', ', $pathways) . "\n";

if (count($pathways) === 2 && in_array('Reguler', $pathways) && in_array('PMPA', $pathways)) {
    echo "PASS: Pathways are correct.\n";
} else {
    echo "FAIL: Pathways are incorrect.\n";
}

// Check Column
if (Schema::hasColumn('applicants', 'documents_checklist')) {
    echo "PASS: 'documents_checklist' column exists in 'applicants' table.\n";
} else {
    echo "FAIL: 'documents_checklist' column missing.\n";
}

// Check Views
$views = [
    resource_path('views/applicant/registration/step6.blade.php'),
    resource_path('views/applicant/registration/step7.blade.php')
];

foreach ($views as $view) {
    if (file_exists($view)) {
        echo "PASS: View file exists: " . basename($view) . "\n";
    } else {
        echo "FAIL: View file missing: " . basename($view) . "\n";
    }
}
