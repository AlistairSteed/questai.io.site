<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create_client']);
        Permission::create(['name' => 'create_campaign']);
        Permission::create(['name' => 'edit_campaign']);
        Permission::create(['name' => 'view_campaign']);
        Permission::create(['name' => 'approved_campaign']);
        Permission::create(['name' => 'end_campaign']);
        Permission::create(['name' => 'campaign_purchase']);
        Permission::create(['name' => 'create_enterprise_admin']);
        Permission::create(['name' => 'create_client_user']);
        Permission::create(['name' => 'update_client_user']);
        Permission::create(['name' => 'view_client_user']);
        Permission::create(['name' => 'delete_client_user']);
        Permission::create(['name' => 'candidate_status_changed']);
        Permission::create(['name' => 'candidate_comment']);
        Permission::create(['name' => 'candidate_view']);
        Permission::create(['name' => 'candidate_purchace']);
        Permission::create(['name' => 'news_create']);
        Permission::create(['name' => 'news_update']);
        Permission::create(['name' => 'news_delete']);
        Permission::create(['name' => 'news_view']);
        Permission::create(['name' => 'campaign_grant_permission']);

        // create roles and assign existing permissions
         // create roles and assign permissions to Reseller Admin
        $role1 = Role::create(['name' => 'reseller_admin', 'ususertype' => 1, 'ususeraccess' => 1]); 
        $role1->givePermissionTo('create_client');
        $role1->givePermissionTo('create_campaign');
        $role1->givePermissionTo('edit_campaign');      
        $role1->givePermissionTo('view_campaign');
        $role1->givePermissionTo('approved_campaign');
        $role1->givePermissionTo('end_campaign');      
        $role1->givePermissionTo('campaign_purchase');
        $role1->givePermissionTo('create_enterprise_admin');
        $role1->givePermissionTo('create_client_user');      
        $role1->givePermissionTo('update_client_user');
        $role1->givePermissionTo('view_client_user');
        $role1->givePermissionTo('delete_client_user');      
        $role1->givePermissionTo('candidate_status_changed');
        $role1->givePermissionTo('candidate_comment');
        $role1->givePermissionTo('candidate_view');      
        $role1->givePermissionTo('candidate_purchace');
        $role1->givePermissionTo('news_create');
        $role1->givePermissionTo('news_update');      
        $role1->givePermissionTo('news_delete');
        $role1->givePermissionTo('news_view');
        $role1->givePermissionTo('campaign_grant_permission');
        
        // create roles and assign permissions to Reseller User
        $role2 = Role::create(['name' => 'reseller_user', 'ususertype' => 1, 'ususeraccess' => 2]);   
        $role2->givePermissionTo('view_campaign');
        $role2->givePermissionTo('candidate_comment');
        $role2->givePermissionTo('candidate_view');      

        // create roles and assign permissions to Enterprise Admin
        $role3 = Role::create(['name' => 'enterprise_admin', 'ususertype' => 2, 'ususeraccess' => 1]);   
        $role3->givePermissionTo('create_client');
        $role3->givePermissionTo('create_campaign');
        $role3->givePermissionTo('edit_campaign');      
        $role3->givePermissionTo('view_campaign');
        $role3->givePermissionTo('approved_campaign');
        $role3->givePermissionTo('end_campaign');      
        $role3->givePermissionTo('campaign_purchase');
        $role3->givePermissionTo('create_enterprise_admin');
        $role3->givePermissionTo('create_client_user');      
        $role3->givePermissionTo('update_client_user');
        $role3->givePermissionTo('view_client_user');
        $role3->givePermissionTo('delete_client_user');      
        $role3->givePermissionTo('candidate_status_changed');
        $role3->givePermissionTo('candidate_comment');
        $role3->givePermissionTo('candidate_view');      
        $role3->givePermissionTo('candidate_purchace');
        $role3->givePermissionTo('news_create');
        $role3->givePermissionTo('news_update');      
        $role3->givePermissionTo('news_delete');
        $role3->givePermissionTo('news_view');
        $role3->givePermissionTo('campaign_grant_permission');
        
        // create roles and assign permissions to Enterprise User
        $role4 = Role::create(['name' => 'enterprise_user', 'ususertype' => 2, 'ususeraccess' => 2]);
        $role4->givePermissionTo('view_campaign');
        $role4->givePermissionTo('candidate_comment');
        $role4->givePermissionTo('candidate_view');

        // create roles and assign permissions to Client Admin
        $role5 = Role::create(['name' => 'client_admin', 'ususertype' => 3, 'ususeraccess' => 1]);   
        $role5->givePermissionTo('create_client');
        $role5->givePermissionTo('create_campaign');
        $role5->givePermissionTo('edit_campaign');      
        $role5->givePermissionTo('view_campaign');
        $role5->givePermissionTo('approved_campaign');
        $role5->givePermissionTo('end_campaign');      
        $role5->givePermissionTo('campaign_purchase');
        $role5->givePermissionTo('create_client_user');      
        $role5->givePermissionTo('update_client_user');
        $role5->givePermissionTo('view_client_user');
        $role5->givePermissionTo('delete_client_user');      
        $role5->givePermissionTo('candidate_status_changed');
        $role5->givePermissionTo('candidate_comment');
        $role5->givePermissionTo('candidate_view');      
        $role5->givePermissionTo('candidate_purchace');
        $role5->givePermissionTo('campaign_grant_permission');
        
        // create roles and assign permissions to Client User
        $role6 = Role::create(['name' => 'client_user', 'ususertype' => 3, 'ususeraccess' => 2]);
        $role6->givePermissionTo('view_campaign');
        $role6->givePermissionTo('candidate_comment');
        $role6->givePermissionTo('candidate_view');
        
        // create roles and assign permissions to QuestAI Manager Admin
        $role7 = Role::create(['name' => 'quest_ai_manager', 'ususertype' => 4, 'ususeraccess' => 1]);      
        $role7->givePermissionTo('create_client');
        $role7->givePermissionTo('create_campaign');
        $role7->givePermissionTo('edit_campaign');      
        $role7->givePermissionTo('view_campaign');
        $role7->givePermissionTo('approved_campaign');
        $role7->givePermissionTo('end_campaign');      
        $role7->givePermissionTo('campaign_purchase');
        $role7->givePermissionTo('create_enterprise_admin');
        $role7->givePermissionTo('create_client_user');      
        $role7->givePermissionTo('update_client_user');
        $role7->givePermissionTo('view_client_user');
        $role7->givePermissionTo('delete_client_user');      
        $role7->givePermissionTo('candidate_status_changed');
        $role7->givePermissionTo('candidate_comment');
        $role7->givePermissionTo('candidate_view');      
        $role7->givePermissionTo('candidate_purchace');
        $role7->givePermissionTo('news_create');
        $role7->givePermissionTo('news_update');      
        $role7->givePermissionTo('news_delete');
        $role7->givePermissionTo('news_view');
        $role7->givePermissionTo('campaign_grant_permission');
    }
}
