<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    /**
    * @param object $user
    */
    public function __construct(User $user)
    {
    $this->user = $user;
    }

    /**
     * ユーザー作成
     *
     * @var array $data
     */
    public function store($data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->user->create($data);
    }

    /**
     * ログイン処理
     *
     * @var array $data
     */
    public function login($data)
    {
        $user = $this->user->where('email', '=', $data['email'])->first();
        if (Hash::check($data['password'],$user['password']))
        {
            Session::put('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'image' => $user['image'],
                'pref' => $user['pref'],
            ]);
            return redirect('/user/calendar');
        }
        \Session::flash('error_message', 'パスワードが違います');
        return redirect('/user/login');
    }

    /**
     * ユーザー取得
     *
     */
    public function getUser()
    {
        return $this->user->all();
    }

    /**
     * 画像アップロード
     *
     * @param array $condition
     * @return void
     */
    public function upload($condition)
    {
        if ( isset($condition['fileName']) ) {
            //フォルダの作成
            $path = public_path() . '/images/' . Session::get('user')['id'] . '/icon';
            if(! \File::exists($path)) {
                \File::makeDirectory($path, 0775, true);
            }

            //古い画像削除
            \File::delete(public_path() . Session::get('user')['image']);

            //新しい画像追加
            $image = Image::make($condition['fileName']->getRealPath());
            $fileName = $condition['fileName']->getClientOriginalName();

            if ($image->width() >= $image->height()) {
                $image->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas(200, 200, 'center', false, 'ffffff')->save($path . '/' . $fileName);
            } else {
                $image->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas(200, 200, 'center', false, 'ffffff')->save($path . '/' .$fileName);
            }

            //DBにパスを追加
            $new_image = '/images/' . Session::get('user')['id'] . '/icon/' . $fileName;
            $this->user->where('id', '=', Session::get('user')['id'])->update(['image' => $new_image]);

            //セッションを更新
            Session::put('user.image', $new_image);
            DB::table('edit_logs')->insert([
                'user_id' => Session::get('user')['id'],
                'image' => true,
            ]);
        }
    }

    /**
     * ユーザー情報更新
     *
     * @param array $condition
     * @return void
     */
    public function update($condition) 
    {
        if ($condition['name'] != Session::get('user')['name']) {
            $this->user->where('id', '=', Session::get('user')['id'])->update(['name' => $condition['name']]);
            
            Session::put(['user.name' => $condition['name']]);
            DB::table('edit_logs')->insert([
                'user_id' => Session::get('user')['id'],
                'name' => true,
            ]);
        }

        // if ($condition['pref'] != Session::get('user')['pref']) {
        //     $this->user->where('id', '=', Session::get('user')['id'])->update(['pref' => $condition['pref']]);
        //     Session::put(['user.pref' => $condition['pref']]);
        //     DB::table('edit_logs')->insert([
        //         'user_id' => Session::get('user')['id'],
        //         'pref' => true,
        //     ]);
        // }
    }
}