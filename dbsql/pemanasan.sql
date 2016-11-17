-- DROPPING TABLE --
DROP TABLE time_table;
DROP TABLE scoreboard;
DROP TABLE login_cpanel;
DROP TABLE login;
DROP TABLE submission;
DROP TABLE problem;
DROP TABLE contestant;

create table contestant (
  name_code VARCHAR(10) PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  school VARCHAR(50) NOT NULL
);

create table login_cpanel (
  username VARCHAR(25) PRIMARY KEY,
  password VARCHAR(25),
  nama_admin VARCHAR(50),
  admin_code VARCHAR(10)
);

INSERT INTO login_cpanel VALUES('leopisangg', 'kampretos666', 'PisanGG','adm01');
INSERT INTO login_cpanel VALUES('hobert', 'kampretos666', 'Hobert','adm02');

create table login (
  username VARCHAR(15) PRIMARY KEY,
  password VARCHAR(10),
  name_code VARCHAR(10) CONSTRAINT lg_nmc_fk REFERENCES contestant(name_code) ON DELETE CASCADE
);

CREATE TABLE problem (
  prob_num VARCHAR(2) PRIMARY KEY,
  solution_query VARCHAR2(255)
);

----- SET SOALNYAAAAAAAAAAAAAAAAAAA----------------------------------
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('1', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('2', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('3', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('4', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('5', 'SELECT');



CREATE TABLE submission (
  sub_id VARCHAR(11) PRIMARY KEY,
  name_code VARCHAR(10) CONSTRAINT subm_nmc_fk REFERENCES contestant(name_code) ON DELETE CASCADE ,
  submitted_text VARCHAR2(255) NOT NULL,
  prob_num VARCHAR2(2) NOT NULL CONSTRAINT subm_submtd_fk REFERENCES problem(prob_num),
  status INT NOT NULL, 
  submit_time INT NOT NULL,
  verifier VARCHAR(50)
);


--SUBMIT TIME IN SECONDS----
CREATE TABLE scoreboard (
  name_code CONSTRAINT sc_nc_fk REFERENCES contestant(name_code) ON DELETE CASCADE,
  prob_num INT,
  submit_count INT,
  submit_time INT,
  time_after_penalty as (submit_time + (submit_count*8)),
  verdict INT NOT NULL,
  CONSTRAINT tots_nc_pn_compokey PRIMARY KEY (name_code, prob_num)
);
--time in MINUTES--

CREATE TABLE time_table (
  idx INT PRIMARY KEY,
  start_time TIMESTAMP NOT NULL,
  end_time TIMESTAMP NOT NULL,
  activate_time TIMESTAMP NOT NULL
);

--- SETTING TIMENYA JANGAN LUPA!!!!!!!!!!!!!!--------------------------------
INSERT INTO time_table (idx, start_time, end_time, activate_time) 
VALUES ('1', TO_TIMESTAMP ('2016-11-15 01:00', 'YYYY-MM-DD HH24:MI') ,TO_TIMESTAMP ('2016-11-15 06:00', 'YYYY-MM-DD HH24:MI') ,TO_TIMESTAMP ('2016-11-14 23:00', 'YYYY-MM-DD HH24:MI'));
--- SETTING TIMENYA JANGAN LUPA!!!!!!!!!!!!!!--------------------------------
commit;

--JANGAN LUPA COMMIT!!!!!----------------------------------------------------

select * from time_table;

---EDIT TIME--
UPDATE time_table SET start_time = TO_TIMESTAMP ('2016-11-16 10:00', 'YYYY-MM-DD HH24:MI') , 
end_time = TO_TIMESTAMP ('2016-11-16 10:30', 'YYYY-MM-DD HH24:MI') ,
activate_time = TO_TIMESTAMP ('2016-11-16 00:00', 'YYYY-MM-DD HH24:MI');
commit;
------------------------------------------------------------

-- INIT AWAL DATABASE --
CREATE SMALLFILE TABLESPACE users datafile '/u01/app/oracle/oradata/ORCL/users,.dbf' size 10g;
ALTER DATABASE default TABLESPACE users;
CREATE ROLE peserta;
GRANT CREATE SESSION, CONNECT ,CREATE TABLE TO peserta;
------------------------------------------------------------
select * from scoreboard;
select * from login;


ALTER USER SYSTEM ACCOUNT UNLOCK;
select s.name_code, (select count(*) from scoreboard sc where verdict = 0 and  sc.name_code = s.name_code) as total_AC, (select sum(sco.time_after_penalty) from scoreboard sco where sco.name_code = s.name_code) as total_Time from scoreboard s group by name_code order by total_ac desc, total_time asc;