create database boovent;
use boovent;

/*======================= 1. BOOVENT USER TABLE ==========================================*/
CREATE TABLE IF NOT EXISTS boovent_user(
boovent_user_id INT(10) AUTO_INCREMENT NOT NULL,
user_name VARCHAR(100) NOT NULL,
user_password VARCHAR(100) NOT NULL,
user_email VARCHAR(100) NOT NULL,
user_mobile VARCHAR(100),
user_profile_pic VARCHAR(250) ,
join_date DATETIME,
ipaddress VARCHAR(255) DEFAULT 'Fail to Fetch IP',
user_address VARCHAR(200),
user_zipcode INT(10) DEFAULT 0,
user_city VARCHAR(100),
user_state VARCHAR(100),
user_country VARCHAR(100),
total_events_buyied INT(5) DEFAULT 0,
total_event_created INT(2) DEFAULT 0,
login_count INT(5) DEFAULT 0,
email_activated enum('0','1') DEFAULT '0',
UNIQUE KEY (boovent_user_id),
PRIMARY KEY(user_email)
);

/*======================= 2. BOOVENT EVENT TABLE ==========================================*/
CREATE TABLE IF NOT EXISTS boovent_events(
boovent_event_id INT(10) AUTO_INCREMENT NOT NULL,
event_id VARCHAR(100) NOT NULL, 
user_email VARCHAR(150) NOT NULL, /* ORGANISER EMAIL*/
organizer_mobile VARCHAR(100) NOT NULL,
event_title VARCHAR(100) NOT NULL,
event_organization VARCHAR(100),
event_category VARCHAR(50) NOT NULL,
event_sub_category VARCHAR(50) NOT NULL,
event_create_date DATETIME,
event_start_date DATETIME,
event_end_date DATETIME,
ipaddress VARCHAR(255) DEFAULT 'Fail to Fetch IP',
event_description VARCHAR(60000) NOT NULL,
event_conditions VARCHAR(250) NOT NULL,
event_image VARCHAR(250) NOT NULL,
event_location VARCHAR(250) NOT NULL,
event_address VARCHAR(200) NOT NULL,
event_zipcode INT(10) NOT NULL,
event_city VARCHAR(100) NOT NULL,
event_state VARCHAR(100) NOT NULL,
event_country VARCHAR(100) NOT NULL,
event_website VARCHAR(100),
event_tags VARCHAR(500) NOT NULL,
event_button VARCHAR(100) NOT NULL DEFAULT 'Buy',
featured_event enum('Yes','No') DEFAULT 'No',
make_event_live enum('Not Live','Live','Expired') DEFAULT 'Not Live',
UNIQUE KEY (boovent_event_id),
PRIMARY KEY(event_id),
FOREIGN KEY (user_email) REFERENCES boovent_user(user_email) ON DELETE CASCADE
);

/*============================== 4. BOOVENT TICKET_CUSTOMIZATION TABLE =========================*/
CREATE TABLE IF NOT EXISTS boovent_ticket_manager (
    boovent_ticket_id INT(10) AUTO_INCREMENT NOT NULL,
    user_email VARCHAR(150) NOT NULL,
    event_id VARCHAR(100) NOT NULL,
    ticket_id VARCHAR(100) NOT NULL,
    ticket_name VARCHAR(150) NOT NULL,
    ticket_type VARCHAR(50) NOT NULL DEFAULT 'FREE',
    ticket_class VARCHAR(50) NOT NULL DEFAULT 'Not Required',
    ticket_price INT(5) NOT NULL DEFAULT 0,
    payment_bearing VARCHAR(100) NOT NULL,
    total_tickets_issued INT(10) NOT NULL DEFAULT 0,
    total_tickets_booked INT(10) NOT NULL DEFAULT 0,
    total_tickets_remaining INT(10) NOT NULL DEFAULT 0,
    UNIQUE KEY (boovent_ticket_id), 
    PRIMARY KEY (ticket_id),
    FOREIGN KEY (event_id) REFERENCES boovent_events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_email) REFERENCES boovent_user(user_email) ON DELETE CASCADE
);

