INSERT INTO users (user_type, login_name, password, phone, email) VALUES
  ('Employer', 'spotify', 'spotify123456', '4385016383', 'spotify@spotify.com'),
  ('Employer', 'renorun', 'renorun123456', '5145016383', 'renorun@renorun.com'),
  ('Employer', 'busbud', 'busbud123456', '4385026383', 'busbud@busbud.com'),
  ('Recruiter', 'ally_giordino', 'ally123456', '4385016393', 'ally@spotify.com'),
  ('Recruiter', 'karen_banahora', 'karen123456', '4585016383', 'karen@renorun.com'),
  ('Recruiter', 'emily_tetzal', 'emily123456', '4375016383', 'emily@busbud.com'),
  ('Job Seeker', 'dunya_oguz', 'dunyas_password', '6385016383', 'dunya@concordia.ca'),
  ('Job Seeker', 'azman_akhter', 'azmans_password', '4385096383', 'azman@concordia.ca'),
  ('Job Seeker', 'john_purcell', 'johns_password', '4385015383', 'john@concordia.ca'),
  ('Administrator', 'admin_dunya', 'dunyas_password', '6385016384', 'dunyaoguz13@gmail.com'),
  ('Administrator', 'admin_azman', 'azmans_password', '4385096384', 'azman2@concordia.ca'),
  ('Administrator', 'admin_john', 'johns_password', '4385015384', 'john2@concordia.ca');

INSERT INTO memberships (user_type, membership_type, monthly_fee, job_posting_limit, job_application_limit) VALUES
  ('Employer', 'Prime', 50, 5, 0),
  ('Employer', 'Gold', 100, NULL, 0),
  ('Job Seeker', 'Basic', 0, 0, 0),
  ('Job Seeker', 'Prime', 10, 0, 5),
  ('Job Seeker', 'Gold', 20, 0, NULL);

UPDATE users SET status = 'Deactivated' where login_name = 'john_purcell';

INSERT INTO transactions (account_id, transaction_type, amount) VALUES
  (1, 'Charge', -100),
  (2, 'Charge', -50),
  (3, 'Charge', -50),
  (7, 'Charge', -20),
  (8, 'Charge', -10),
  (9, 'Charge', -10);

INSERT INTO transactions (account_id, transaction_type, amount) VALUES
  (1, 'Payment', 200),
  (2, 'Payment', 10),
  (3, 'Payment', 30),
  (7, 'Payment', 27),
  (8, 'Payment', 13),
  (9, 'Payment', 8);

INSERT INTO payment_methods (account_id, payment_method_type, billing_address, postal_code,
                              card_number, security_code, expiration_month, expiration_year, withdrawal_method) VALUES
  (1, 'Credit', '60 Rue de Bresoles', 'H2Y 1V5', '001836352043266', 677, 09, 2023, 'Manual'),
  (1, 'Credit', '60 Rue de Bresoles', 'H2Y 1V5', '201836352043266', 678, 08, 2025, 'Automatic'),
  (2, 'Debit', '1467 Saint Denis Street', 'H2X 3J5', '356799032150000', 098, 12, 2025, 'Manual'),
  (2, 'Debit', '1467 Saint Denis Street', 'H2X 3J5', '456799032150000', 890, 12, 2024, 'Automatic'),
  (3, 'Credit', '2066 Jeanne Mance St', 'H2X 2J5', '9871234099654399', 123, 01, 2022, 'Manual'),
  (3, 'Debit', '2066 Jeanne Mance St', 'H2X 2J5', '9971234099654399', 131, 05, 2025, 'Automatic'),
  (6, 'Debit', '87 Atwater Avenue', 'H3H 1B5', '997659811304114', 591, 04, 2030, 'Manual'),
  (6, 'Debit', '87 Atwater Avenue', 'H3H 1B5', '997659811304223', 593, 05, 2031, 'Automatic'),
  (7, 'Credit', '1212 Avenue Des Pins', 'H2W 1S6', '766665098121243', 432, 10, 2022, 'Manual'),
  (7, 'Credit', '1212 Avenue Des Pins', 'H2W 1S6', '767665098121243', 432, 10, 2023, 'Automatic'),
  (8, 'Debit', '3665 Rue de Bullion', 'H2X 3A6', '8888076542187610', 404, 07, 2023, 'Manual'),
  (8, 'Credit', '3665 Rue de Bullion', 'H2X 3A6', '9998076542187610', 454, 09, 2024, 'Automatic'),
  (1, 'Credit', '890 Rue Saint Paul', 'H2X 285', '9871234099644399', 125, 08, 2023, 'Manual'),
  (2, 'Debit', '890 Rue Saint Paul', 'H2X 285', '9971234099908399', 135, 06, 2026, 'Automatic'),
  (3, 'Credit', '80 Lasalle Boul', 'H2X 987', '2221234099644399', 908, 05, 2023, 'Manual'),
  (6, 'Debit', '80 Lasalle Boul', 'H6X 907', '9861234099768399', 765, 04, 2026, 'Automatic'),
  (7, 'Credit', '87 Saint Laurent St', 'H29 987', '3331234099544399', 999, 05, 2022, 'Manual'),
  (8, 'Debit', '87 Saint Laurent St', 'H24 907', '9081234099768399', 777, 08, 2022, 'Automatic');

