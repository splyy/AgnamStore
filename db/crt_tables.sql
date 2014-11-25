/*==============================================================*/
/* Table : item                                                 */
/*==============================================================*/
create table item  (
    item_id                     int(11)         not null       auto_increment,
    price                       decimal(21,2)   not null,
    name                        varchar(50)     not null,
    sale_date                   date            not null,
    year                        int(4)          not null,
    author                      varchar(200)    not null,
    description                 LONGTEXT,
    image                       varchar(200),
    item_type_id                int(11)         not null,
    constraint pk_item primary key (item_id)
);
/*==============================================================*/
/* Table : item_type                                            */
/* Exemple Manga, anime, light novel(roman japonais)            */                                                 
/*==============================================================*/
create table item_type  (
    item_type_id                int(11)         not null,
    type_label                  varchar(200)    not null,
    constraint pk_item_type primary key (item_type_id)
);

/*==============================================================*/
/* Table : item_genre                                           */
/* Exemple Fantastique,Science fiction, horeur, aventure        */                                                 
/*==============================================================*/
create table item_genre  (
    item_genre_id            char(2)         not null,
    item_genre_label         varchar(200)    not null,
    constraint pk_item_genre primary key (item_genre_id)
);

/*==============================================================*/
/* Association : entre item et item_genre                        */                                                
/*==============================================================*/
create table possede_genre (
    item_genre_id               char(2)         not null,
    item_id                     int(11)         not null,
    constraint pk_possede_genre primary key (item_genre_id,item_id)
)

/*==============================================================*/
/* Table : user                                                 */                                                
/*==============================================================*/
create table user (
    user_id                     int(11)         not null auto_increment,
    user_email                   varchar(50)    not null,
    user_password               varchar(88)     not null,
    user_salt                   varchar(23)     not null,
    user_role                   varchar(50)     not null,
    user_firstname              varchar(50),
    user_lastname               varchar(50),
    user_address                varchar(50),
    user_city                   varchar(50),
    user_cp                     varchar(50),
    constraint pk_user primary key (user_id)
) 
