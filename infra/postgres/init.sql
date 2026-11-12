CREATE EXTENSION IF NOT EXISTS vector;
CREATE EXTENSION IF NOT EXISTS pg_trgm;
CREATE DATABASE umami OWNER mewe;
CREATE DATABASE twenty OWNER mewe;
CREATE DATABASE invoiceshelf OWNER mewe;
CREATE DATABASE chatwoot OWNER mewe;
CREATE DATABASE plane OWNER mewe;
CREATE DATABASE documenso OWNER mewe;
-- MeweMarket reads one table of Documenso's (new users' password-reset tokens): grant just that, after
-- Documenso's first start has created it. See docs/DEPLOY.md, "Hosted apps".
CREATE DATABASE openwebui OWNER mewe;
