use agnamstore;
alter table item
   add constraint fk_item_item_type foreign key (item_type_id)
      references item_type (item_type_id);

alter table possede_genre
   add constraint fk_possede_genre_item foreign key (item_id)
      references item (item_id);

alter table possede_genre
   add constraint fk_possede_genre_item_genre foreign key (item_genre_id)
      references item_genre (item_genre_id);

alter table line_cart
   add constraint fk_line_cart_user foreign key (user_id)
      references user (user_id);

alter table line_cart
   add constraint fk_line_cart_item foreign key (item_id)
      references item (item_id);


