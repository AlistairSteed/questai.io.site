<?php

use App\Models\Infotext;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfotextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infotext', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id');            
            $table->text('field_name')->nullable();       
            $table->text('order')->nullable();        
            $table->text('group')->nullable();         
            $table->text('field_text')->nullable();  
            $table->timestamps();
        });

        Infotext::insert([
            ['enterprise_id' => 16, 'field_name' => 'benefits', 'order' => 1, 'group' => 0, 'field_text' => 'QuestAI removing all forms of bias from the recruitment process.'],
            ['enterprise_id' => 16, 'field_name' => 'benefits', 'order' => 2, 'group' => 0, 'field_text' => 'Reduced costs by a reduction in errors, incidents and accidents together with many other savings.'],
            ['enterprise_id' => 16, 'field_name' => 'benefits', 'order' => 3, 'group' => 0, 'field_text' => 'Increased revenue by being sure of getting the right people into your business to improve quality and customer service.'],
            ['enterprise_id' => 16, 'field_name' => 'benefits', 'order' => 4, 'group' => 0, 'field_text' => 'Solving your problem of getting the best people at the right time.'],

            ['enterprise_id' => 16, 'field_name' => 'cajobtitle', 'order' => null, 'group' => 1, 'field_text' => 'Job Title: Job titles with only 3 words gets the best results from online job sites'],
            ['enterprise_id' => 16, 'field_name' => 'cacity', 'order' => null, 'group' => 1, 'field_text' => 'Location: Help Text here'],
            ['enterprise_id' => 16, 'field_name' => 'clcompanydesc', 'order' => null, 'group' => 1, 'field_text' => 'Client Description: Help Text here'],
            ['enterprise_id' => 16, 'field_name' => 'cajobdesc', 'order' => null, 'group' => 1, 'field_text' => 'Job Description: Help Text here'],
            ['enterprise_id' => 16, 'field_name' => 'caessentialqual', 'order' => null, 'group' => 1, 'field_text' => 'Essential Skills and Qualifications: Help Text here'],
            ['enterprise_id' => 16, 'field_name' => 'cadesirablequal', 'order' => null, 'group' => 1, 'field_text' => 'Preferred Skills and Qualifications: Help Text here'],
            ['enterprise_id' => 16, 'field_name' => 'caadditional', 'order' => null, 'group' => 1, 'field_text' => 'Additional Information: Help Text here'],
            ['enterprise_id' => 16, 'field_name' => 'campaign_checkbox1', 'order' => 1, 'group' => 2, 'field_text' => 'QuestAI assesses applicants based on their mindset. We do not assess skillset. Please tick the box to accept it is your sole responsibility to assess and assure that any applicant you wish to engage is capable and qualified for this role.'],
            ['enterprise_id' => 16, 'field_name' => 'campaign_checkbox2', 'order' => 2, 'group' => 2, 'field_text' => 'Like any recruitment campaign, I understanding and accept that QuestAI cannot guarantee anyone will apply or be suitable for this vacancy. There is no additional charges for recruiting anyone from this campaign and there is no refund if you are not successful in finding new colleagues. Please tick the box to show that you understand the above.'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infotext');
    }
}
