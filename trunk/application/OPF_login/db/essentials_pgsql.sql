SET check_function_bodies = false;

#bloq

SET search_path = public, pg_catalog;
CREATE SEQUENCE public.ess_bit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public."ess_bit" (
    id integer DEFAULT nextval('ess_bit_id_seq'::regclass) NOT NULL,
    ip character varying(50),
    url text,
    usuario_id integer,
    datetime timestamp(6) without time zone
);
ALTER TABLE ONLY public."ess_bit" ALTER COLUMN id SET STATISTICS 0;
ALTER TABLE ONLY public."ess_bit" ALTER COLUMN ip SET STATISTICS 0;
ALTER TABLE ONLY public."ess_bit" ALTER COLUMN url SET STATISTICS 0;
ALTER TABLE ONLY public."ess_bit" ALTER COLUMN usuario_id SET STATISTICS 0;
ALTER TABLE ONLY public."ess_bit" ALTER COLUMN datetime SET STATISTICS 0;

#bloq

CREATE SEQUENCE public.ess_master_tables_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public.ess_master_tables (
    id integer DEFAULT nextval('ess_master_tables_id_seq'::regclass) NOT NULL,
    name character varying(50),
    description text,
    user_id integer,
    datetime timestamp(6) without time zone
);
ALTER TABLE ONLY public.ess_master_tables ALTER COLUMN id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables ALTER COLUMN name SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables ALTER COLUMN description SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables ALTER COLUMN user_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables ALTER COLUMN datetime SET STATISTICS 0;

#bloq

CREATE SEQUENCE public.ess_master_tables_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public.ess_master_tables_detail (
    id integer DEFAULT nextval('ess_master_tables_detail_id_seq'::regclass) NOT NULL,
    master_tables_id integer,
    item_cod character varying(50),
    item_desc text,
    user_id integer,
    datetime timestamp(6) without time zone
);
ALTER TABLE ONLY public.ess_master_tables_detail ALTER COLUMN id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables_detail ALTER COLUMN master_tables_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables_detail ALTER COLUMN item_cod SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables_detail ALTER COLUMN item_desc SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables_detail ALTER COLUMN user_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_master_tables_detail ALTER COLUMN datetime SET STATISTICS 0;

#bloq

CREATE SEQUENCE public.ess_menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public.ess_menu (
    id integer DEFAULT nextval('ess_menu_id_seq'::regclass) NOT NULL,
    menu_id integer,
    description character varying(50),
    icon character varying(20),
    url text,
    ord smallint,
    usuario_id integer,
    datetime timestamp(6) without time zone
) WITHOUT OIDS;
ALTER TABLE ONLY public.ess_menu ALTER COLUMN id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_menu ALTER COLUMN menu_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_menu ALTER COLUMN description SET STATISTICS 0;
ALTER TABLE ONLY public.ess_menu ALTER COLUMN url SET STATISTICS 0;
ALTER TABLE ONLY public.ess_menu ALTER COLUMN ord SET STATISTICS 0;
ALTER TABLE ONLY public.ess_menu ALTER COLUMN usuario_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_menu ALTER COLUMN datetime SET STATISTICS 0;

#bloq

CREATE SEQUENCE public.ess_profiles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public.ess_profiles (
    id integer DEFAULT nextval('ess_profiles_id_seq'::regclass) NOT NULL,
    name character varying(50),
    description text,
    user_id integer,
    datetime timestamp(6) without time zone
);
ALTER TABLE ONLY public.ess_profiles ALTER COLUMN id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_profiles ALTER COLUMN name SET STATISTICS 0;
ALTER TABLE ONLY public.ess_profiles ALTER COLUMN description SET STATISTICS 0;
ALTER TABLE ONLY public.ess_profiles ALTER COLUMN user_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_profiles ALTER COLUMN datetime SET STATISTICS 0;

#bloq

CREATE SEQUENCE public.ess_profiles_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public.ess_profiles_detail (
    id integer DEFAULT nextval('ess_profiles_detail_id_seq'::regclass) NOT NULL,
    profiles_id integer,
    menu_id integer
) WITHOUT OIDS;
ALTER TABLE ONLY public.ess_profiles_detail ALTER COLUMN id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_profiles_detail ALTER COLUMN profiles_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_profiles_detail ALTER COLUMN menu_id SET STATISTICS 0;

