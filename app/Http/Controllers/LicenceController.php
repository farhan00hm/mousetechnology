<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('licence.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            if($user->licencesKey == ""){
                $decryptedLicence = "";
            }
            else{
                $decryptedLicence = decrypt($user->licencesKey);
            }
            return response()->json([
                "success" => 1,
                "message" => $user,
                "decryptedLicenceKey" => $decryptedLicence
            ], 200);
        }
        else{
            return response()->json([
                "success" => 0,
                "message" => "User not found for this id"
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('clientId');
        $user = User::find($id);
        $date = Carbon::now()->addMonths($request->input('month'));
        $licenceKey = $request->input('licenceKey');
        $user->licencesKey = encrypt($licenceKey);
        $user->expireDate = encrypt($date);
        $user->save();
//        User::where('id', '=', $id)->update(array('licenceKey' => $licenceKey));
        return response()->json([
            "success" => 1,
            "message" => $user,
            'decryptedLicenceKey' => $licenceKey
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function enterLicenceKey()
    {
        return view('licence.enter-licence-key');
    }

    public function activeLicenceKey(Request $request)
    {
        $key = $request->input('licenceKey');
        $user = Auth()->user();
        $storedLicenceKey = decrypt($user->licencesKey);
        $decryptedDate = decrypt($user->expireDate);
        $date = Carbon::parse($decryptedDate)->format('d-m-Y');
        $user->licencesKey = encrypt(substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0,6));
        $newDate = Carbon::now()->addMonths(6);
        $user->expireDate = encrypt($newDate);
        $user->save();
        if ($storedLicenceKey == $key) {
            return response()->json([
                "success" => 1,
                "message" => "Congratulations!! Your License Has Been Activated. It will work till " . $date,
            ], 200);
        } else {
            return response()->json([
                "success" => 0,
                "message" => "Invalid Licence",
            ], 200);
        }
    }
}
