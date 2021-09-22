--  add directory_filter table
ALTER TABLE `profile_field` ADD `directory_filter` TINYINT NOT NULL DEFAULT '0' AFTER `searchable`; 

-- add data to profile_field table
INSERT INTO `profile_field` (`id`, `profile_field_category_id`, `module_id`, `field_type_class`, `field_type_config`, `internal_name`, `title`, `description`, `sort_order`, `required`, `show_at_registration`, `editable`, `visible`, `created_at`, `created_by`, `updated_at`, `updated_by`, `ldap_attribute`, `translation_category`, `is_system`, `searchable`, `directory_filter`) VALUES
(28, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Date', '{\"fieldTypes\":[],\"isVirtual\":false,\"canBeDirectoryFilter\":false}', 'sponsorship_date', 'Sponsorship Date', '', 800, 0, 0, 1, 1, '2021-09-06 18:48:33', 1, '2021-09-07 10:26:38', 1, '', 'UserModule.profile', NULL, 1, 0),
(30, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\CheckboxList', '{\"options\":\"Austin=>Austin\\r\\nAbilene=>Abilene\\r\\nCorpus Christi=>Corpus Christi\\r\\nDallas/Ft. Worth=>Dallas/Ft. Worth\\r\\nHouston=>Houston\\r\\nSan Antonio=>San Antonio\\r\\nEl Paso=>El Paso\\r\\nUnknown=>Unknown\\r\\nFt. Hood/Killeen=>Ft. Hood/Killeen\",\"allowOther\":\"0\",\"other_value\":null,\"fieldTypes\":[],\"isVirtual\":false,\"canBeDirectoryFilter\":false}', 'market', 'Market', '', 200, 0, 0, 1, 1, '2021-09-06 18:56:02', 1, '2021-09-07 11:13:23', 1, '', 'UserModule.profile', NULL, 1, 0),
(35, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Date', '{\"fieldTypes\":[],\"isVirtual\":false,\"canBeDirectoryFilter\":false}', 'license_date', 'License Date', '', 700, 0, 0, 1, 1, '2021-09-06 19:01:22', 1, '2021-09-07 10:25:52', 1, '', 'UserModule.profile', NULL, 1, 0),
(37, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"new=>New\\r\\nfairly_new=>Fairly New\\r\\nsomewhat_experienced=>Somewhat Experienced\\r\\nexperienced=>Experienced\\r\\nvery_experienced=>Very Experienced\\r\\n\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'listing_property_experience', 'Experience listing property', '', 920, 0, 0, 1, 1, '2021-09-06 19:07:43', 1, '2021-09-13 18:13:54', 1, '', 'UserModule.profile', NULL, 1, 0),
(39, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"new=>New\\r\\nfairly_new=>Fairly New\\r\\nsomewhat_experienced=>Somewhat Experienced\\r\\nexperienced=>Experienced\\r\\nvery_experienced=>Very Experienced\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'working_with_buyers_experience', 'Experienced working with buyers', '', 1020, 0, 0, 1, 1, '2021-09-06 19:09:05', 1, '2021-09-08 13:04:48', 1, '', 'UserModule.profile', NULL, 1, 0),
(41, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"new=>New\\r\\nfairly_new=>Fairly New\\r\\nsomewhat_experienced=>Somewhat Experienced\\r\\nexperienced=>Experienced\\r\\nvery_experienced=>Very Experienced\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'experience_with_investing', 'Experience with investing', '', 1110, 0, 0, 1, 1, '2021-09-06 19:10:43', 1, '2021-09-08 13:04:53', 1, '', 'UserModule.profile', NULL, 1, 0),
(42, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\CheckboxList', '{\"options\":\"buy_hold=>Buy and Hold\\r\\nshort_term_rentals=>Short-term rentals\\r\\nflips=>Flips\\r\\nsub2=>Sub2\\r\\nwraps=>Wraps\\r\\nwholesaling=>Wholesaling\",\"allowOther\":\"0\",\"other_value\":null,\"fieldTypes\":[],\"isVirtual\":false,\"canBeDirectoryFilter\":false}', 'investment_deals', 'Kinds of Investment Deals', '', 1120, 0, 0, 1, 1, '2021-09-06 19:13:27', 1, '2021-09-13 18:14:23', 1, '', 'UserModule.profile', NULL, 1, 0),
(51, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Number', '{\"maxValue\":\"\",\"minValue\":\"\",\"fieldTypes\":[],\"isVirtual\":false,\"canBeDirectoryFilter\":false}', 'funds_available', 'Funds available to lend (dollar amount)', '', 1420, 0, 0, 1, 1, '2021-09-06 19:20:21', 1, '2021-09-06 20:30:38', 1, '', 'UserModule.profile', NULL, 1, 0),
(52, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\CheckboxList', '{\"options\":\"spanish=>Spanish\\r\\nfrench=>French\\r\\ngerman=>German\\r\\nitalian=>Italian\\r\\nchinese=>Chinese\\r\\ntagalog=>Tagalog\\r\\npolish=>Polish\\r\\nkorean=>Korean\\r\\nvietnamese=>Vietnamese\\r\\nportuguese=>Portuguese\\r\\njapanese=>Japanese\\r\\ngreek=>Greek\\r\\narabic=>Arabic\\r\\nhindi=>Hindi (urdu)\\r\\nrussian=>Russian\\r\\nyiddish=>Yiddish\\r\\nthai (laotian)=>Thai (laotian)\\r\\npersian=>Persian\\r\\nfrench_creole=>French Creole\\r\\narmenian=>Armenian\\r\\nnavaho=>Navaho\\r\\nhungarian=>Hungarian\\r\\nhebrew=>Hebrew\\r\\ndutch=>Dutch\",\"allowOther\":\"0\",\"other_value\":null,\"fieldTypes\":[],\"isVirtual\":false,\"canBeDirectoryFilter\":false}', 'language_spoken', 'Language Spoken', '', 1500, 0, 0, 1, 1, '2021-09-06 19:24:31', 1, '2021-09-06 20:30:48', 1, '', 'UserModule.profile', NULL, 1, 0),
(54, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"1=>Yes\\r\\n0=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'captain_status', 'Active Captain', '', 300, 0, 0, 1, 1, '2021-09-06 19:56:42', 1, '2021-09-07 10:26:12', 1, '', 'UserModule.profile', NULL, 1, 1),
(55, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"1=>Yes\\r\\n0=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'supervising_broker_status', 'Active Supervising Broker', '', 400, 0, 0, 1, 1, '2021-09-06 19:57:53', 1, '2021-09-07 10:26:18', 1, '', 'UserModule.profile', NULL, 1, 1),
(56, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"1=>Yes\\r\\n0=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'commerical_supervisor_status', 'Active Commercial Supervisor', '', 500, 0, 0, 1, 1, '2021-09-06 19:59:31', 1, '2021-09-07 10:26:26', 1, '', 'UserModule.profile', NULL, 1, 0),
(57, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"1=>Yes\\r\\n0=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'broker', 'Broker', '', 600, 0, 0, 1, 1, '2021-09-06 20:04:48', 1, '2021-09-07 10:26:32', 1, '', 'UserModule.profile', NULL, 1, 0),
(58, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'list_property_for_seller', 'List property for sellers', '', 910, 0, 0, 1, 1, '2021-09-06 20:06:36', 1, '2021-09-13 18:13:48', 1, '', 'UserModule.profile', NULL, 1, 0),
(59, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'pay_referral_fees', 'Pay referral fees for listings', '', 930, 0, 0, 1, 1, '2021-09-06 20:11:54', 1, '2021-09-13 18:14:03', 1, '', 'UserModule.profile', NULL, 1, 0),
(60, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'work_with_buyers', 'Work with buyers', '', 1010, 0, 0, 1, 1, '2021-09-06 20:13:30', 1, '2021-09-13 18:21:27', 1, '', 'UserModule.profile', NULL, 1, 1),
(61, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'wholesaler', 'Wholesaler', '', 1130, 0, 0, 1, 1, '2021-09-06 20:16:20', 1, '2021-09-13 18:15:52', 1, '', 'UserModule.profile', NULL, 1, 1),
(62, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'deals_from_wholesalers', 'Looking for deals for wholesalers', '', 1140, 0, 0, 1, 1, '2021-09-06 20:17:43', 1, '2021-09-13 18:16:10', 1, '', 'UserModule.profile', NULL, 1, 1),
(64, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'mentor_listing_property', 'Mentor - Listing Property', 'I would be willing to mentor someone in listing property', 1210, 0, 0, 1, 1, '2021-09-06 20:23:18', 1, '2021-09-13 18:16:34', 1, '', 'UserModule.profile', NULL, 1, 1),
(65, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'mentor_working_buyers', 'Mentor - Working Buyers', 'I would be willing to mentor someone in working buyers', 1220, 0, 0, 1, 1, '2021-09-06 20:24:05', 1, '2021-09-13 18:16:45', 1, '', 'UserModule.profile', NULL, 1, 1),
(66, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'mentor_investing', 'Mentor - Investing', 'I would be willing to mentor someone in investing', 1230, 0, 0, 1, 1, '2021-09-06 20:24:54', 1, '2021-09-13 18:16:55', 1, '', 'UserModule.profile', NULL, 1, 1),
(68, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'partner', 'Partnering', 'I would be willing to partner with someone on an investment deal', 1300, 0, 0, 1, 1, '2021-09-06 20:28:41', 1, '2021-09-13 18:17:08', 1, '', 'UserModule.profile', NULL, 1, 0),
(69, 4, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'lending', 'Lending', 'I am or am willing to be a private money lender to StepStone agents with deals', 1410, 0, 0, 1, 1, '2021-09-06 20:29:30', 1, '2021-09-13 18:17:17', 1, '', 'UserModule.profile', NULL, 1, 0),
(70, 5, NULL, 'humhub\\modules\\user\\models\\fieldtype\\Select', '{\"options\":\"yes=>Yes\\r\\nno=>No\",\"canBeDirectoryFilter\":true,\"fieldTypes\":[],\"isVirtual\":false}', 'broker2', 'Broker2', '', 600, 0, 0, 1, 1, '2021-09-06 20:04:48', 1, '2021-09-07 10:26:32', 1, '', 'UserModule.profile', NULL, 1, 0);

-- --------------------------------------------------------


-- add records for tabs to the profile_field_category
INSERT INTO `profile_field_category` (`id`, `title`, `description`, `sort_order`, `module_id`, `visibility`, `created_at`, `created_by`, `updated_at`, `updated_by`, `translation_category`, `is_system`) VALUES
(4, 'StepStone', '', 1, NULL, 1, '2021-09-06 18:43:55', 1, '2021-09-06 19:58:28', 1, 'UserModule.profile', NULL),
(5, 'StepStone - Locked', '', 400, NULL, 1, '2021-09-06 20:32:45', 1, '2021-09-06 20:34:41', 1, 'UserModule.profile', NULL);

