/*==============================================================*/
/* Table : item                                                 */
/*==============================================================*/
create table item  (
    item_id                     int(11)         not null       auto_increment,
    name                        varchar(50)     not null,
    sale_date                   date            not null,
    year                       int(4)          not null,
    author                      varchar(200)    not null,
    description                 LONGTEXT,
    thumbnails                    varchar(200),
    image                  varchar(200),
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
/* Association : entre item et item_genre                       */                                                
/*==============================================================*/
create table possede_genre (
    item_genre_id            char(2)         not null,
    item_id                     int(11)         not null,
    constraint pk_possede_genre primary key (item_genre_id,item_id)
)

