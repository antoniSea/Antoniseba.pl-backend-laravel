<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\UpdateUserImageRequest;
use Intervention\Image\Facades\Image;
use App\Models\User;


class UserController extends Controller
{
    public function profile ()
    {
        $user = auth()->user();
        
        $tokens = $user->tokens()->get();

        return Inertia::render('User/Profile', [
            'user' => $user,
            'accessTokens' => $tokens
        ]);
    }

    public function updateUserName (Request $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect(route('profile.index'));
    }

    public function updateUserImage ( UpdateUserImageRequest $request ) {
        $user = auth()->user();
        
        $image = $request->file('file');
        
        if ($user->image) {
            Storage::delete($user->image);
        }
        $img = Image::make($image);

        // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
        $img->fit(300, 300);
        $img->stream(); // <-- Key point
        $img->save(storage_path('app/public/images/' . $user->id . '-' . $image->getClientOriginalName()));

        $user->image = $user->id . '-' . $image->getClientOriginalName();
        $user->save();

        return redirect(route('profile.index'))->with('success', true);
    }

    public function updateUserPassword ( Request $request ) {
        $user = auth()->user();
        
        // check if old password is correct
        if (!password_verify($request->password, $user->password)) {
            return 'Incorrect password';
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect(route('profile.index'));
    }

    public function ShowToken ( $id ) {
        $user = auth()->user();
        $token = $user->tokens()->findorfail($id);
        $token->access_token = $token->token;

        $users = User::paginate(10);

        return Inertia::render('User/ShowToken', [ 'token' => $token, 'users' => $users ]);
    }

    public function DeleteToken ( $id ) {
        $user = auth()->user();
        $token = $user->tokens()->findorfail($id);
        $token->delete();
        
        return redirect(route('profile.index'));
    }

    public function createToken () {
        return Inertia::render('User/CreateToken');
    }

    public function storeToken ( Request $request  ) {
        $user = auth()->user();
        if (!password_verify($request->password, $user->password)) {
            return 'Incorrect password';
        }

        $token = $user->createToken('$request->title')->accessToken->token;

        return redirect(route('profile.index'));
    }

}
