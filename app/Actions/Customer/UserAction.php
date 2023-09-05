<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;
use App\Models\User;
use Hash;

class UserAction
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        if ($this->data['action'] == 'ADD') {
            try {
                $user = new User();
                $user->name = $this->data['name'];
                $user->email = $this->data['email'];
                $user->password = Hash::make($this->data['password']);
                $user->customer_id = $this->actionRecord->id;

                return $user->save();
            } catch (\Exception $e) {
                return 0;
            }
        }

        if ($this->data['action'] == 'GET_ID') {
            return User::accountCode($this->actionRecord->accountcode)
                ->find($this->data['id']);
        }

        if ($this->data['action'] == 'DELETE') {
            return User::accountCode($this->actionRecord->accountcode)
                ->id($this->data['id'])
                ->delete();
        }

        if ($this->data['action'] == 'GET') {
            return User::accountCode($this->actionRecord->accountcode)
                ->get()
                ->toArray();
        }

        if ($this->data['action'] == 'UPDATE') {
            $user = User::find($this->data['id']);

            if ($user == null) {
                return ['success' => false, 'message' => 'User not found'];
            }

            $user->name = $this->data['name'];

            if ($user->password != $this->data['password']) {
                $user->password = Hash::make($this->data['password']);
            }

            $user->save();

            return ['success' => true, 'message' => 'User updated successfully'];
        }
    }
}