#bloq

CREATE SEQUENCE public.ess_system_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public.ess_system_users (
    id integer DEFAULT nextval('ess_system_users_id_seq'::regclass) NOT NULL,
    user_name character varying(50),
    name character varying(50),
    lastname character varying(50),
    passwd character varying(150),
    status smallint,
    profile_id integer,
    datetime timestamp(6) without time zone
);
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN user_name SET STATISTICS 0;
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN name SET STATISTICS 0;
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN lastname SET STATISTICS 0;
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN passwd SET STATISTICS 0;
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN status SET STATISTICS 0;
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN profile_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_system_users ALTER COLUMN datetime SET STATISTICS 0;

#bloq

CREATE SEQUENCE public.ess_usronline_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

#bloq

CREATE TABLE public.ess_usronline (
    id integer DEFAULT nextval('ess_usronline_id_seq'::regclass) NOT NULL,
    usuario_id integer,
    ip character varying(50),
    sesname character varying(150),
    size integer,
    filectime time(10) without time zone,
    datetime timestamp(6) without time zone
);
ALTER TABLE ONLY public.ess_usronline ALTER COLUMN usuario_id SET STATISTICS 0;
ALTER TABLE ONLY public.ess_usronline ALTER COLUMN ip SET STATISTICS 0;
ALTER TABLE ONLY public.ess_usronline ALTER COLUMN sesname SET STATISTICS 0;
ALTER TABLE ONLY public.ess_usronline ALTER COLUMN size SET STATISTICS 0;
ALTER TABLE ONLY public.ess_usronline ALTER COLUMN filectime SET STATISTICS 0;
ALTER TABLE ONLY public.ess_usronline ALTER COLUMN datetime SET STATISTICS 0;

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (25, 24, 'Tablas sitema', 'img/page.gif', '../OPF_admTablas/', 1, 1, '2011-08-31 15:34:12');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (26, 24, 'Usuarios', 'img/page.gif', '../OPF_admUsr/', 2, 1, '2011-08-31 15:34:54');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (27, 24, 'Menu', 'img/page.gif', '../OPF_menu/', 3, 1, '2011-08-31 15:35:17');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (28, 24, 'Perfiles', 'img/page.gif', '../OPF_profiles/', 4, 1, '2011-08-31 15:35:49');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (29, NULL, 'Salir', 'img/page.gif', '../OPF_logout/', 100, 1, '2011-08-31 17:08:42');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (31, NULL, 'Cambiar clave', 'img/page.gif', '../OPF_passwd/', 99, 1, '2011-08-31 19:01:33');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (32, 24, 'Log de sucesos', 'img/page.gif', '../OPF_bit/', 5, 1, '2011-09-01 12:05:29');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (33, 24, 'Usuarios Online', 'img/page.gif', '../OPF_useronline/', 6, 1, '2011-09-21 23:26:53');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (34, 24, 'Andamiaje', 'img/page.gif', '../OPF_scaffold/', 7, 1, '2012-02-02 12:00:00');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (1, NULL, 'Website', 'img/globe.gif', 'http://www.osezno-framework.org', 1, 1, '2011-10-01 12:53:04');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (4, NULL, 'Foro', 'img/question.gif', 'http://www.osezno-framework.org/foro/', 4, 1, '2011-10-01 12:56:02');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (24, NULL, 'Administraci�n', 'Seleccione...', '', 5, 1, '2011-10-01 12:56:23');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (2, NULL, 'Documentaci�n', 'img/cd.gif', 'http://www.osezno-framework.org/doc/', 2, 1, '2011-10-01 12:56:32');

#bloq

INSERT INTO ess_menu (id, menu_id, description, icon, url, ord, usuario_id, datetime)
VALUES (3, NULL, 'Demos', 'img/base.gif', 'http://www.osezno-framework.org/demos/forms1/', 3, 1, '2011-10-01 12:57:03');

#bloq

