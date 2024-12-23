ALTER TABLE %dbprefix%patient ADD inquiry_reason VARCHAR(50) NULL;
ALTER TABLE %dbprefix%patient ADD is_inquiry INT(1) NULL;
ALTER TABLE %dbprefix%patient ADD ssn_id VARCHAR(25) NULL;
ALTER TABLE %dbprefix%patient ADD erpnext_key VARCHAR(25) NULL;
ALTER TABLE %dbprefix%doctor ADD sync_status INT NULL;
ALTER TABLE %dbprefix%doctor ADD erpnext_key VARCHAR(25) NULL;
ALTER TABLE %dbprefix%doctor ADD is_deleted INT(1) NULL;
ALTER TABLE %dbprefix%payment ADD payment_status VARCHAR(12) NOT NULL DEFAULT 'complete' AFTER clinic_code;
ALTER TABLE %dbprefix%bill ADD appointment_id INT(11) NULL;
ALTER TABLE %dbprefix%bill_detail ADD tax_id INT(11) NULL;
ALTER TABLE %dbprefix%payment_methods ADD payment_pending INT(1) NULL AFTER needs_cash_calc;
DELETE FROM %dbprefix%navigation_menu where menu_name="list_master";
INSERT INTO %dbprefix%navigation_menu (id, menu_name, parent_name, menu_order, menu_url, menu_icon, menu_text, required_module, is_deleted, sync_status) VALUES (NULL, 'payment_methods', 'administration', 400, 'payment/payment_methods', NULL, 'payment_methods', NULL, NULL, NULL);
INSERT INTO %dbprefix%navigation_menu (id, menu_name, parent_name, menu_order, menu_url, menu_icon, menu_text, required_module, is_deleted, sync_status) VALUES (NULL, 'tax_rates', 'administration', 700, 'settings/tax_rates', NULL, 'tax_rates', NULL, NULL, NULL);
INSERT INTO %dbprefix%navigation_menu (id, menu_name, parent_name, menu_order, menu_url, menu_icon, menu_text, required_module, is_deleted, sync_status) VALUES (NULL, 'reference_by', 'administration', 750, 'settings/reference_by', NULL, 'reference_by', NULL, NULL, NULL);
INSERT INTO %dbprefix%navigation_menu (id, menu_name, parent_name, menu_order, menu_url, menu_icon, menu_text, required_module, is_deleted, sync_status) VALUES (NULL, 'pending_payments', 'payment', 400, '/payment/pending_payments', NULL, 'pending_payments', NULL, NULL, NULL);
INSERT INTO %dbprefix%menu_access (id, menu_name, category_name, allow) VALUES (NULL, 'pending_payments', 'System Administrator', 1);
INSERT INTO %dbprefix%menu_access (id, menu_name, category_name, allow) VALUES (NULL, 'pending_payments', 'Administrator', 1);
INSERT INTO %dbprefix%menu_access (id, menu_name, category_name, allow) VALUES (NULL, 'pending_payments', 'Doctor', 1);
ALTER TABLE %dbprefix%menu_access ADD UNIQUE( menu_name, category_name);
UPDATE %dbprefix%version SET current_version='0.7.7';
CREATE OR REPLACE VIEW %dbprefix%view_payment  AS  select distinct payment.payment_id AS payment_id,payment.clinic_id AS clinic_id,payment.pay_date AS pay_date,payment.pay_mode AS pay_mode,payment.payment_status,payment.additional_detail AS additional_detail,payment.pay_amount AS pay_amount,patient.patient_id AS patient_id,patient.display_id AS display_id,contacts.first_name AS first_name,contacts.middle_name AS middle_name,contacts.last_name AS last_name from ((%dbprefix%payment payment join %dbprefix%patient patient on((patient.patient_id = payment.patient_id))) join %dbprefix%contacts contacts on((contacts.contact_id = patient.contact_id))) ;
CREATE OR REPLACE VIEW %dbprefix%view_visit  AS  select visit.visit_id AS visit_id,visit.visit_date AS visit_date,visit.visit_time AS visit_time,visit.type AS type,visit.notes AS notes,visit.patient_notes AS patient_notes,visit.doctor_id AS doctor_id,doctor.name AS name,visit.patient_id AS patient_id,patient.reference_by AS reference_by,patient.reference_by_detail AS reference_by_detail,bill.bill_id AS bill_id,bill.total_amount AS total_amount,(select ifnull(sum(ifnull(bill_detail.amount,0)),0) from %dbprefix%bill_detail bill_detail where ((bill_detail.bill_id = bill.bill_id) and (bill_detail.type = 'tax'))) AS bill_tax_amount,(select sum(item_bill_detail.tax_amount) from %dbprefix%bill_detail item_bill_detail where (item_bill_detail.bill_id = bill.bill_id)) AS item_tax_amount,bill.due_amount AS due_amount from %dbprefix%visit visit join %dbprefix%view_doctor doctor on doctor.doctor_id = visit.doctor_id join %dbprefix%patient patient on patient.patient_id = visit.patient_id join %dbprefix%bill bill on bill.visit_id = visit.visit_id order by visit.patient_id,visit.visit_date,visit.visit_time ;
CREATE OR REPLACE VIEW %dbprefix%view_doctor AS SELECT doctor.is_deleted,doctor.erpnext_key,doctor.sync_status,doctor.contact_id,contacts.title, contacts.first_name, contacts.middle_name, contacts.last_name, concat(ifnull(contacts.title,''),' ',ifnull(contacts.first_name,''),' ',ifnull(contacts.middle_name,''),' ',ifnull(contacts.last_name,'')) AS name,doctor.doctor_id AS doctor_id,doctor.department_id AS department_id,doctor.userid AS userid,users.centers AS centers from %dbprefix%doctor doctor      join %dbprefix%contacts contacts on contacts.contact_id = doctor.contact_id	 join %dbprefix%users users on users.userid = doctor.userid;
CREATE OR REPLACE VIEW %dbprefix%view_patient AS SELECT patient.ssn_id,patient.is_inquiry,patient.inquiry_reason,patient.sync_status,patient.is_deleted, patient.erpnext_key,patient.patient_id AS patient_id,patient.clinic_id AS clinic_id,patient.blood_group AS blood_group,patient.clinic_code AS clinic_code,patient.patient_since AS patient_since,patient.age AS age,patient.display_id AS display_id,patient.gender AS gender,patient.dob AS dob,patient.reference_by AS reference_by,patient.reference_by_detail AS reference_by_detail,patient.followup_date AS followup_date,((select ifnull(sum(ifnull(patient_account.adjust_amount,0)),0) from %dbprefix%patient_account patient_account where ((patient_account.patient_id = patient.patient_id) and (patient_account.payment_id is not null))) - (select ifnull(sum(ifnull(patient_account.adjust_amount,0)),0) from %dbprefix%patient_account patient_account where ((patient_account.patient_id = patient.patient_id) and (patient_account.bill_id is not null)))) AS in_account_amount,contacts.display_name AS display_name,contacts.contact_id AS contact_id,contacts.title AS title,contacts.first_name AS first_name,contacts.middle_name AS middle_name,contacts.last_name AS last_name,CONCAT(IFNULL(contacts.title,''),' ',IFNULL(contacts.first_name,''),' ',IFNULL(contacts.middle_name,''),' ',IFNULL(contacts.last_name,'')) AS patient_name,(select contact_details.detail from %dbprefix%contact_details contact_details where ((contact_details.contact_id = contacts.contact_id) and (contact_details.type = 'mobile')) limit 1) AS phone_number,contacts.email AS email from (%dbprefix%patient patient left join %dbprefix%contacts contacts on((patient.contact_id = contacts.contact_id))) ;