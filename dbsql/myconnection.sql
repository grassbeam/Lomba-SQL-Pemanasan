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

INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('1', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('2', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('3', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('4', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('5', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('6', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('7', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('8', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('9', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('10', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('11', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('12', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('13', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('14', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('15', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('16', 'SELECT');
INSERT INTO PROBLEM (PROB_NUM, SOLUTION_QUERY) VALUES ('17', 'SELECT');
------------------- JUMLAH PROBLEM GAK HARUS LEBIH 1!!!!-------------------


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

INSERT INTO time_table (idx, start_time, end_time, activate_time) 
VALUES ('1', TO_TIMESTAMP ('2016-11-15 01:00', 'YYYY-MM-DD HH24:MI') ,TO_TIMESTAMP ('2016-11-15 06:00', 'YYYY-MM-DD HH24:MI') ,TO_TIMESTAMP ('2016-11-14 23:00', 'YYYY-MM-DD HH24:MI'));

commit;

--JANGAN LUPA COMMIT!!!!!----------------------------------------------------

CREATE USER pemanasan IDENTIFIED BY SQLc2016untar;

GRANT CONNECT, RESOURCE, DBA TO pemanasan;

UPDATE time_table SET start_time = TO_TIMESTAMP ('2016-11-15 02:00', 'YYYY-MM-DD HH24:MI') , 
end_time = TO_TIMESTAMP ('2016-11-15 5:00', 'YYYY-MM-DD HH24:MI') ,
activate_time = TO_TIMESTAMP ('2016-11-15 00:00', 'YYYY-MM-DD HH24:MI');
commit;

create table peserta( id_peserta varchar2(6) not null, nama varchar2(20) not null, jurusan varchar2(30) not null, total_sks number not null, primary key(id_peserta));
create table pelajaran( kode_p varchar2(8) not null, mata_pelajaran varchar2(30) not null, jurusan varchar2(20) not null, sks number not null, primary key(kode_p));

COMMIT;
DROP USER sqluntar005 CASCADE;
DROP CASCADE USER  sqluntar001;
CREATE USER sqluntar001 IDENTIFIED BY 90955;
drop user sqluntar001;
create table sqluntar001.peserta( id_peserta varchar2(6) not null, nama varchar2(20) not null, jurusan varchar2(30) not null, total_sks number not null, primary key(id_peserta));


SELECT c.name_code, c.name, c.school, count(verdict) verd , Sum(s.time_after_penalty) totscore FROM scoreboard s JOIN contestant c ON(s.name_code = c.name_code) WHERE s.verdict!=0 group by c.name_code, c.name, c.school ORDER BY verd asc, totscore asc;


select * from time_table;

select s.sub_id, s.prob_num, s.status, s.submit_time, p.solution_query from submission s , problem p WHERE s.prob_num = p.prob_num AND s.name_code = 'sql-001' ORDER BY s.submit_time DESC;
truncate table submission;

SELECT (select extract( day from diff )*24*60*60 +
 extract( hour from diff )*60*60 +
  extract( minute from diff ) *60+
  round(extract( second from diff )) total_SECONDS
  from (select systimestamp - end_time diff from time_table)) CHECKER, (select extract( day from diff )*24*60*60 +
 extract( hour from diff )*60*60 +
  extract( minute from diff ) *60+
  round(extract( second from diff )) total_SECONDS
  from (select systimestamp - start_time diff from time_table)) DIFF FROM dual;
  
  select extract( day from diff )*24*60*60 +
 extract( hour from diff )*60*60 +
  extract( minute from diff ) *60+
  round(extract( second from diff )) total_SECONDS
  from (select systimestamp - end_time diff from time_table)

select extract( day from diff )*24*60 +
 extract( hour from diff )*60 +
  extract( minute from diff ) total_MINUTES
  from (select systimestamp - start_time diff from time_table);


select systimestamp - start_time from time_table;
TRUNCATE TABLE time_table;
INSERT INTO time_table (idx, start_time, end_time) VALUES ('1', TO_TIMESTAMP ('2016-11-13 04:12', 'YYYY-MM-DD HH24:MI') ,TO_TIMESTAMP ('2016-11-13 05:05', 'YYYY-MM-DD HH24:MI'));
commit;
select (24*60*60*(end_time - start_time)) as KAMPRET from time_table;

INSERT INTO submission (sub_id, name_code, submitted_text, prob_num, status, submit_time) VALUES ('asd123', 'sql-001', 'e:/asem', '1' ,'3' , '');
COMMIT;  
INSERT INTO time_table (idx, start_time, end_time, activate_time) 
VALUES ('1', TO_TIMESTAMP ('2016-11-15 01:00', 'YYYY-MM-DD HH24:MI') ,TO_TIMESTAMP ('2016-11-15 06:00', 'YYYY-MM-DD HH24:MI') ,TO_TIMESTAMP ('2016-11-14 23:00', 'YYYY-MM-DD HH24:MI'));

select * from time_table;
select * from login;


commit;
SELECT TO_DATE (start_time, 'YYYY-MM-DD HH:MI:SS') FROM time_table;
select ((extract(day from int_val)
  + extract(hour from int_val) / 24
  + extract(minute from int_val) / (24 * 60)
  + extract(second from int_val) / (24 * 60 * 60))
  * power(2,44)) + power(2,60)
as z
from (
select activate_time - timestamp '1970-01-01 00:00:00' as int_val from time_table);

SELECT (TO_DATE (TO_CHAR (end_time, 'YYYY-MON-DD HH24:MI:SS'),
                'YYYY-MON-DD HH24:MI:SS'
               ) - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) * 24 * 60 * 60 * 1000 AS y FROM time_table;

SELECT TO_CHAR (end_time, 'YYYY-MON-DD HH24:MI:SS') as Y FROM time_table;
select * from time_table;
SELECT round((SYSDATE - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) , 9) * 24 * 60 * 60  AS X FROM DUAL;
select * from time_table;
SELECT (TO_DATE (TO_CHAR (start_time, 'YYYY-MON-DD HH24:MI:SS'),
                'YYYY-MON-DD HH24:MI:SS'
               ) - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) * 24 * 60 * 60 * 1000 AS x FROM time_table;


SELECT (TO_DATE (TO_CHAR (activate_time, 'YYYY-MON-DD HH24:MI:SS'),
                'YYYY-MON-DD HH24:MI:SS'
               ) - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) * 24 * 60 * 60 * 1000 AS z FROM time_table;



drop table kampret;
INSERT INTO kampret (date) VALUES ( '01-01-1970 00:00:00') ;

select * FROM time_table;
select ((extract(day from int_val)
  + extract(hour from int_val) / 24
  + extract(minute from int_val) / (24 * 60)
  + extract(second from int_val) / (24 * 60 * 60))
  * power(2,44)) + power(2,60)
as x
from (
select start_time - timestamp '1970-01-01 00:00:00' as int_val from time_table);


select ((extract(day from int_val)
  + extract(hour from int_val) / 24
  + extract(minute from int_val) / (24 * 60)
  + extract(second from int_val) / (24 * 60 * 60))
  * power(2,44)) + power(2,60)
as y
from (
select end_time - timestamp '1970-01-01 00:00:00' as int_val from time_table);


SELECT c.name_code, c.name, c.school, t.score FROM contestant c, totalscore t WHERE c.name_code = t.name_code ORDER BY t.score DESC;
commit;

-- INIT AWAL DATABASE --
CREATE SMALLFILE TABLESPACE users datafile '/u01/app/oracle/oradata/ORCL/users,.dbf' size 10g;
ALTER DATABASE default TABLESPACE users;
CREATE ROLE peserta;
GRANT CREATE SESSION, CONNECT ,CREATE TABLE TO peserta;

-- UNTUK IMPORT / CREATE PESERTA BARU --
CREATE USER leo IDENTIFIED BY leo123;
GRANT peserta TO sqluntar001;
ALTER user leo quota 50m on users;
-- --------------------------------- --

DROP USER kampret;
CREATE USER kampret IDENTIFIED by "666kg";
CREATE USER ;

select extract( day from diff )*24*60*60 +
 extract( hour from diff )*60*60 +
  extract( minute from diff ) *60+
  round(extract( second from diff )) total_SECONDS
  from (select systimestamp - start_time diff from time_table);

select ((extract(day from int_val)
  + extract(hour from int_val) / 24
  + extract(minute from int_val) / (24 * 60)
  + extract(second from int_val) / (24 * 60 * 60))
  * power(2,44)) + power(2,60)
as x
from (
select systimestamp - to_timestamp( '1970-01-01 00:00:00', 'YYYY-MM-MM HH24:m') as int_val from dual);

SELECT s.*, c.name FROM submission s, contestant c WHERE s.name_code = c.name_code AND status = '3';
SELECT * FROM login;
SELECT * FROM time_table;
SELECT * FROM contestant;
SELECT * FROM submission;
UPDATE submission SET status = 1, verifier = 'kampretos666'  WHERE sub_id = 'ac3be0c473c';
commit;
SELECT count(*) accepted FROM scoreboard WHERE verdict = 0 AND name_code = 'sql-001';
SELECT c.name_code, c.name, c.school, Sum(s.time_after_penalty) totscore FROM scoreboard s JOIN contestant c ON(s.name_code = c.name_code) group by c.name_code, c.name, c.school ORDER BY totscore DESC;
SELECT name_code, SUM(time_after_penalty),  total_score FROM scoreboard GROUP BY name_code ;
SELECT PROB_NUM, SUBMIT_COUNT, TIME_AFTER_PENALTY FROM scoreboard WHERE name_code = 'sql-001';
SELECT NAME_CODE, submit_count, time_after_penalty FROM scoreboard WHERE prob_num = '1' ORDER BY SUBMIT_COUNT DESC, time_after_penalty ASC;
SELECT COUNT(*) total_submit FROM scoreboard WHERE name_code = 'sql-001' AND verdict = '1';
SELECT * FROM problem;
select * from time_table;
SELECT TO_CHAR(start_time, 'DD-MON-YYYY HH24:MI:SS') FROM time_table;
SELECT TO_char(start_time - end_time, 'HH24:MI') from time_table;

desc scoreboard;
Select * from scoreboard WHERE name_code = 'sql-001' ORDER BY prob_num asc;
SELECT name_code, count(verdict) FROM scoreboard WHERE  ;
SELECT c.name_code, c.name, c.school, count(verdict) verd , Sum(s.time_after_penalty) totscore FROM scoreboard s JOIN contestant c ON(s.name_code = c.name_code) WHERE s.verdict!=0 group by c.name_code, c.name, c.school ORDER BY verd asc, totscore asc;
SELECT COALESE((select name_code, count(verdict) FROM scoreboard WHERE verdict = '3' GROUP BY name_code) ,0);
SELECT DISTINCT * FROM scoreboard ORDER BY SUBMIT_COUNT DESC , TIME_AFTER_PENALTY ASC;
select name_code, count(verdict) FROM scoreboard WHERE verdict = '3' GROUP BY name_code
Select DISTINCT name_code  FROM scoreboard;
select name_code, count(verdict) FROM scoreboard WHERE verdict = '3' GROUP BY name_code;
CREATE TABLE kampret (
total_seconds INT PRIMARY KEY
);

Select name_code, count(verdict), total_time from scoreboard group by id;

select * from contestant;
select *from scoreboard;

select count(*) from contestant;
SELECT name_code, SUM(time_after_penalty) sum_time, COUNT(VERDICT) verd FROM scoreboard WHERE verdict != 0 GROUP BY name_code ORDER BY verd asc, sum_time asc;
SELECT COUNT(*)-1 FROM problem;
INSERT INTO kampret VALUES(20);
SELECT * from kampret;

TRUNCATE TABLE contestant;
TRUNCATE TABLE totalscore;
DELETE FROM contestant;
Select * from scoreboard WHERE name_code = 'sql-001' ORDER BY prob_num asc;
CREATE TABLE hobert.pesertaInsert (

select extract( day from diff )*24*60*60 +
 extract( hour from diff )*60*60 +
  extract( minute from diff ) *60+
  round(extract( second from diff )) TOTAL_SECONDS
  from (select systimestamp - start_time diff from time_table);