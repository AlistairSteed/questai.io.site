<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
//use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $table = 'users';
    protected $primaryKey = 'usid';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usid',
        'usemail',
        'usfirstname',
        'uslastname',
        'usenterpriseid',
        'usclientid',
        'ususertype',
        'ushashpw',
        'ususeraccess',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'userAccess',
    ];

    public function getAuthPassword()
    {
        return $this->ushashpw;
    }

    public function activeBasket()
    {
        return $this->hasOne(Basket::class, 'bauserid')->where('bacomplete', 0);
    }

    public function userAccess()
    {
        return $this->hasMany(UserAccess::class, 'uausid', 'usid');
    }

    // Clients Permission Start
    public function canAccessAllClients()
    {
        return !!$this->userAccess->first(function($access) {
            return $access->uaclientid === 0;
        });
    }

    public function isAdminForAllClients()
    {
        return !!$this->userAccess->first(function($access) {
            return $access->uaclientid === 0 && $access->uaaccess === 1;
        });
    }

    public function allowedClientIds()
    {
        return $this->userAccess->filter(function($access) {
            return $access->uaclientid;
        })->map(function($access) {
            return $access->uaclientid;
        });
    }

    public function hasAccessToClient(Client $client)
    {
        return $this->canAccessAllClients() || !!$this->userAccess->first(function($access) use ($client) {
            return $access->uaclientid === $client->getKey();
        });
    }

    public function isAdminForClient(Client $client)
    {
        return $this->isAdminForAllClients() || !!$this->userAccess->first(function($access) use ($client) {
            return $access->uaclientid === $client->getKey() && $access->uaaccess === 1;
        });
    }

    public function canCreateUserForClient(Client $client)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForClient($client);
        }
    }

    public function canUpdateUserForClient(Client $client)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForClient($client);
        }
    }
    
    public function canViewUserForClient(Client $client)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForClient($client);
        }
    }
    
    public function canDeleteUserForClient(Client $client)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForClient($client);
        }
    }
    // Clients Permission End

    // Campaign Permission Start    
    public function canAccessAllCampaigns()
    {
        return !!$this->userAccess->first(function($access) {
            return $access->uacampaignid === 0;
        });
    }

    public function isAdminForAllCampaigns()
    {
        return !!$this->userAccess->first(function($access) {
            return $access->uacampaignid === 0 && $access->uaaccess === 1;
        });
    }

    public function allowedCampaignIds()
    {
        return $this->userAccess->filter(function($access) {
            return $access->uacampaignid;
        })->map(function($access) {
            return $access->uacampaignid;
        });
    }

    public function hasAccessToCampaign(Campaign $campaign)
    {
        return $this->canAccessAllCampaigns() || !!$this->userAccess->first(function($access) use ($campaign) {
            return $access->uacampaignid === $campaign->getKey();
        });
    }

    public function isAdminForCampaign(Campaign $campaign)
    {
        return $this->isAdminForAllCampaigns() || !!$this->userAccess->first(function($access) use ($campaign) {
            return $access->uacampaignid === $campaign->getKey() && $access->uaaccess === 1;
        });
    }

    public function canCreateCampaign(Client $client)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            // return $this->isAdminForCampaign($campaign);
            return $this->isAdminForClient($client);
        }
    }

    public function canUpdateCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }
    
    public function canViewCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }
    
    public function canDeleteCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }
    
    public function canApproveCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }

    public function canEndCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }

    public function canBuyCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }

    public function canGrantAccessCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }

    public function canCandidateStatusChangeCampaign(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }

    public function canCandidateBuy(Campaign $campaign)
    {
        if($this->ususertype == 4){
            return true;
        }else{
            return $this->isAdminForCampaign($campaign);
        }
    }
    // Campaign Permission End

    // News Permission Start
    public function canCreateNews()
    {
        if($this->ususertype == 4 && $this->ususeraccess == 1 || $this->ususertype == 1 && $this->ususeraccess == 1 || $this->ususertype == 2 && $this->ususeraccess == 1){
            return true;
        }else{
            return false;
        }
    }

    public function canUpdateNews()
    {
        if($this->ususertype == 4 && $this->ususeraccess == 1 || $this->ususertype == 1 && $this->ususeraccess == 1 || $this->ususertype == 2 && $this->ususeraccess == 1){
            return true;
        }else{
            return false;
        }
    }
    
    public function canViewNews()
    {
        if($this->ususertype == 4 && $this->ususeraccess == 1 || $this->ususertype == 1 && $this->ususeraccess == 1 || $this->ususertype == 2 && $this->ususeraccess == 1){
            return true;
        }else{
            return false;
        }
    }
    
    public function canDeleteNews()
    {
        if($this->ususertype == 4 && $this->ususeraccess == 1 || $this->ususertype == 1 && $this->ususeraccess == 1 || $this->ususertype == 2 && $this->ususeraccess == 1){
            return true;
        }else{
            return false;
        }
    }
    // News Permission End

    public function canUpdateClientDetail()
    {
        if($this->ususertype == 4 && $this->ususeraccess == 1 || $this->ususertype == 1 && $this->ususeraccess == 1 || $this->ususertype == 2 && $this->ususeraccess == 1 || $this->ususertype == 3 && $this->ususeraccess == 1 ){
            return true;
        }else{
            return false;
        }
    }

    public function canShowBasketOrMyOrderPage()
    {
        if($this->ususertype == 4 && $this->ususeraccess == 1 || $this->ususertype == 1 && $this->ususeraccess == 1 || $this->ususertype == 2 && $this->ususeraccess == 1 || $this->ususertype == 3 && $this->ususeraccess == 1 ){
            return true;
        }else{
            return false;
        }
    }
}
