<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalApiService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url');
    }

    /**
     * Corresponds to:
     * curl -X POST http://localhost:3000/register
     *  -H "Content-Type: application/json"
     *  -d '{"patient_id":"P001"}'
     */
    public function registerPatient(string $patientId)
    {
        $response = Http::post($this->baseUrl . '/register', [
            'patient_id' => $patientId,
        ]);

        // Check if successful
        if ($response->successful()) {
            return $response->json();
        }

        // Throw an exception if not successful
        $response->throw();
    }

    /**
     * Corresponds to:
     * curl -X POST http://localhost:3000/set
     *  -H "Content-Type: application/json"
     *  -d '{
     *        "patient_id": "P001",
     *        "patient_id_value": "P001",
     *        "medical_problems": "Diabetes",
     *        "allergies": "Peanuts",
     *        "medications": "Metformin"
     *      }'
     */
    public function setPatientData(array $data)
    {
        $response = Http::post($this->baseUrl . '/set', $data);

        if ($response->successful()) {
            return $response->json();
        }

        $response->throw();
    }

    /**
     * Corresponds to:
     * curl "http://localhost:3000/get?patient_id=P001"
     */
    public function getPatientData(string $patientId)
    {
        // Pass query parameters as an array
        $response = Http::get($this->baseUrl . '/get', [
            'patient_id' => $patientId,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        $response->throw();
    }
}
