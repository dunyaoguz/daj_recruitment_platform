CREATE DATABASE recruitment_platform;

CREATE TABLE membership_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_type ENUM('Employer', 'Job Seeker') NOT NULL,
  membership_type ENUM('Basic', 'Prime', 'Gold') NOT NULL,
  monthly_fee INT NOT NULL,
  job_posting_limit INT,
  job_application_limit INT
);

CREATE TABLE accounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  transaction_date DATETIME DEFAULT NOW(),
  amount FLOAT(7, 5) NOT NULL,
  balance FLOAT(7, 5) NOT NULL
);

CREATE TABLE payment_methods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  account_id INT NOT NULL,
  payment_method_type ENUM('Credit', 'Debit') NOT NULL,
  billing_address VARCHAR(256) NOT NULL,
  postal_code VARCHAR(20) NOT NULL,
  card_number INT NOT NULL CONSTRAINT CHECK (LENGTH(card_number) BETWEEN 15 AND 16),
  security_code TINYINT NOT NULL CONSTRAINT CHECK (LENGTH(security_code)=3),
  expiration_month TINYINT NOT NULL CONSTRAINT CHECK (LENGTH(expiration_month)=2),
  expiration_year SMALLINT NOT NULL CONSTRAINT CHECK (LENGTH(expiration_year)=4),
  withdrawal_method ENUM('Manual', 'Automatic') DEFAULT 'Manual',
  is_active BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (account_id)
    REFERENCES accounts(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

CREATE TABLE employers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  membership_type_id INT NOT NULL,
  account_id INT NOT NULL,
  name VARCHAR(50) NOT NULL,
  date_registered DATETIME DEFAULT NOW(),
  login_name VARCHAR(100) NOT NULL,
  password VARCHAR(256) NOT NULL,
  FOREIGN KEY (membership_type_id)
    REFERENCES membership_types(id)
      ON UPDATE CASCADE,
  FOREIGN KEY (account_id)
    REFERENCES accounts(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

CREATE TABLE recruiters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employer_id INT NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  date_registered DATETIME DEFAULT NOW(),
  login_name VARCHAR(100) NOT NULL,
  password VARCHAR(256) NOT NULL,
  phone_number VARCHAR(50) NOT NULL,
  email VARCHAR(256) NOT NULL,
  FOREIGN KEY (employer_id)
    REFERENCES employers(id)
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
  required_experience INT NOT NULL,
  status ENUM('Open', 'Closed') DEFAULT 'Open',
  category -- TO COMPLETE
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
);

CREATE TABLE job_seekers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  membership_type_id INT NOT NULL,
  account_id INT NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  date_registered DATETIME DEFAULT NOW(),
  login_name VARCHAR(100) NOT NULL,
  password VARCHAR(256) NOT NULL,
  current_title VARCHAR(100) NOT NULL,
  years_of_experience INT NOT NULL,
  phone_number VARCHAR(50) NOT NULL,
  email VARCHAR(256) NOT NULL,
  city VARCHAR(50) NOT NULL,
  province VARCHAR(50) NOT NULL,
  country VARCHAR(50) NOT NULL,
  status ENUM('Active', 'Deleted') DEFAULT 'Active',
  FOREIGN KEY (membership_type_id)
    REFERENCES membership_types(id)
      ON UPDATE CASCADE,
  FOREIGN KEY (account_id)
    REFERENCES accounts(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

CREATE TABLE job_seeker_education_history (
  job_seeker_id INT NOT NULL,
  education_type ENUM('High School', 'Bachelors', 'Masters', 'PhD', 'Certificate', 'Diploma') NOT NULL,
  school VARCHAR(100) NOT NULL,
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
  date_applied DATETIME DEFAULT NOW(),
  status ENUM('In Progress', 'Submitted', 'Withdrawn', 'Rejected', 'Offered', 'Accepted') NOT NULL,
  FOREIGN KEY (job_seeker_id)
    REFERENCES job_seekers(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

CREATE TABLE administrators (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  login_name VARCHAR(100) NOT NULL,
  password VARCHAR(256) NOT NULL
);
