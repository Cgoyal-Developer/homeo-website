INSERT INTO %dbprefix%navigation_menu (menu_name, parent_name, menu_order, menu_url, menu_icon, menu_text, required_module) VALUES ('issue_refund', 'payment', '300', 'payment/issue_refund', NULL, 'issue_refund', NULL);
INSERT INTO %dbprefix%menu_access (menu_name,category_name,allow)  VALUES ('issue_refund', 'Administrator', 1);
INSERT INTO %dbprefix%menu_access (menu_name,category_name,allow)  VALUES ('issue_refund', 'System Administrator', 1);
CREATE TABLE %dbprefix%refund ( refund_id int(11) NOT NULL AUTO_INCREMENT, patient_id int(11) NOT NULL, refund_amount int(12) NOT NULL, refund_date date NOT NULL, refund_note varchar(25) NOT NULL,PRIMARY KEY(refund_id));
ALTER TABLE %dbprefix%patient_account ADD refund_id INT(11) NULL;
INSERT INTO %dbprefix%menu_access (menu_name,category_name,allow) SELECT navigation_menu.menu_name,'System Administrator',1   FROM %dbprefix%navigation_menu AS navigation_menu WHERE navigation_menu.menu_name NOT iN (SELECT menu_access.menu_name FROM %dbprefix%menu_access AS menu_access WHERE menu_access.category_name = 'System Administrator');
CREATE OR REPLACE VIEW %dbprefix%view_visit AS select visit.visit_id AS visit_id,visit.visit_date AS visit_date,visit.visit_time AS visit_time,visit.type AS type,visit.notes AS notes,visit.patient_notes AS patient_notes,visit.doctor_id AS doctor_id,doctor.name AS name,visit.patient_id AS patient_id,patient.reference_by,patient.reference_by_detail,appointments.appointment_reason,bill.bill_id AS bill_id,bill.total_amount AS total_amount,(select ifnull(sum(ifnull(bill_detail.amount,0)),0) from %dbprefix%bill_detail bill_detail where ((bill_detail.bill_id = bill.bill_id) and (bill_detail.type = 'tax'))) AS bill_tax_amount,(select sum(item_bill_detail.tax_amount) from %dbprefix%bill_detail item_bill_detail where (item_bill_detail.bill_id = bill.bill_id)) AS item_tax_amount,bill.due_amount AS due_amount from %dbprefix%visit visit  join %dbprefix%view_doctor doctor on doctor.doctor_id = visit.doctor_id  join %dbprefix%patient patient on patient.patient_id = visit.patient_id join %dbprefix%appointments appointments on appointments.visit_id = visit.visit_id join %dbprefix%bill bill on bill.visit_id = visit.visit_id order by visit.patient_id,visit.visit_date,visit.visit_time ;
CREATE OR REPLACE VIEW %dbprefix%view_bill  AS select bill.bill_id AS bill_id, bill.bill_date AS bill_date,	   bill.visit_id AS visit_id,	   doctor.name AS doctor_name,	   ifnull(visit.doctor_id,bill.doctor_id) AS doctor_id,	   bill.clinic_id AS clinic_id,	   clinic.clinic_name AS clinic_name,	   patient.patient_id AS patient_id,	   patient.display_id AS display_id,	   contacts.first_name AS first_name,	   contacts.middle_name AS middle_name,	   contacts.last_name AS last_name,	   bill.total_amount AS total_amount,	   ifnull(bill.tax_amount,0) AS item_tax_amount,	   sum(bill_detail.amount) AS bill_tax_amount,	   bill.due_amount AS due_amount,	   ((select sum(bill_payment_r.adjust_amount) from %dbprefix%bill_payment_r bill_payment_r where (bill_payment_r.bill_id = bill.bill_id))	   + (SELECT IFNULL(SUM(patient_account.adjust_amount),0) FROM %dbprefix%patient_account patient_account WHERE patient_account.bill_id = bill.bill_id)) AS pay_amount   from ((((((%dbprefix%bill bill left join %dbprefix%visit visit on((bill.visit_id = visit.visit_id))) left join %dbprefix%clinic clinic on((clinic.clinic_id = bill.clinic_id))) left join %dbprefix%patient patient on((bill.patient_id = patient.patient_id))) left join %dbprefix%contacts contacts on((contacts.contact_id = patient.contact_id))) left join %dbprefix%view_doctor doctor on((ifnull(visit.doctor_id,bill.doctor_id) = doctor.doctor_id))) left join %dbprefix%bill_detail bill_detail on(((bill_detail.bill_id = bill.bill_id) and (bill_detail.type = 'tax')))) group by bill.bill_id,doctor.name,visit.userid,patient.patient_id ;
CREATE OR REPLACE VIEW %dbprefix%view_patient  AS SELECT patient.patient_id AS patient_id,       patient.blood_group AS blood_group,	   patient.clinic_id AS clinic_id,	   patient.patient_since AS patient_since,	   patient.age AS age,	   patient.display_id AS display_id,	   patient.gender AS gender,	   patient.dob AS dob,	   patient.reference_by AS reference_by,	   patient.followup_date AS followup_date,	   (SELECT SUM(patient_account.adjust_amount) FROM %dbprefix%patient_account patient_account WHERE patient_account.patient_id = patient.patient_id) AS in_account_amount,	   contacts.display_name AS display_name,contacts.contact_id AS contact_id,contacts.first_name AS first_name,contacts.middle_name AS middle_name,contacts.last_name AS last_name,(SELECT contact_details.detail FROM %dbprefix%contact_details contact_details WHERE ((contact_details.contact_id = contacts.contact_id) AND (contact_details.type = 'mobile')) LIMIT 1) AS phone_number,contacts.email AS email from (%dbprefix%patient patient left join %dbprefix%contacts contacts on((patient.contact_id = contacts.contact_id))) ;
UPDATE %dbprefix%version SET current_version='0.7.4';