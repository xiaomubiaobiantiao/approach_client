-------------------------------------------------------------------------------------------
------------------------       qgsh_report       -----------------------
-------------------------------------------------------------------------------------------
if not exists (select * from sysobjects where id = object_id(N'[qgsh_report]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) 
begin
     create table qgsh_report
     (
         id int identity(1,1) not null,
         primary key(id)
     )
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='reqno')
begin
     alter table qgsh_report add reqno varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='visit_id')
begin
     alter table qgsh_report add visit_id varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='pathosid')
begin
     alter table qgsh_report add pathosid varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='sick_id')
begin
     alter table qgsh_report add sick_id varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='pattype')
begin
     alter table qgsh_report add pattype varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='jcyybh')
begin
     alter table qgsh_report add jcyybh varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='kpbh')
begin
     alter table qgsh_report add kpbh varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='xm')
begin
     alter table qgsh_report add xm varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='xb')
begin
     alter table qgsh_report add xb varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='nl')
begin
     alter table qgsh_report add nl varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='sfzhm')
begin
     alter table qgsh_report add sfzhm varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='lxdh')
begin
     alter table qgsh_report add lxdh varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='hj')
begin
     alter table qgsh_report add hj varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='whcd')
begin
     alter table qgsh_report add whcd varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='zy')
begin
     alter table qgsh_report add zy varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shfssj')
begin
     alter table qgsh_report add shfssj datetime 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shjzsj')
begin
     alter table qgsh_report add shjzsj datetime 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shfsyy')
begin
     alter table qgsh_report add shfsyy varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shfsyyqt')
begin
     alter table qgsh_report add shfsyyqt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shfsdd')
begin
     alter table qgsh_report add shfsdd varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shfsddqt')
begin
     alter table qgsh_report add shfsddqt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shfsshd')
begin
     alter table qgsh_report add shfsshd varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shfsshdqt')
begin
     alter table qgsh_report add shfsshdqt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='sfgy')
begin
     alter table qgsh_report add sfgy varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='yjqk')
begin
     alter table qgsh_report add yjqk varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shxz')
begin
     alter table qgsh_report add shxz varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shxzqt')
begin
     alter table qgsh_report add shxzqt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shbw')
begin
     alter table qgsh_report add shbw varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shbwqt')
begin
     alter table qgsh_report add shbwqt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shljxt')
begin
     alter table qgsh_report add shljxt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shljxtqt')
begin
     alter table qgsh_report add shljxtqt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shyzcd')
begin
     alter table qgsh_report add shyzcd varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shlczd')
begin
     alter table qgsh_report add shlczd varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shjj')
begin
     alter table qgsh_report add shjj varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shjjqt')
begin
     alter table qgsh_report add shjjqt varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='tbr')
begin
     alter table qgsh_report add tbr varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='docid')
begin
     alter table qgsh_report add docid varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='tbrq')
begin
     alter table qgsh_report add tbrq varchar(150) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='distno')
begin
     alter table qgsh_report add distno varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='distname')
begin
     alter table qgsh_report add distname varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='grflag')
begin
     alter table qgsh_report add grflag varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='checker')
begin
     alter table qgsh_report add checker varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='checkdate')
begin
     alter table qgsh_report add checkdate datetime 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='isupdate')
begin
     alter table qgsh_report add isupdate varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='dayin')
begin
     alter table qgsh_report add dayin varchar(50) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shsjwpmca')
begin
     alter table qgsh_report add shsjwpmca varchar(100) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='shsjwpmcb')
begin
     alter table qgsh_report add shsjwpmcb varchar(100) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='cpzlsfyg')
begin
     alter table qgsh_report add cpzlsfyg varchar(100) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='cpzsjs')
begin
     alter table qgsh_report add cpzsjs varchar(100) 
end
if not exists(select * from syscolumns where id=object_id('qgsh_report') and name='dxallx')
begin
     alter table qgsh_report add dxallx varchar(100) 
end
