/*==============================================================*/
/* Table : produit                                          */
/*==============================================================*/
create table produit  (
    id                  int(11)         not null       auto_increment,
    sale_date            date            not null,
    author               varchar(200)    not null,
    description          LONGTEXT,
    author               varchar(200)    not null,
    constraint pk_activity primary key (activity_id)
);