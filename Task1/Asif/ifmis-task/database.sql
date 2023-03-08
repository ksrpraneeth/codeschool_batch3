CREATE DATABASE ifmis;


-- For Agency Details
CREATE TABLE bank_details(
    id SERIAL PRIMARY KEY,
    name VARCHAR(64),
    branch VARCHAR(64),
    state VARCHAR(64),
    ifsc_code VARCHAR(11) UNIQUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE agency_details(
    id SERIAL PRIMARY KEY,
    name VARCHAR(64),
    account_number VARCHAR(22) UNIQUE,
    ifsc_code INTEGER REFERENCES bank_details(ifsc_code),
    gst VARCHAR(15),
    pan VARCHAR(10),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);




-- For Bill Entries
CREATE TABLE forms(
    id SERIAL PRIMARY KEY,
    form_number INTEGER,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE form_types(
    id SERIAL PRIMARY KEY,
    form_number_id INTEGER REFERENCES forms(id),
    name VARCHAR(64),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE head_of_accounts(
    id SERIAL PRIMARY KEY,
    mjh VARCHAR(),
    mjh_desc VARCHAR(),
    smjh VARCHAR(),
    smjh_desc VARCHAR(),
    mih VARCHAR(),
    mih_desc VARCHAR(),
    gsh VARCHAR(),
    gsh_desc VARCHAR(),
    sh VARCHAR(),
    sh_desc VARCHAR(),
    dh VARCHAR(),
    dh_desc VARCHAR(),
    sdh VARCHAR(),
    sdh_desc VARCHAR(),
    hoa VARCHAR(),
    hoa_tier VARCHAR(),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE forms_head_of_accounts_master_table(
    id SERIAL PRIMARY KEY,
    form_type_id INTEGER REFERENCES form_types(id),
    head_of_account_id INTEGER REFERENCES head_of_accounts(id),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE transactions(
    id SERIAL PRIMARY KEY,
    form_type_name INTEGER REFERENCES form_types(name),
    total_amount VARCHAR(),
    pt VARCHAR(),
    tds VARCHAR(),
    gst VARCHAR(),
    gis VARCHAR(),
    thn VARCHAR(),
    total_deductions VARCHAR(),
    net_amount VARCHAR(),
    hoa INTEGER REFERENCES head_of_accounts(hoa),
    reference_number VARCHAR(),
    service_major_head VARCHAR(),
    purpose text(),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE multiple_party_bill_entries(
    id SERIAL PRIMARY KEY,
    transaction_id INTEGER REFERENCES transactions(id),
    name VARCHAR() REFERENCES agency_details(name),
    bank_name VARCHAR(),
    bank_branch VARCHAR(),
    ifsc_code VARCHAR() REFERENCES agency_details(ifsc_code),
    account_number VARCHAR() REFERENCES agency_details(account_number),
    gross_amount VARCHAR(),
    pt VARCHAR(),
    tds VARCHAR(),
    gst VARCHAR(),
    gis VARCHAR(),
    thn VARCHAR(),
    net_amount VARCHAR(),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE attachments(
    id SERIAL PRIMARY KEY,
    transaction_id INTEGER REFERENCES transactions(id),
    attachment_path VARCHAR(),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE ddos(
    id SERIAL PRIMARY KEY,
    code VARCHAR(),
    designation VARCHAR(),
    office_name VARCHAR(),
    branch_code VARCHAR(),
    branch_name VARCHAR(),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE scrutiny_items(
    id SERIAL PRIMARY KEY,
    description text(),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE transaction_scrutiny_items_mapping(
    id SERIAL PRIMARY KEY,
    transaction_id INTEGER REFERENCES transactions(id),
    scrutiny_item_id INTEGER REFERENCES scrutiny_items(id),
    status INTEGER,
    remarks text(),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);