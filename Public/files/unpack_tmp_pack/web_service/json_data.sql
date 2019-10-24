create table json_data(
	id int identity(1,1) primary key,
	json_text text,
	sendid varchar(50),
	write_date datetime,
	isread varchar(50)
)



create table json_log(
	id int identity(1,1) primary key,
	url varchar(100),
	write_date datetime
)

create table json_other(
	id int identity(1,1) primary key,
	textstr text,
	write_date datetime
)

select * from json_data
select * from json_log
select * from json_other