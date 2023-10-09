<?php

namespace App\Repository;
use App\Models\User;
use App\Models\Certificate;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function store($request)
    {
        DB::beginTransaction();
        try 
        {
            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->bio = $request->bio;
            $user->map_location = $request?->map_location;
            $user->date_of_birth = $request?->date_of_birth;
            $user->save();
            if($request->title)
            {
                $certificate = new Certificate();
                $certificate->title = $request->title;
                $certificate->file = saveimage($request->file('file'),'images/certificate/');
                $certificate->user_id = $user->id;
                $certificate->save();
            }
            DB::commit();
            return response()->json(['message' => 'user is saved'], 200);
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }
    }

}
