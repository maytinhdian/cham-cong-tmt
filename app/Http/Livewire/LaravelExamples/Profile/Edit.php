<?php

namespace App\Http\Livewire\LaravelExamples\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Core\Services\ActivityLogger;
use Modules\User\Models\Employee;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;

    public ?Employee $employee = null;

    public $picture;

    public $confirmationPassword='';

    public $new_password="";

    public $old_password='';

    /**
     * Validate basic self-service profile fields for the current user.
     */
    protected function rules(){
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'user.phone' => ['nullable', 'string', 'max:30'],
            'user.location' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Load the authenticated user's account and linked employee profile.
     */
    public function mount() { 
        $this->user = auth()->user()->load(['role', 'employeeProfile.department', 'employeeProfile.position']);
        $this->employee = $this->user->employeeProfile;
    }

    /**
     * Validate one edited profile field as the user changes it.
     */
    public function updated($propertyName){

        $this->validateOnly($propertyName);

    }

    /**
     * Update the current user's basic profile and mirror simple contact fields to employee data.
     */
    public function update()
    {
        $this->validate();

        if (env('IS_DEMO') && in_array(auth()->user()->id, [1, 2, 3])){
            
            if( auth()->user()->email == $this->user->email ){

                $this->storePictureWhenUploaded();

                $this->user->save();
                return back()->withStatus('Profile successfully updated.');
            }
            
            return back()->with('demo', "You are in a demo version. You are not allowed to change the email for a default user." );
        };

        $this->storePictureWhenUploaded();
        $this->user->save();
        $this->syncEmployeeContact();

        app(ActivityLogger::class)->logForCurrentRequest(
            'profile',
            'profile.updated',
            $this->user,
            'User updated their own basic profile.'
        );

        return back()->withStatus('Đã cập nhật thông tin cá nhân.');
    }

    /**
     * Change the current user's password after checking the old password.
     */
    public function passwordUpdate(){

        $this->validate([ 
            'old_password' => 'required',
            'new_password' => 'required|min:7|same:confirmationPassword',
        ]);

        if (env('IS_DEMO') && in_array(auth()->user()->id, [1, 2, 3])){

            return back()->with('demo', "You are in a demo version. You are not allowed to change the password for a default user." );
        }
        
        $hashedPassword = auth()->user()->password;

        if (Hash::check($this->old_password , $hashedPassword)) {
            if (!Hash::check($this->new_password , $hashedPassword))
            {
                $users = User::findorFail(auth()->user()->id);
                $users->password = $this->new_password;
                $users->save();
                app(ActivityLogger::class)->logForCurrentRequest(
                    'profile',
                    'password.updated',
                    $users,
                    'User changed their own password.'
                );

                $this->reset(['old_password', 'new_password', 'confirmationPassword']);

                return back()->with(['success'=>'Đã cập nhật mật khẩu.']);
            }
            else{
                return back()->with(['error' =>"Mật khẩu mới không được trùng mật khẩu cũ."]);
            } 
        }
        else{
            return back()->with(['error' =>"Mật khẩu hiện tại chưa đúng."]);
        }
    } 

    /**
     * Render the self-service profile page for the authenticated user.
     */
    public function render()
    {
        return view('livewire.laravel-examples.profile.edit', [
            'employee' => $this->employee,
        ]);
    }

    /**
     * Store an uploaded profile picture and remove the previous custom picture when safe.
     */
    private function storePictureWhenUploaded(): void
    {
        if (! $this->picture) {
            return;
        }

        $this->validate([
            'picture' => 'mimes:jpg,jpeg,png,bmp,tiff|max:4096',
        ]);

        $currentAvatar = $this->user->picture;
        $templateAvatars = ['profile/avatar.jpg', 'profile/avatar2.jpg', 'profile/avatar3.jpg'];

        if ($currentAvatar && ! in_array($currentAvatar, $templateAvatars, true) && Storage::disk('public')->exists($currentAvatar)) {
            Storage::disk('public')->delete($currentAvatar);
        }

        $this->user->picture = $this->picture->store('profile', 'public');
    }

    /**
     * Keep simple contact fields aligned with the linked employee profile.
     */
    private function syncEmployeeContact(): void
    {
        if (! $this->employee) {
            return;
        }

        $this->employee->update([
            'full_name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
        ]);
    }
}
