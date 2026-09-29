<?php

namespace Tests\Feature;

use App\Models\Certificate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateLookupTest extends TestCase
{
    use RefreshDatabase;

    public function test_welder_id_search_returns_database_certificate_previews(): void
    {
        Certificate::create([
            'certificate_no' => 'GMF/WQT/AWS/0612',
            'welder_name' => 'John Welder',
            'welder_identification_no' => 'GMF-533',
            'test_date' => '2025-04-09',
            'data' => ['wps_no' => 'WPS-GMS-AWS-002'],
        ]);

        $this->getJson('/api/certificates/search?welder_identification_no=GMF-533')
            ->assertOk()
            ->assertJsonPath('certificates.0.certificate_no', 'GMF/WQT/AWS/0612')
            ->assertJsonPath('certificates.0.welder_identification_no', 'GMF-533')
            ->assertJsonMissingPath('certificates.0.data');
    }

    public function test_welder_id_search_returns_an_empty_list_when_unmatched(): void
    {
        $this->getJson('/api/certificates/search?welder_identification_no=UNKNOWN')
            ->assertOk()
            ->assertExactJson(['certificates' => []]);
    }

    public function test_certificate_number_preview_accepts_encoded_slashes(): void
    {
        Certificate::create([
            'certificate_no' => 'GMF/WQT/AWS/0612',
            'welder_name' => 'John Welder',
            'welder_identification_no' => 'GMF-533',
            'test_date' => '2025-04-09',
        ]);

        $this->getJson('/api/certificates/preview/GMF%2FWQT%2FAWS%2F0612')
            ->assertOk()
            ->assertJsonPath('certificate.certificate_no', 'GMF/WQT/AWS/0612');
    }
}
