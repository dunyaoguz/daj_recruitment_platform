DROP DATABASE IF EXISTS recruitment_platform;
CREATE DATABASE recruitment_platform;
USE recruitment_platform;

DROP TRIGGER IF EXISTS users_insert_trigger;
DROP TRIGGER IF EXISTS users_update_trigger;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS payment_methods;
DROP TABLE IF EXISTS accounts;
DROP TRIGGER IF EXISTS accounts_update_trigger;
DROP PROCEDURE IF EXISTS check_account_balance;
DROP PROCEDURE IF EXISTS accounts_loop;
DROP EVENT IF EXISTS accounts_loop_schedule;
DROP TRIGGER IF EXISTS transactions_insert_trigger;
DROP TRIGGER IF EXISTS payment_methods_insert_trigger;
DROP TRIGGER IF EXISTS payment_methods_update_trigger;
DROP TABLE IF EXISTS job_categories;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS recruiters;
DROP TABLE IF EXISTS employers;
DROP TABLE IF EXISTS job_seeker_education_history;
DROP TABLE IF EXISTS job_seekers;
DROP TABLE IF EXISTS memberships;
DROP TRIGGER IF EXISTS jobs_insert_trigger;
DROP TRIGGER IF EXISTS jobs_update_trigger;
DROP TABLE IF EXISTS users;
DROP TRIGGER IF EXISTS applications_insert_trigger;
DROP TRIGGER IF EXISTS applications_update_trigger;
DROP TABLE IF EXISTS system_logs;
DROP TABLE IF EXISTS emails;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_registered DATETIME DEFAULT NOW(),
  user_type ENUM('Employer', 'Recruiter', 'Job Seeker', 'Administrator') NOT NULL,
  login_name VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(256) NOT NULL,
  phone VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(256) NOT NULL UNIQUE,
  status ENUM('Active', 'Frozen', 'Deactivated') DEFAULT 'Active'
);
CREATE TRIGGER users_insert_trigger AFTER INSERT
  ON users FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value)
    VALUES ('users', 'new user was created', JSON_OBJECT("user_type", NEW.user_type,
                                                         "login_name", NEW.login_name,
                                                         "email", NEW.email));
    -- creation of a user automatically creates an account
    INSERT INTO accounts(user_id) VALUES (NEW.id);
    END;
CREATE TRIGGER users_update_trigger BEFORE UPDATE
  ON users FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value, old_value)
    VALUES ('users', 'user information was updated', JSON_OBJECT("user_type", NEW.user_type,
                                                                 "login_name", NEW.login_name,
                                                                 "phone", NEW.phone,
                                                                 "email", NEW.email,
                                                                 "status", NEW.status),
                                                     JSON_OBJECT("user_type", OLD.user_type,
                                                                 "login_name", OLD.login_name,
                                                                 "phone", OLD.phone,
                                                                 "email", OLD.email,
                                                                 "status", OLD.status));
    END;

CREATE TABLE memberships (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_type ENUM('Employer', 'Job Seeker') NOT NULL,
  membership_type ENUM('Basic', 'Prime', 'Gold') NOT NULL,
  monthly_fee INT NOT NULL,
  job_posting_limit INT,
  job_application_limit INT
);

CREATE TABLE accounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  balance FLOAT(7, 2) DEFAULT 0,
  FOREIGN KEY (user_id)
    REFERENCES users(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);
CREATE TRIGGER accounts_update_trigger BEFORE UPDATE
  ON accounts FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value, old_value)
    VALUES ('accounts', 'account balance was updated', JSON_OBJECT("balance", NEW.balance), JSON_OBJECT("balance", OLD.balance));
    END;
-- This stored procedure checks to see if a given account id has a negative balance and if so, sends an email to the user
CREATE PROCEDURE check_account_balance(account_id INT)
BEGIN
  SET @balance = (SELECT balance FROM accounts WHERE id = account_id);
  IF @balance < 0 THEN
  	SET @body = CONCAT('You have a negative balance of: ', @balance, '$. Please pay immediately!');
    -- send email
    INSERT INTO emails (to_email, from_email, subject, body)
    VALUES ((SELECT email
             FROM users
             WHERE id = (SELECT user_id FROM accounts WHERE id = account_id)),
             'admin@dajrecruitment.ca', 'IMPORTANT: You have a negative balance.',
             @body);
    -- Frreze user
    UPDATE users SET status = 'Frozen' WHERE id = (SELECT user_id FROM accounts WHERE id = account_id);
    -- Deactivate user if they havent paid in more than 356 days
    SET @last_transaction = (SELECT MAX(transaction_date) FROM transactions WHERE account_id = account_id);
	  SET @diff = DATEDIFF(NOW(), @last_transaction);
    IF @diff > 356 THEN
      UPDATE users SET status = 'Deactivated' WHERE id = (SELECT user_id FROM accounts WHERE id = account_id);
	  END IF;
  END IF;
