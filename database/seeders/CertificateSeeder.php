<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\DocumentType;
use App\Models\User;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the WQT document type
        $wqtDocType = DocumentType::where('category', 'WQT')->first();
        if (!$wqtDocType) {
            $this->command->warn('DocumentType WQT not found. Run DocumentTypeSeeder first.');
            return;
        }

        // Get or create the user with identification_no GMF-533
        $welderUser = User::firstOrCreate(
            ['identification_no' => 'GMF-533'],
            [
                'name' => 'John Welder',
                'email' => 'welder.gmf533@example.com',
                'password' => bcrypt('password123'),
                'phone' => '555-1001',
                'address' => '123 Welding Lane',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'role' => 'user',
            ]
        );

        // Create WQT certificate with detailed test data
        Certificate::create([
            'user_id' => $welderUser->id,
            'certificate_no' => 'GMF/WQT/AWS/0612',
            'welder_name' => 'John Welder',
            'welder_identification_no' => 'GMF-533',
            'test_date' => '2025-04-09',
            'data' => [
                'welder_type' => 'welder',
                'wps_no' => 'WPS-GMS-AWS-002',
                'wps_revision' => '1',
                'qualification' => [
                    'process_type' => [
                        'actual' => 'SMAW + FCAW-GS',
                        'qualification' => 'SMAW + FCAW-GS',
                    ],
                    'electrode' => [
                        'actual' => 'single electrode',
                        'qualification' => 'SMAW + FCAW-GS',
                    ],
                    'current_polarity' => [
                        'actual' => 'DC EP + DC EN',
                        'qualification' => 'All for dihedral angle >= 30 to flat, over head and vertical',
                    ],
                    'position' => [
                        'actual' => '3G & 4G',
                        'qualification' => 'All for dihedral angle >= 30 to flat, over head and vertical',
                    ],
                    'welding_progression' => [
                        'actual' => 'Uphill',
                        'qualification' => 'Uphill',
                    ],
                    'backing' => [
                        'actual' => 'Yes [FCAW-GS]',
                        'qualification' => 'With [FCAW-GS]',
                    ],
                    'material_specification' => [
                        'actual' => 'ASTM A36',
                        'qualification' => 'Any',
                    ],
                    'base_metal' => [
                        'actual' => '16 MM',
                        'qualification' => '5 mm to 32 mm',
                    ],
                    'thickness_plate' => [
                        'actual' => '16 MM',
                        'qualification' => '5 mm to 32 mm',
                    ],
                    'thickness_plate_fillet' => [
                        'actual' => null,
                        'qualification' => 'Any thickness',
                    ],
                    'thickness_pipe_groove' => [
                        'actual' => null,
                        'qualification' => '5 mm to unlimited',
                    ],
                    'thickness_pipe_fillet' => [
                        'actual' => null,
                        'qualification' => 'Any thickness',
                    ],
                    'diameter_pipe_groove' => [
                        'actual' => null,
                        'qualification' => '24 to above',
                    ],
                    'diameter_pipe_fillet' => [
                        'actual' => null,
                        'qualification' => 'any size',
                    ],
                    'filler_metal_spec' => [
                        'actual' => 'A 5.20 [FCAW-GS]',
                        'qualification' => 'F6 [FCAW-GS]',
                    ],
                    'filler_metal_aws_class' => [
                        'actual' => 'E71T-1C',
                        'qualification' => 'F6 [FCAW-GS]',
                    ],
                    'filler_metal_f_no' => [
                        'actual' => 'F6 [FCAW-GS]',
                        'qualification' => 'F6 [FCAW-GS]',
                    ],
                    'gas_flux_type' => [
                        'actual' => 'co2 [FCAW-GS]',
                        'qualification' => 'co2 [FCAW-GS]',
                    ],
                    'others' => [
                        'actual' => null,
                        'qualification' => 'co2 [FCAW-GS]',
                    ],
                ],
                'visual_examination' => [
                    'complete_weld_result' => 'acceptable',
                ],
                'guide_bend' => [
                    'sb_1_3g' => 'acceptable',
                    'sb_2_3g' => 'acceptable',
                    'sb_1_4g' => 'acceptable',
                    'sb_2_4g' => 'acceptable',
                ],
                'mechanical_test' => [
                    'conducted_by' => 'John Welder',
                    'lab_test_no' => '1018/GMF-WQT/2025 & 1019/GMF-WQT/2025',
                ],
                'ultrasonic_test' => [
                    'report_no' => null,
                    'technician' => 'ASNT level II',
                    'results' => null,
                    'company' => null,
                ],
                'supervision' => [
                    'welding_supervised_by' => 'John Welder',
                    'company' => null,
                ],
                'organizations' => [
                    [
                        'name' => 'PT GOLDEN MELAINDO FABRIKASI',
                        'signed_by' => 'John Welder',
                    ],
                    [
                        'name' => 'WELDING DEPARTMENT',
                        'signed_by' => 'John Welder',
                    ],
                    [
                        'name' => 'THIRD PARTY',
                        'signed_by' => 'John Welder',
                    ],
                ],
            ],
        ]);

        $this->command->info('WQT Certificate GMF/WQT/AWS/0612 created for user GMF-533');
    }
}
