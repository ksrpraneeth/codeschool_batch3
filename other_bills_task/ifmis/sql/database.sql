CREATE database ifmis;

//IFSC CODE

CREATE TABLE ifsc(
    id SERIAL PRIMARY KEY,
    ifcs_code VARCHAR(50),
    bank_name VARCHAR(100),
    state VARCHAR(50),
    branch VARCHAR(50)
    );

//AGENCY 

CREATE TABLE agency(
    id SERIAL PRIMARY KEY,
    ifsc_code_id int constraint fk_ifsc REFERENCES ifsc(id),
    name VARCHAR(100),
    account_number VARCHAR(100)
    );

//FORM NUMBER

CREATE TABLE form(
    id SERIAL PRIMARY KEY,
    form_number int(50)
    );

//FORM TYPE

CREATE TABLE form_type(
    id SERIAL PRIMARY KEY,
    form_number_id int constraint fk_form_number REFERENCES form_number(id),
    form_type varchar(255) unique
    );

//HOA

CREATE TABLE hoa(
    id SERIAL PRIMARY KEY,
    mjh int,
    mjh_desc VARCHAR(100),
    smjh int,
    smjh_desc VARCHAR(100),
    mih int,
    mih_desc VARCHAR(100),
    gsh int,
    gsh_desc VARCHAR(100),
    sh int,
    sh_desc VARCHAR(100),
    dh int,
    dh_desc VARCHAR(100),
    sdh int,
    sdh_desc VARCHAR(100),
    hoa VARCHAR(100)
    hoa_tier VARCHAR(100),
    );

//FORM TYPE and HOA mapping

CREATE TABLE form_hoa mapping(
    id SERIAL PRIMARY KEY,
    form_type_id int constraint fk_form_type REFERENCES form_type(id),
    hoa_id int constraint fk_hoa REFERENCES hoa(id),
);

//TRANSACTION

CREATE TABLE transaction(
    id SERIAL PRIMARY KEY,
    form_type int;
    hoa VARCHAR(20);
    gross_amount int,
    pt_dedn int,
    tds int,
    gst int,
    gis int,
    trn int,
    net_amount int
);

//ONE BILL CAN HAVE MANY AGENCIES(Eg materials bill can have stationery,paper etc agencies)

CREATE TABLE transaction_agency(
    id SERIAL PRIMARY KEY,
    bill_id int constraint fk_bills REFERENCES bills(id),
    hoa VARCHAR(20);
    agency_name VARCHAR(20);
    ifcs_code VARCHAR(20);
    gross_amount int,
    pt_dedn int,
    tds int,
    gst int,
    gis int,
    trn int,
    net_amount int
);

//ATTACHMENTS

CREATE TABLE attachments(
   id SERIAL PRIMARY KEY,
   file_path VARCHAR(250);
       bill_id int constraint fk_bills REFERENCES bills(id)
       );

//SCRUITNY ITEMS

CREATE TABLE scrutiny(
   id SERIAL PRIMARY KEY,
       form_type_id int constraint fk_form_type REFERENCES form_type(id),
       scrutiny_desc VARCHAR(255);
       );

//SCRUITNY ITEM QUESTIONS AND ANSWER

CREATE TABLE scrutiny_answers(
   id SERIAL PRIMARY KEY,
     bill_id int constraint fk_bill REFERENCES bill(id),
       question VARCHAR(255);
       answer VARCHAR(10);
       );