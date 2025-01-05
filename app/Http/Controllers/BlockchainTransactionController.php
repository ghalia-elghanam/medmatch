<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockchainTransactionController extends Controller
{
    /**
     * Display the blockchain transaction page for a specific user.
     *
     * @param  User  $user
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(User $user)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to /doctor/login if the user is not authenticated
            return redirect('/doctor/login');
        }

        // Fetch patient history
        $allergiesMedicine = $user->allergies_medicine; // Assuming a relationship is defined
        $allergiesComponent = $user->allergies_component; // Assuming a relationship is defined

        // Pass the user and history data to the view
        return view('blockchain.transaction', [
            'user' => $user,
            'allergiesMedicine' => $allergiesMedicine,
            'allergiesComponent' => $allergiesComponent,
        ]);
    }
}