END;
-- This procedure loops over accounts table and checks balance
CREATE PROCEDURE accounts_loop()
BEGIN
SET @max = (SELECT max(id) FROM accounts);
SET @min = (SELECT min(id) FROM accounts);
WHILE @min<@max DO
  IF @min IN (SELECT id FROM accounts) AND (SELECT status FROM users WHERE id = (SELECT user_id FROM accounts WHERE id = @min)) != 'Deactivated' THEN
    CALL check_account_balance(@min);
  END IF;
  SET @min = @min + 1;
END WHILE;
END;
-- This event schedules accounts loop to run every 12 hours
CREATE EVENT accounts_loop_schedule
  ON SCHEDULE EVERY 12 HOUR
  STARTS '2021-08-14 00:00:00'
  ENDS '2021-08-17 00:00:00'
  ON COMPLETION NOT PRESERVE ENABLE
DO
  CALL accounts_loop();

CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  account_id INT NOT NULL,
  transaction_date DATETIME DEFAULT NOW(),
  transaction_type ENUM('Payment', 'Charge') NOT NULL,
  -- negative if its a charge, positive if its a payment
  amount FLOAT(7, 2) NOT NULL,
  FOREIGN KEY (account_id)
    REFERENCES accounts(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);
CREATE TRIGGER transactions_insert_trigger AFTER INSERT
  ON transactions FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value)
    VALUES ('transactions', 'new transaction was recorded', JSON_OBJECT("transaction_date", NEW.transaction_date,
                                                                        "transaction_type", NEW.transaction_type,
                                                                        "amount", NEW.amount));
    -- Following trigger updates the balance attribute in the accounts table
    UPDATE accounts SET balance = balance + NEW.amount WHERE id = NEW.account_id;
    -- Following trigger sends emails when there is a charge on the account
    IF NEW.transaction_type = 'Charge' THEN
      SET @balance = (SELECT balance FROM accounts WHERE id = NEW.account_id);
      SET @body = CONCAT('The following charge was made to your account: ', NEW.amount, '$. Your new account balance is: ', @balance, '$.');
      INSERT INTO emails (to_email, from_email, subject, body)
      VALUES ((SELECT email
               FROM users
               WHERE id = (SELECT user_id FROM accounts WHERE id = NEW.account_id)),
               'admin@dajrecruitment.ca', 'New charge on your DAJ Recruitment account',
               @body);
    END IF;
    END;

CREATE TABLE payment_methods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  account_id INT NOT NULL,
  payment_method_type ENUM('Credit', 'Debit') NOT NULL,
  billing_address VARCHAR(256) NOT NULL,
  postal_code VARCHAR(20) NOT NULL,
  card_number VARCHAR(20) NOT NULL UNIQUE CONSTRAINT CHECK (LENGTH(card_number) BETWEEN 15 AND 16),
  security_code SMALLINT(3) ZEROFILL NOT NULL,
  expiration_month TINYINT(2) ZEROFILL NOT NULL,
  expiration_year SMALLINT NOT NULL CONSTRAINT CHECK (LENGTH(expiration_year)=4),
  withdrawal_method ENUM('Manual', 'Automatic') DEFAULT 'Manual',
  is_active BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (account_id)
    REFERENCES accounts(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);
CREATE TRIGGER payment_methods_insert_trigger AFTER INSERT
  ON payment_methods FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value)
    VALUES ('payment_methods', 'new payment method was added', JSON_OBJECT("account_id", NEW.account_id,
                                                                           "payment_method_type", NEW.payment_method_type,
                                                                           "withdrawal_method", NEW.withdrawal_method));
    END;
CREATE TRIGGER payment_methods_update_trigger BEFORE UPDATE
  ON payment_methods FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value, old_value)
    VALUES ('payment_methods', 'payment method was updated', JSON_OBJECT("account_id", NEW.account_id,
                                                                         "payment_method_type", NEW.payment_method_type,
                                                                         "billing_address", NEW.billing_address,
                                                                         "postal_code", NEW.postal_code,
                                                                         "withdrawal_method", NEW.withdrawal_method,
                                                                         "is_active", NEW.is_active),
                                                            JSON_OBJECT("account_id", OLD.account_id,
                                                                        "payment_method_type", OLD.payment_method_type,
                                                                        "billing_address", OLD.billing_address,
                                                                        "postal_code", OLD.postal_code,
                                                                        "withdrawal_method", OLD.withdrawal_method,
                                                                        "is_active", OLD.is_active));
    END;

