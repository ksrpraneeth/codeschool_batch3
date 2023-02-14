CREATE DATABASE other_bills_task;


-- Tables
-- ========= Tables ===========
-- || 1. HOA's                ||
-- || 2. Form Numbers         ||
-- || 3. Form Types           ||
-- || 4. Form Type HOA Map    ||
-- || 5. DDO's                ||
-- || 6. IFSC's               ||
-- || 7. Agencies             ||
-- || 8. Bill's               ||
-- || 9. Bill Details         ||
-- =============================



-- TABLES DESIGN
{
    -- HOA Table
    CREATE TABLE IF NOT EXISTS hoas
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        hoa VARCHAR(255) NOT NULL UNIQUE,
        mjh VARCHAR(255) NOT NULL,
        mjh_desc VARCHAR(255) NOT NULL,
        smjh VARCHAR(255) NOT NULL,
        smjh_desc VARCHAR(255) NOT NULL,
        mih VARCHAR(255) NOT NULL,
        mih_desc VARCHAR(255) NOT NULL,
        gsh VARCHAR(255) NOT NULL,
        gsh_desc VARCHAR(255) NOT NULL,
        sh VARCHAR(255) NOT NULL,
        sh_desc VARCHAR(255) NOT NULL,
        dh VARCHAR(255) NOT NULL,
        dh_desc VARCHAR(255) NOT NULL,
        sdh VARCHAR(255) NOT NULL,
        sdh_desc VARCHAR(255) NOT NULL,
    );

    -- Form Numbers Table
    CREATE TABLE IF NOT EXISTS form_numbers
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        form_number VARCHAR(255) NOT NULL UNIQUE
    );

    -- Form Types Table
    CREATE TABLE IF NOT EXISTS form_types
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        form_type VARCHAR(255) NOT NULL UNIQUE,
        form_number_id INTEGER REFERENCES form_numbers(id) NOT NULL
    );

    -- Form Type HOA map Table
    CREATE TABLE IF NOT EXISTS form_type_hoa_map
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        form_type_id INTEGER REFERENCES form_types(id) NOT NULL,
        hoa_id INTEGER REFERENCES hoas(id) NOT NULL UNIQUE
    )

    -- DDO Table
    CREATE TABLE IF NOT EXISTS ddos
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        ddo_code VARCHAR(255) UNIQUE NOT NULL,
        designation VARCHAR(255) NOT NULL,
        office_name VARCHAR(255) NOT NULL,
        bank_branch_code VARCHAR(255) NOT NULL,
        bank_branch_name VARCHAR(2555) NOT NULL,
    )

    -- IFSC Codes Table
    CREATE TABLE IF NOT EXISTS ifsc_codes
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        ifsc_code VARCHAR(11) NOT NULL UNIQUE,
        bank_name VARCHAR(255) NOT NULL,
        branch VARCHAR(255) NOT NULL,
    )

    -- Agency Table
    CREATE TABLE IF NOT EXISTS agencies
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        agency_name VARCHAR(255) NOT NULL,
        account_no VARCHAR(255) NOT NULL UNIQUE,
        gst_no VARCHAR(255) NULL,
        ifsc_code VARCHAR(11) NOT NULL REFERENCES ifsc_codes(ifsc_code),
        -- ddo_id INTEGER REFERENCES ddos(id)
    )

    -- Bill Table
    CREATE TABLE IF NOT EXISTS transactions
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        form_type_id INTEGER REFERENCES form_types(id),
        hoa INTEGER REFERENCES hoas(hoa),
        reference_number VARCHAR(255) NOT NULL,
        purpose VARCHAR(255) NOT NULL,
        ddo_code INTEGER REFERENCES ddos(ddo_code),
        gross BIGINT NOT NULL,
        pt BIGINT NOT NULL DEFAULT 0,
        tds BIGINT NOT NULL DEFAULT 0,
        gst BIGINT NOT NULL DEFAULT 0,
        git BIGINT NOT NULL DEFAULT 0, 
        tshn BIGINT NOT NULL DEFAULT 0,
        net BIGINT NOT NULL,
        date_of_bill DATE NOT NULL,
        tbr_no VARCHAR(255) NOT NULL
    )

    -- Bill Details Table
    CREATE TABLE IF NOT EXISTS bill_multiple_parties
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        bill_id INTEGER REFERENCES bills(id) NOT NULL,
        agency_account_number INTEGER REFERENCES agencies(account_no) NOT NULL,
        agency_name VARCHAR(255) NOT NULL,
        agency_gst_no VARCHAR(255),
        agency_ifsc_code VARCHAR(11) NOT NULL,
        gross BIGINT NOT NULL DEFAULT 0,
        pt BIGINT NOT NULL DEFAULT 0,
        tds BIGINT NOT NULL DEFAULT 0,
        gst BIGINT NOT NULL DEFAULT 0,
        gis BIGINT NOT NULL DEFAULT 0,
        net BIGINT NOT NULL DEFAULT 0,
    )

    -- Bill Details Attachments Table
    CREATE TABLE IF NOT EXISTS bill_attachments
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        bill_id INTEGER REFERENCES bill_details(id) NOT NULL,
        attachment_file_path VARCHAR(255) NOT NULL,
    );

    -- Scrutiny Items Table
    CREATE TABLE IF NOT EXISTS scrutiny_items
    (
        id INTEGER GENERATED ALWAYS AS IDENTITY,
        form_type_id INTEGER REFERENCES form_types(id),
        scrutiny_desc VARCHAR(255) NOT NULL
    )
}