INSERT INTO ess_profiles (id, name, description, user_id, datetime)
VALUES (1, 'Admin', 'Admin', 1, '2011-09-21 23:27:40');

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (1, 1, 1);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (2, 1, 2);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (3, 1, 3);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (4, 1, 4);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (5, 1, 24);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (6, 1, 25);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (7, 1, 26);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (8, 1, 27);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (9, 1, 28);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (10, 1, 32);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (11, 1, 33);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (12, 1, 31);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (13, 1, 29);

#bloq

INSERT INTO ess_profiles_detail (id, profiles_id, menu_id)
VALUES (14, 1, 34);

#bloq

INSERT INTO ess_system_users (id, user_name, name, lastname, passwd, status, profile_id, datetime)
VALUES (1, 'root', 'Root', 'Root', 'b4b8daf4b8ea9d39568719e1e320076f', '1', 1, '2011-09-21 23:22:35');

#bloq

ALTER TABLE ONLY "ess_bit"
    ADD CONSTRAINT ess_bit_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY ess_master_tables
    ADD CONSTRAINT ess_master_tables_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY ess_master_tables_detail
    ADD CONSTRAINT ess_master_tables_detail_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY ess_menu
    ADD CONSTRAINT ess_menu_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY ess_profiles
    ADD CONSTRAINT ess_profiles_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY ess_profiles_detail
    ADD CONSTRAINT ess_profiles_detail_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY ess_system_users
    ADD CONSTRAINT ess_system_users_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY ess_usronline
    ADD CONSTRAINT ess_usronline_pkey PRIMARY KEY (id);

#bloq

ALTER TABLE ONLY "ess_bit"
    ADD CONSTRAINT ess_bit_fk FOREIGN KEY (usuario_id) REFERENCES ess_system_users(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_master_tables
    ADD CONSTRAINT ess_master_tables_fk FOREIGN KEY (user_id) REFERENCES ess_system_users(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_master_tables_detail
    ADD CONSTRAINT ess_master_tables_detail_fk FOREIGN KEY (master_tables_id) REFERENCES ess_master_tables(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_master_tables_detail
    ADD CONSTRAINT ess_master_tables_detail_fk1 FOREIGN KEY (user_id) REFERENCES ess_system_users(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_menu
    ADD CONSTRAINT ess_menu_fk FOREIGN KEY (menu_id) REFERENCES ess_menu(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_menu
    ADD CONSTRAINT ess_menu_fk1 FOREIGN KEY (usuario_id) REFERENCES ess_system_users(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_profiles
    ADD CONSTRAINT ess_profiles_fk FOREIGN KEY (user_id) REFERENCES ess_system_users(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_profiles_detail
    ADD CONSTRAINT ess_profiles_detail_fk FOREIGN KEY (profiles_id) REFERENCES ess_profiles(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_profiles_detail
    ADD CONSTRAINT ess_profiles_detail_fk1 FOREIGN KEY (menu_id) REFERENCES ess_menu(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

ALTER TABLE ONLY ess_system_users
    ADD CONSTRAINT ess_system_users_user_name_key UNIQUE (user_name);

#bloq

ALTER TABLE ONLY ess_system_users
    ADD CONSTRAINT ess_system_users_fk FOREIGN KEY (profile_id) REFERENCES ess_profiles(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;

#bloq

SELECT pg_catalog.setval('ess_bit_id_seq', 1, false);

#bloq

SELECT pg_catalog.setval('ess_master_tables_id_seq', 1, false);

#bloq

SELECT pg_catalog.setval('ess_master_tables_detail_id_seq', 1, false);

#bloq

SELECT pg_catalog.setval('ess_menu_id_seq', 35, false);

#bloq

SELECT pg_catalog.setval('ess_profiles_id_seq', 2, false);

#bloq

SELECT pg_catalog.setval('ess_profiles_detail_id_seq', 16, false);

#bloq

SELECT pg_catalog.setval('ess_system_users_id_seq', 2, false);

#bloq

SELECT pg_catalog.setval('ess_usronline_id_seq', 1, false);

#bloq

COMMENT ON SCHEMA public IS 'standard public schema';