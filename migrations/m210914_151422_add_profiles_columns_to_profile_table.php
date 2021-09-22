<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%profile}}`.
 */
class m210914_151422_add_profiles_columns_to_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // strings need to be COLLATE utf8mb4_unicode_ci
        $this->addColumn('{{%profile}}', 'sponsorship_date', $this->date()->Null());
        $this->addColumn('{{%profile}}', 'market_other_selection', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'market', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'license_date', $this->date()->Null());
        $this->addColumn('{{%profile}}', 'listing_property_experience', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'working_with_buyers_experience', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'experience_with_investing', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'investment_deals_other_selection', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'investment_deals', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'funds_available', $this->integer()->Null());
        $this->addColumn('{{%profile}}', 'language_spoken_other_selection', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'language_spoken', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'captain_status', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'supervising_broker_status', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'commerical_supervisor_status', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'broker', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'list_property_for_seller', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'pay_referral_fees', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'work_with_buyers', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'wholesaler', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'deals_from_wholesalers', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'mentor_listing_property', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'mentor_working_buyers', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'mentor_investing', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'partner', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'lending', $this->string(255)->Null());
        $this->addColumn('{{%profile}}', 'broker2', $this->string(255)->Null());
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%profile}}', 'sponsorship_date');
        $this->dropColumn('{{%profile}}', 'market_other_selection');
        $this->dropColumn('{{%profile}}', 'market');
        $this->dropColumn('{{%profile}}', 'license_date');
        $this->dropColumn('{{%profile}}', 'listing_property_experience');
        $this->dropColumn('{{%profile}}', 'working_with_buyers_experience');
        $this->dropColumn('{{%profile}}', 'experience_with_investing');
        $this->dropColumn('{{%profile}}', 'investment_deals_other_selection');
        $this->dropColumn('{{%profile}}', 'investment_deals');
        $this->dropColumn('{{%profile}}', 'funds_available');
        $this->dropColumn('{{%profile}}', 'language_spoken_other_selection');
        $this->dropColumn('{{%profile}}', 'language_spoken');
        $this->dropColumn('{{%profile}}', 'captain_status');
        $this->dropColumn('{{%profile}}', 'supervising_broker_status');
        $this->dropColumn('{{%profile}}', 'commerical_supervisor_status');
        $this->dropColumn('{{%profile}}', 'broker');
        $this->dropColumn('{{%profile}}', 'list_property_for_seller');
        $this->dropColumn('{{%profile}}', 'pay_referral_fees');
        $this->dropColumn('{{%profile}}', 'work_with_buyers');
        $this->dropColumn('{{%profile}}', 'wholesaler');
        $this->dropColumn('{{%profile}}', 'deals_from_wholesalers');
        $this->dropColumn('{{%profile}}', 'mentor_listing_property');
        $this->dropColumn('{{%profile}}', 'mentor_working_buyers');
        $this->dropColumn('{{%profile}}', 'mentor_investing');
        $this->dropColumn('{{%profile}}', 'market');
        $this->dropColumn('{{%profile}}', 'lending');
        $this->dropColumn('{{%profile}}', 'broker2');
    }
}
