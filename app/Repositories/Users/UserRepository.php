<?php

namespace App\Repositories\Users;

use App\User;
use App\Repositories\Users\UserInterface as UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Illuminate\Support\Facades\Hash;
use Event;
use App\Events\MechanicCreated;
use App\Events\MechanicApproved;
use App\Events\WelComeEmail;
use Laravel\Passport\Token;
use App\Services\SmsApiService;
use DB;

class UserRepository implements UserInterface {

    use VerifiesUsers;

    protected $user;
    protected $token;
    protected $smsapi;

    public function __construct(User $user, Token $token, SmsApiService $smsapi) {
        $this->user = $user;
        $this->token = $token;
        $this->smsapi = $smsapi;
    }

    public function login(array $input) {
        $user = $this->user->Where('email', $input['email'])->orWhere('mobile', $input['email'])->first();

        if (!is_null($user)) {
            $credentials = ['email' => $user->email, 'password' => $input['password']];
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->getRole;
                if ($user->getRole && sizeof($user->getRole) && isset($user->getRole[0]) && $user->getRole[0]) {
                    $role = 1;
                    if (isset($input['id']) && $input['id']) {
                        $role = $input['id'];
                    } elseif (isset($input['role']) && $input['role']) {
                        $role = $input['role'];
                    }
                    $role_id = $user->getRole[0]->id;
                    if ($role_id == $role) {
                        $token = $user->createToken('MyApp');
                        $user->token = $token->accessToken;
                        $user->tokenId = $token->token->id;
                        $user->status = true;
                        return $user->toJson();
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
        return false;
    }

    public function register(array $input) {
        $input['password'] = bcrypt($input['password']);
        try {
            $user = User::create($input);
            (isset($input['role'])) ? $role = \App\Role::whereName($input['role'])->get() : $role = \App\Role::whereName('User')->get();
            $user->roles()->attach($role);
            if (isset($input['role']) && $input['role'] === 'Mechanic') {
                $user->approved = 0;
                Event::fire(new MechanicCreated());
            }
            $user->verified = 1;
            if ($user->save()) {
                $token = $user->createToken('MyApp');
                $user->token = $token->accessToken;
                $user->tokenId = $token->token->id;
                $user->getRole;
                //Log::useDailyFiles(storage_path() . '/logs/registerDetails.log');
                //Log::info(['USER_OBJECT' => $user]);
                return $user;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function logout(array $data) {
        return true;
    }

    public function find($id) {
        return $this->user->findOrFail($id);
    }

    public function create(array $input) {
        $input['password'] = bcrypt($input['password']);
        try {
            $user = $this->user->create($input);
            (isset($input['role'])) ? $role = \App\Role::whereName($input['role'])->get() : $role = \App\Role::whereName('User')->get();
            $user->roles()->attach($role);

            return true;
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(array $data, $id) {
        try {
            $this->user->findOrFail($id)->update($data);
            $user = $this->find($id);
            $role = Auth::user()->getRole->first()->id;
            $role1 = $user->getRole->first()->id;
            if (isset($data['mobile']) && $role === $role1 && $user->mobile !== Auth::user()->mobile) {
                Auth::login($user, true);
                $verification_code = $this->smsapi->sendVerificationCode($user);
                $user->verification_code = $verification_code;
                $user->verified = 0;
                $user->save();
            }
            return true;
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            $this->user->findOrFail($id)->delete();

            return true;
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function findAll() {
        return $this->user->paginate(15);
    }

    public function changePassword($input) {
        try {
            $user = $this->find(Auth::user()->id);
            if (Hash::check($input['old_password'], $user->password)) {
                $user->password = bcrypt($input['new_password']);
                if ($user->save()) {
                    $this->deleteAllToken($user);
                    return true;
                }
            }
            return false;
        } catch (Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }

    public function generatelinkToVerifyAccount() {
        try {
            UserVerification::generate(Auth::user());
            UserVerification::send(Auth::user(), 'Verfiy Your Account');
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function verifyUserAccount($data_array) {
        $user = Auth::user();
        if (isset($user) && $user) {
            $user_id = Auth::user()->id;
            $response = $this->user->whereVerification_code($data_array['verification_code'])
                    ->first();
            if (!is_null($response)) {
                $data = ['verified' => 1];
                $this->user->findOrFail($user_id)->update($data);
                return true;
            }
        }
        return false;
    }

    public function deleteAllToken(User $user) {
        if ($user->tokens->isNotEmpty()) {
            foreach ($user->tokens as $token) {
                $result = $token->delete();
            }
            return $result;
        }
        return false;
    }

    public function approvedMechanic($id) {
        $user = User::find($id);
        if (!$user->approved) {
            Event::fire(new MechanicApproved($user));
        }
    }

    public function generateAccessToken(User $user) {
        $token = $user->createToken('MyApp');
        $user->token = $token->accessToken;
        $user->tokenId = $token->token->id;
        $user->getRole;
        return $user;
    }

    public function addUser(array $input) {
        $input['password'] = bcrypt($input['password']);
        try {
            $input['verified'] = 1;
            $user = User::create($input);
            if (isset($input['role'])) {
                $role = \App\Role::whereName($input['role'])->get();
            } else {
                $role = \App\Role::whereName('User')->get();
            }
            //(isset($input['role'])) ? $role = \App\Role::whereName($input['role'])->get() : $role = \App\Role::whereName('User')->get();
            $user->roles()->attach($role);
            $user->verified = 1;
            if ($user->save()) {
                return $user;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function searchUser($input) {
        try {
            $query = "SELECT users.id, users.name, users.email, users.password, users.mobile_country_code, users.mobile, "
                    . "users.remember_token, users.default_location, users.approved, users.created_at, "
                    . "users.updated_at, users.verified, users.verification_token, users.verification_code, "
                    . "users.profile_photo "
                    . "FROM `users`, `roles`, `role_user` "
                    . "WHERE roles.id = role_user.role_id "
                    . "AND role_user.user_id = users.id "
                    . "AND (users.name LIKE '%$input%' "
                    . "OR users.email LIKE '%$input%' "
                    . "OR users.mobile LIKE '%$input%') ";
            $results = DB::select($query);
            $users = User::hydrate($results);
            if ($users) {
                return $users;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

}
