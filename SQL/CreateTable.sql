drop table if exists Call_Header;

create table Call_Header
(
    Callid        int                                      not null,
    Date          DATETIME                                 null,
    ITPerson      varchar(32)                              null,
    UserName      varchar(32)                              not null,
    Subject       varchar(64)                              null,
    Details       TEXT                                     null,
    Total_Hours   int                                      null,
    Total_Minutes int                                      null,
    Status        enum ('New', 'In Progress', 'Completed') not null,
    constraint Call_Header_pk
        primary key (Callid)
);

drop table if exists Call_Details;

create table Call_Details
(
    Callid  int      not null,
    Date    datetime null,
    Details text     null,
    Hours   int      null,
    Minutes int      null,
    id      int auto_increment
        primary key,
    constraint Call_Details_Call_Header_Callid_fk
        foreign key (Callid) references Call_Header (Callid)
);

-- Create triggers

drop trigger if exists insert_hours_minutes_call_details;
create trigger insert_hours_minutes_call_details
    Before insert
    on Call_Details
    for each row
BEGIN
    set @total_hours = (select IFNULL(Total_Hours, 0) from Call_Header where Call_Header.Callid = new.Callid);
set @total_minutes = (select IFNULL(Total_Minutes, 0) from Call_Header where Call_Header.Callid = new.Callid);
    update Call_Header
    set Call_Header.Total_Hours=@total_hours + new.Hours,
        Call_Header.Total_Minutes=@total_minutes + new.Minutes
    where Call_Header.Callid = new.Callid;
END;

drop trigger if exists update_hours_minutes_call_details;
create trigger update_hours_minutes_call_details
    Before update
    on Call_Details
    for each row
BEGIN
    set @total_hours = (select IFNULL(Total_Hours, 0) from Call_Header where Call_Header.Callid = old.Callid);
set @total_minutes = (select IFNULL(Total_Minutes, 0) from Call_Header where Call_Header.Callid = old.Callid);
    update Call_Header
    set Call_Header.Total_Hours=@total_hours - old.Hours,
        Call_Header.Total_Minutes=@total_minutes - old.Minutes
    where Call_Header.Callid = old.Callid;

    set @total_hours = (select IFNULL(Total_Hours, 0) from Call_Header where Call_Header.Callid = new.Callid);
    set @total_minutes = (select IFNULL(Total_Minutes, 0) from Call_Header where Call_Header.Callid = new.Callid);
    update Call_Header
    set Call_Header.Total_Hours=@total_hours + new.Hours,
        Call_Header.Total_Minutes=@total_minutes + new.Minutes
    where Call_Header.Callid = new.Callid;
END;

drop trigger if exists delete_hours_minutes_call_details;
create trigger delete_hours_minutes_call_details
    Before delete
    on Call_Details
    for each row
BEGIN
    set @total_hours = (select IFNULL(Total_Hours, 0) from Call_Header where Call_Header.Callid = old.Callid);
set @total_minutes = (select IFNULL(Total_Minutes, 0) from Call_Header where Call_Header.Callid = old.Callid);
    update Call_Header
    set Call_Header.Total_Hours=@total_hours - old.Hours,
        Call_Header.Total_Minutes=@total_minutes - old.Minutes
    where Call_Header.Callid = old.Callid;
END;