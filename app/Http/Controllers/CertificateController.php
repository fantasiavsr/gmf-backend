<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CertificateController extends Controller
{
    /**
     * Get certificate by certificate number (public endpoint).
     * Returns safe preview information only.
     */
    public function show(string $certificateNo): JsonResponse
    {
        $certificate = Certificate::where('certificate_no', $certificateNo)->first();

        if (!$certificate) {
            return response()->json([
                'error' => 'Certificate not found',
            ], 404);
        }

        // Return safe preview information (no detailed data)
        return response()->json([
            'certificate' => $this->toPublicPreview($certificate),
        ], 200);
    }

    /**
     * Search public certificate previews by welder identification number.
     */
    public function searchByWelderId(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'welder_identification_no' => 'required|string|max:255',
        ]);

        $certificates = Certificate::where(
            'welder_identification_no',
            $validated['welder_identification_no']
        )
            ->orderByDesc('test_date')
            ->get()
            ->map(fn (Certificate $certificate) => $this->toPublicPreview($certificate));

        return response()->json([
            'certificates' => $certificates,
        ], 200);
    }

    private function toPublicPreview(Certificate $certificate): array
    {
        return [
            'certificate_no' => $certificate->certificate_no,
            'welder_name' => $certificate->welder_name,
            'welder_identification_no' => $certificate->welder_identification_no,
            'type' => 'Welder Qualification Test Record',
            'issue_date' => $certificate->created_at->format('Y-m-d'),
            'test_date' => $certificate->test_date->format('Y-m-d'),
            'status' => 'active',
        ];
    }

    /**
     * Get full certificate details for authenticated user if owner.
     */
    public function detail(Request $request, string $certificateNo): JsonResponse
    {
        $user = $request->user();
        $certificate = Certificate::where('certificate_no', $certificateNo)->first();

        if (!$certificate) {
            return response()->json([
                'error' => 'Certificate not found',
            ], 404);
        }

        // Check authorization
        if ($certificate->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'error' => 'Unauthorized. Please contact your administrator for access.',
            ], 403);
        }

        // Return full certificate details
        return response()->json([
            'certificate' => [
                'id' => $certificate->id,
                'certificate_no' => $certificate->certificate_no,
                'welder_name' => $certificate->welder_name,
                'welder_identification_no' => $certificate->welder_identification_no,
                'test_date' => $certificate->test_date->format('Y-m-d'),
                'type' => 'Welder Qualification Test Record',
                'issue_date' => $certificate->created_at->format('Y-m-d'),
                'status' => 'active',
                'data' => $certificate->data,
            ],
        ], 200);
    }

    /**
     * Download certificate PDF (protected).
     */
    public function downloadPdf(Request $request, string $certificateNo): JsonResponse
    {
        $user = $request->user();
        $certificate = Certificate::where('certificate_no', $certificateNo)->first();

        if (!$certificate) {
            return response()->json([
                'error' => 'Certificate not found',
            ], 404);
        }

        // Check authorization
        if ($certificate->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'error' => 'Unauthorized. Please contact your administrator for access.',
            ], 403);
        }

        // Check if document has a file
        if (!$certificate->document || !$certificate->document->file_path) {
            return response()->json([
                'error' => 'PDF file not available for this certificate.',
            ], 404);
        }

        // Return file download (actual implementation would stream the file)
        return response()->json([
            'message' => 'PDF download functionality would be implemented here',
            'file_path' => $certificate->document->file_path,
            'filename' => $certificate->document->original_filename,
        ], 200);
    }

    /**
     * List all certificates for the authenticated user.
     */
    public function listUserCertificates(Request $request): JsonResponse
    {
        $user = $request->user();

        $certificates = Certificate::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($cert) => [
                'id' => $cert->id,
                'certificate_no' => $cert->certificate_no,
                'welder_name' => $cert->welder_name,
                'type' => 'Welder Qualification Test Record',
                'issue_date' => $cert->created_at->format('Y-m-d'),
                'test_date' => $cert->test_date->format('Y-m-d'),
                'status' => 'active',
            ]);

        return response()->json([
            'certificates' => $certificates,
        ], 200);
    }

    /**
     * Admin: Link an unlinked certificate to a user.
     */
    public function linkToUser(Request $request, int|string $certificateId): JsonResponse
    {
        // This is a placeholder for admin functionality
        // In a real implementation, this would require admin middleware
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'error' => 'Only administrators can link certificates.',
            ], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $certificate = Certificate::findOrFail($certificateId);
        $certificate->update([
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Certificate linked to user successfully.',
            'certificate' => $certificate,
        ], 200);
    }
}