/*========================== 6. BOOVENT TICKET_PURCHASE TABLE ===============================*/
CREATE TABLE IF NOT EXISTS boovent_purchase (
    boovent_purchase_id INT(10) AUTO_INCREMENT NOT NULL,
    order_id VARCHAR(200) NOT NULL,
    booking_id VARCHAR(100) NOT NULL,
    date_of_purchase DATETIME,
    user_email VARCHAR(150) NOT NULL,
    purchase_contact VARCHAR(10) NOT NULL,
    event_id VARCHAR(100) NOT NULL,
    ticket_id VARCHAR(100) NOT NULL,
    purchased_ticket_type VARCHAR(50) NOT NULL,
    purchased_ticket_bearing VARCHAR(50) NOT NULL,
    purchased_ticket_numbers VARCHAR(50) NOT NULL,
    purchase_quantity INT(10) NOT NULL DEFAULT 0,
    boovent_cost FLOAT NOT NULL,
    total_price FLOAT NOT NULL,
    customer_price_purchased FLOAT NOT NULL,
    UNIQUE KEY (boovent_purchase_id),   
    PRIMARY KEY (booking_id),
    FOREIGN KEY (ticket_id) REFERENCES boovent_ticket_manager(ticket_id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES boovent_events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_email) REFERENCES boovent_user(user_email) ON DELETE CASCADE   
);

/*============================ 7. ORGANIZER_BANK_DETAILS TABLE ===========================*/
CREATE TABLE IF NOT EXISTS organizer_bank_details (
    bank_detail_id INT(10) AUTO_INCREMENT NOT NULL,
    user_email VARCHAR(150) NOT NULL,
    account_holder_name VARCHAR(50) NOT NULL,
    bank_account_number INT(100) NOT NULL,
    bank_name VARCHAR(100) NOT NULL,
    ifsc_code VARCHAR(25) NOT NULL,
    account_type VARCHAR(20) NOT NULL,
    registered_gst_no VARCHAR(100) DEFAULT 'Not Present',
    PRIMARY KEY (bank_detail_id),
    FOREIGN KEY (user_email) REFERENCES boovent_user(user_email) ON DELETE CASCADE
);

/*======================= 8. BOOVENT INVOICE TABLE ==========================================*/
CREATE TABLE IF NOT EXISTS boovent_invoice(
boovent_invoice_id INT(10) AUTO_INCREMENT NOT NULL,
order_id VARCHAR(200) NOT NULL,
booking_id VARCHAR(100) NOT NULL,
payment_id VARCHAR(100) NOT NULL,
invoice_email VARCHAR(100) NOT NULL,
invoice_name VARCHAR(100) NOT NULL,
invoice_address VARCHAR(200) NOT NULL DEFAULT 'Not Mentioned',
invoice_create_date DATETIME,
event_name VARCHAR(100) NOT NULL,
event_location VARCHAR(100) NOT NULL,
quantity_puchased INT(5) NOT NULL,
total_price_paid FLOAT NOT NULL, 
PRIMARY KEY(boovent_invoice_id),
FOREIGN KEY (booking_id) REFERENCES boovent_purchase(booking_id) ON DELETE CASCADE,
FOREIGN KEY (invoice_email) REFERENCES boovent_user(user_email) ON DELETE CASCADE
);

/*======================= 9. BOOVENT TICKET TABLE ==========================================*/
CREATE TABLE IF NOT EXISTS boovent_ticket_format(
boovent_event_id INT(10) AUTO_INCREMENT NOT NULL,
order_id VARCHAR(200) NOT NULL,
event_ticket_send_date DATETIME,
user_name VARCHAR(100) NOT NULL,
user_email VARCHAR(200) NOT NULL,
user_mobile VARCHAR(200) NOT NULL,
ticket_id VARCHAR(100) NOT NULL,
event_ticket_type VARCHAR(100) NOT NULL,
event_name VARCHAR(100) NOT NULL,
event_ticket_name VARCHAR(100) NOT NULL,
event_ticket_address VARCHAR(100) NOT NULL,
event_ticket_date VARCHAR(100) NOT NULL,
event_ticket_quantity VARCHAR(100) NOT NULL,
event_ticket_numbers VARCHAR(100) NOT NULL,
event_ticket_total FLOAT NOT NULL,   
PRIMARY KEY(boovent_event_id),
FOREIGN KEY (ticket_id) REFERENCES boovent_ticket_manager(ticket_id) ON DELETE CASCADE
);

/*====================== 10. BOOVENT CONTACT TABLE ========================================*/
CREATE TABLE IF NOT EXISTS boovent_contact(
boovent_contact_id INT(10) AUTO_INCREMENT NOT NULL,
user_name VARCHAR(100) NOT NULL,
user_email VARCHAR(200) NOT NULL,
user_message VARCHAR(500) NOT NULL,
PRIMARY KEY(boovent_contact_id)
);

/*====================== 11. BOOVENT SUBSCRIPTION TABLE ========================================*/
CREATE TABLE IF NOT EXISTS boovent_subscription(
boovent_subscription_id INT(10) AUTO_INCREMENT NOT NULL,
create_date DATETIME,
user_ip VARCHAR(100) NOT NULL,
user_email VARCHAR(200) NOT NULL,
is_subscribed enum('0','1') NOT NULL DEFAULT '0',
PRIMARY KEY(boovent_subscription_id)
);