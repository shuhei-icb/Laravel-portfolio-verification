<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AddressController extends Controller
{
  /**
   * 住所編集フォームの表示
   */
  public function edit()
  {
    /** @var User $user */
		$user = Auth::user();
		$user->load('address');

    return Inertia::render('Mypage/Address/Edit', [
      'address' => $user->address,
    ]);
  }

  /**
   * 住所の更新処理
   */
  public function update(Request $request)
{
  $request->validate([
    'zipcode' => ['required', 'digits:7'],
    'prefecture_code' => ['required', 'string'],
    'prefecture' => ['required', 'string', 'max:50'],
    'city' => ['required', 'string', 'max:100'],
    'town' => ['required', 'string', 'max:100'],
    'street' => ['nullable', 'string', 'max:100'],
  ]);

  $user = Auth::user();

  $user->address()->updateOrCreate(
    ['user_id' => $user->id],
    $request->only(['zipcode', 'prefecture_code', 'prefecture', 'city', 'town', 'street'])
  );

  return redirect()->route('mypage.index')->with('message', '住所を更新しました');
}
}
