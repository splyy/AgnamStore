alter table item
   add constraint fk_item_item_type foreign key (item_type_id)
      references item_type (item_type_id);

alter table item
   add constraint fk_item_item_genre  foreign key (item_genre _id)
      references item_genre  (item_genre _id);

