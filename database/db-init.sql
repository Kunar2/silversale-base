CREATE SCHEMA IF NOT EXISTS silversale;

SET search_path TO silversale;

-- DROP TABLE IF EXISTS order_item;
-- DROP TABLE IF EXISTS cart_item;
-- DROP TABLE IF EXISTS favourite;
-- DROP TABLE IF EXISTS image;
-- DROP TABLE IF EXISTS session;
-- DROP TABLE IF EXISTS order_main;
-- DROP TABLE IF EXISTS order_placed;
-- DROP TABLE IF EXISTS cart;
-- DROP TABLE IF EXISTS inventory;
-- DROP TABLE IF EXISTS item;
-- DROP TABLE IF EXISTS category;
-- DROP TABLE IF EXISTS users;
-- DROP TABLE IF EXISTS user_address;
-- DROP TABLE IF EXISTS order_address;
-- DROP TABLE IF EXISTS address;
DROP TABLE IF EXISTS query;

CREATE TABLE IF NOT exists users (
  user_id SERIAL PRIMARY KEY,
  username text,
  password text,
  email text UNIQUE,
  role text
);

CREATE TABLE IF NOT exists user_address (
  address_id SERIAL PRIMARY KEY,
  user_id integer references users(user_id),
  recipient_name text,
  recipient_phone text,
  country text,
  city text,
  address_line_1 text,
  address_line_2 text,
  postal_code text,
  autofill boolean
);

CREATE TABLE IF NOT exists category (
  category_id SERIAL PRIMARY KEY,
  name text UNIQUE
);

CREATE TABLE IF NOT exists item (
  item_id SERIAL PRIMARY KEY,
  name text UNIQUE,
  manufacturer text,
  description text,
  gender text,
  category_id integer references category(category_id),
  price float,
  sale_price float,
  reviews integer,
  rating float,
  image text,
  listed boolean
);

CREATE TABLE IF NOT exists inventory (
  unit_id SERIAL PRIMARY KEY,
  item_id integer references item(item_id),
  size text,
  quantity integer
);

CREATE TABLE IF NOT exists session (
  session_id text PRIMARY KEY,
  user_id integer references users(user_id)
);

CREATE TABLE IF NOT exists favourite (
  user_id integer references users(user_id),
  item_id integer references item(item_id),
  PRIMARY KEY (user_id, item_id)
);

CREATE TABLE IF NOT exists cart (
  cart_id SERIAL PRIMARY KEY,
  user_id integer references users(user_id)
);

CREATE TABLE IF NOT exists cart_item (
  cart_id integer references cart(cart_id),
  unit_id integer references inventory(unit_id),
  quantity integer,
  PRIMARY KEY (cart_id, unit_id)
);

CREATE TABLE IF NOT exists order_address (
  address_id SERIAL PRIMARY KEY,
  order_id integer,
  recipient_name text,
  recipient_phone text,
  country text,
  city text,
  address_line_1 text,
  address_line_2 text,
  postal_code text
);

CREATE TABLE IF NOT exists order_main (
  order_id SERIAL PRIMARY KEY,
  user_id integer references users(user_id),
  address integer references order_address(address_id),
  status text,
  total_price float,
  shipping_agent text,
  waybill_number text,
  estimated_delivery date,
  date_ordered timestamp,
  delivered_at timestamp
);

CREATE TABLE IF NOT exists order_item (
  order_id integer references order_main(order_id),
  unit_id integer references inventory(unit_id),
  quantity integer,
  unit_price float,
  PRIMARY KEY (order_id, unit_id)
);

CREATE TABLE IF NOT exists query (
  query_id SERIAL PRIMARY KEY,
  user_email text,
  category text,
  message text,
  date timestamp
);