UPDATE payment_methods SET postal_code = 'H2Y 8PO' WHERE account_id = 5;

INSERT INTO employers (user_id, membership_id, name) VALUES
  (1, 2, 'Spotify'),
  (2, 1, 'Renorun'),
  (3, 1, 'Busbud');

INSERT INTO recruiters (user_id, employer_id, first_name, last_name) VALUES
  (4, 1, 'Ally', 'Giordino'),
  (5, 2, 'Karen', 'Banahora'),
  (6, 3, 'Emily', 'Tetzal');

INSERT INTO jobs (employer_id, recruiter_id, title, description, city, province, country, required_experience) VALUES
  (1, 1, 'Software Engineer', 'This is the best job ever.', 'Montreal', 'QC', 'Canada', 2),
  (2, 2, 'Data Scientist', 'This job is fun.', 'Toronto', 'ON', 'Canada', 3),
  (3, 3, 'Engineering Manager', 'This job rocks!', 'New York City', 'New York', 'USA', 10),
  (1, 1, 'Marketing Manager', 'This is the best job ever.', 'Montreal', 'QC', 'Canada', 10),
  (2, 2, 'Performance Marketing Analyst', 'This job is fun.', 'Toronto', 'ON', 'Canada', 1),
  (3, 3, 'FP&A Analyst', 'This job rocks!', 'New York City', 'New York', 'USA', 1),
  (1, 1, 'Marketing Director', 'This is the best job ever.', 'Montreal', 'QC', 'Canada', 10),
  (2, 2, 'Sales Director', 'This job is fun.', 'Toronto', 'ON', 'Canada', 15),
  (3, 3, 'Human Resources Coordinator', 'This job rocks!', 'New York City', 'New York', 'USA', 1);

INSERT INTO job_categories (job_id, job_category) VALUES
(2, 'Data'),
(2, 'Analytics'),
(1, 'Software Engineering'),
(2, 'Software Engineering'),
(3, 'Software Engineering'),
(1, 'Information Technology'),
(2, 'Information Technology'),
(3, 'Information Technology'),
(3, 'Management'),
(4, 'Management'),
(4, 'Marketing'),
(5, 'Marketing'),
(7, 'Marketing'),
(5, 'Analytics'),
(6, 'Analytics'),
(6, 'Finance'),
(8, 'Sales'),
(9, 'Human Resources');

INSERT INTO job_seekers (user_id, membership_id, first_name, last_name, city, province, country, current_title, years_of_experience) VALUES
  (7, 3, 'Dunya', 'Oguz', 'Montreal', 'QC', 'Canada', 'Analytics Engineer', 4),
  (8, 4, 'Azman', 'Ahkter', 'Toronto', 'ON', 'Canada', 'Software Engineer', 1),
  (9, 5, 'John', 'Purcell', 'Hallifax', 'Nova Scotia', 'Canada', 'Software Engineer', 0);

INSERT INTO job_seeker_education_history (job_seeker_id, education_type, school, concentration, grade, year_graduated) VALUES
  (1, 'Diploma', 'Concordia University', 'Computer Science', 3.8, 2022),
  (2, 'Diploma', 'Concordia University', 'Computer Science', 3.5, 2021),
  (3, 'Diploma', 'Concordia University', 'Computer Science', 3.1, 2021);

INSERT INTO applications (job_seeker_id, job_id) VALUES
  (1, 1),
  (2, 3),
  (2, 9),
  (3, 2),
  (3, 3);

UPDATE applications SET status = 'Accepted' WHERE job_seeker_id = 1 AND job_id = 1;
UPDATE applications SET status = 'Offered' WHERE job_seeker_id = 2 AND job_id = 9;
UPDATE jobs SET status = 'Closed' WHERE id = 1;