CREATE TABLE employers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  membership_id INT,
  name VARCHAR(50) NOT NULL,
  FOREIGN KEY (membership_id)
    REFERENCES memberships(id)
      ON UPDATE CASCADE
      ON DELETE SET NULL,
  FOREIGN KEY (user_id)
    REFERENCES users(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

CREATE TABLE recruiters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  employer_id INT NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  FOREIGN KEY (employer_id)
    REFERENCES employers(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
  FOREIGN KEY (user_id)
    REFERENCES users(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

CREATE TABLE jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employer_id INT NOT NULL,
  recruiter_id INT NOT NULL,
  date_posted DATETIME DEFAULT NOW(),
  title VARCHAR(100) NOT NULL,
  description VARCHAR(256) NOT NULL,
  required_experience INT,
  status ENUM('Open', 'Closed') DEFAULT 'Open',
  city VARCHAR(50) NOT NULL,
  province VARCHAR(50) NOT NULL,
  country VARCHAR(50) NOT NULL,
  is_remote_eligible BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (employer_id)
    REFERENCES employers(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
  FOREIGN KEY (recruiter_id)
    REFERENCES recruiters(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);
CREATE TRIGGER jobs_insert_trigger AFTER INSERT
  ON jobs FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value)
    VALUES ('jobs', 'new job was posted', JSON_OBJECT("title", NEW.title,
                                                      "description", NEW.description,
                                                      "city", NEW.city,
                                                      "province", NEW.province,
                                                      "country", NEW.country,
                                                      "is_remote_eligible", NEW.is_remote_eligible));
    END;
CREATE TRIGGER jobs_update_trigger BEFORE UPDATE
  ON jobs FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value, old_value)
    VALUES ('jobs', 'job was updated', JSON_OBJECT("title", NEW.title,
                                                   "description", NEW.description,
                                                   "is_remote_eligible", NEW.is_remote_eligible,
                                                   "status", NEW.status),
                                       JSON_OBJECT("title", OLD.title,
                                                   "description", OLD.description,
                                                   "is_remote_eligible", OLD.is_remote_eligible,
                                                   "status", OLD.status));
    END;

CREATE TABLE job_categories (
  job_id INT NOT NULL,
  job_category VARCHAR(256) NOT NULL,
  FOREIGN KEY (job_id)
    REFERENCES jobs(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
  PRIMARY KEY (job_id, job_category)
);

CREATE TABLE job_seekers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  membership_id INT,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  current_title VARCHAR(100),
  years_of_experience INT,
  city VARCHAR(50) NOT NULL,
  province VARCHAR(50) NOT NULL,
  country VARCHAR(50) NOT NULL,
  FOREIGN KEY (membership_id)
    REFERENCES memberships(id)
      ON UPDATE CASCADE
      ON DELETE SET NULL,
  FOREIGN KEY (user_id)
    REFERENCES users(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

CREATE TABLE job_seeker_education_history (
  job_seeker_id INT NOT NULL,
  education_type ENUM('High School', 'Bachelors', 'Masters', 'PhD', 'Certificate', 'Diploma') NOT NULL,
  school VARCHAR(100) NOT NULL,
  concentration VARCHAR(100) NOT NULL,
  grade FLOAT(3, 2),
  year_graduated SMALLINT NOT NULL CONSTRAINT CHECK (LENGTH(year_graduated)=4),
  FOREIGN KEY (job_seeker_id)
    REFERENCES job_seekers(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
  PRIMARY KEY (job_seeker_id, education_type)
);

CREATE TABLE applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_seeker_id INT NOT NULL,
  job_id INT NOT NULL,
  date_applied DATETIME DEFAULT NOW(),
  status ENUM('Submitted', 'Withdrawn', 'Recruiter Rejected', 'Offered', 'Accepted', 'Applicant Rejected') NOT NULL DEFAULT 'Submitted',
  FOREIGN KEY (job_seeker_id)
    REFERENCES job_seekers(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
  FOREIGN KEY (job_id)
    REFERENCES jobs(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
  UNIQUE (job_id, job_seeker_id)
);
CREATE TRIGGER applications_insert_trigger AFTER INSERT
  ON applications FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value)
    VALUES ('applications', 'new application was made', JSON_OBJECT("job_seeker_id", NEW.job_seeker_id,
                                                                    "job_id", NEW.job_id));
    END;
CREATE TRIGGER applications_update_trigger BEFORE UPDATE
  ON applications FOR EACH ROW
    BEGIN
    INSERT INTO system_logs (table_name, activity, new_value, old_value)
    VALUES ('applications', 'application status changed', JSON_OBJECT("job_seeker_id", NEW.job_seeker_id,
                                                                      "job_id", NEW.job_id,
                                                                      "status", NEW.status),
                                                          JSON_OBJECT("job_seeker_id", OLD.job_seeker_id,
                                                                      "job_id", OLD.job_id,
                                                                      "status", OLD.status));
    END;

CREATE TABLE system_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  activity_date DATETIME DEFAULT NOW(),
  table_name VARCHAR(50) NOT NULL,
  activity VARCHAR(50) NOT NULL,
  old_value JSON,
  new_value JSON
);

CREATE TABLE emails (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sent_date DATETIME DEFAULT NOW(),
  to_email VARCHAR(256) NOT NULL,
  from_email VARCHAR(256) NOT NULL,
  subject VARCHAR(256) NOT NULL,
  body VARCHAR(256) NOT NULL
);
