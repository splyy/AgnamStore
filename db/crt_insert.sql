/*==============================================================*/
/* Insert Table : Type                                          */
/*==============================================================*/
insert into item_type values(1, "Manga");
insert into item_type values(2, "Anime");
insert into item_type values(3, "Light Novel");
insert into item_type values(4, "Film");

/*==============================================================*/
/* Insert Table : Genre                                          */
/*==============================================================*/
insert into item_genre values("FT", "Fantasy");
insert into item_genre values("HO", "Horreur");
insert into item_genre values("SC", "Scolaire");
insert into item_genre values("AV", "Aventure");
insert into item_genre values("SF", "Science Fiction");
insert into item_genre values("PO", "Policier");
insert into item_genre values("DR", "Dramatique");
insert into item_genre values("HU", "Humoristique");
insert into item_genre values("HS", "Historique");

/*==============================================================*/
/* Insert Table : Item                                          */
/*==============================================================*/

/* ANIME*/
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Hunter X Hunter", "", 2011, "Yoshihiro Togashi", "BLABLA", "a_th_hxh.png", "a_img_hxh.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Fairy Tail", "", 2011, "Hiro Mashima", "BLABLA", "a_th_ft.png", "a_img_ft.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Naruto", "", 2011, "blabla", "blabla", "a_th_naruto.png", "a_img_naruto.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Elfen Lied", "", 2002, "Lynn Okamoto", "BLABLA", "a_th_elfen.png", "a_img_elfen.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Gantz", "", 2000, "Hiroya Oku", "BLABLA", "a_th_gantz.png", "a_img_gantz.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("School Rumble", "", 2003, "Jin Kobayashi", "BLABLA", "a_th_rumble.png", "a_img_rumble.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("GTO", "", 1997, "Toru Fujisawa", "BLABLA", "a_th_gto.png", "a_img_gto.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Hikaru No Go", "", 1998, "Yumi Hotta", "BLABLA", "a_th_hikaru.png", "a_img_hikaru.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Zipang", "", 2000, "", "BLABLA", "a_th_zipang.png", "a_img_zipang.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Gurren Lagann", "", 2007, "Hiroyuki Imaishi", "BLABLA", "a_th_gurren.png", "a_img_gurren.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Ranma 1/2", "", 1987, "Rumiko Takahashi", "BLABLA", "a_th_ranma.png", "a_img_ranma.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Angel Beats", "", 2009, "Jun Maeda", "BLABLA", "a_th_angel.png", "a_img_angel.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("RahXephon", "", 2002, "Yutaka Izubuchi", "BLABLA", "a_th_rah.png", "a_img_rah.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Death Note", "", 2003, "Tsugumi Oba", "BLABLA", "a_th_death.png", "a_img_death.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Nicky Larson", "", 1987, "Kenji Kodama", "BLABLA", "a_th_nicky.png", "a_img_nicky.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Darker than Black", "", 2007, "Tensai Okamura", "BLABLA", "a_th_darker.png", "a_img_darker.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Ghost in the Shell", "", 1989, "Masamune Shirow", "BLABLA", "a_th_ghost.png", "a_img_ghost.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("One Piece", "", 1997, "Eiichiro Oda", "BLABLA", "a_th_piece.png", "a_img_piece.png", 2);

/* MANGA */
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Hunter X Hunter", "", 2011, "Yoshihiro Togashi", "BLABLA", "m_th_hxh.png", "m_img_hxh.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Fairy Tail", "", 2011, "Hiro Mashima", "BLABLA", "m_th_ft.png", "m_img_ft.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Naruto", "", 2011, "blabla", "blabla", "m_th_naruto.png", "m_th_naruto.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Elfen Lied", "", 2011, "Lynn Okamoto", "BLABLA", "m_th_elfen.png", "m_img_elfen.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Gantz", "", 2000, "Hiroya Oku", "BLABLA", "m_th_gantz.png", "m_img_gantz.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("School Rumble", "", 2003, "Jin Kobayashi", "BLABLA", "m_th_rumble.png", "m_img_rumble.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Special A", "", 2003, "Minami Maki", "BLABLA", "m_th_special.png", "m_img_special.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Rave", "", 1999, "Hiro Mashima", "BLABLA", "m_th_rave.png", "m_img_rave.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Cobra", "", 1978, "Buichi Terasawa", "BLABLA", "m_th_rumble.png", "m_img_rumble.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Mobile Suit Gundam Seed", "", 2002, "Mitsuo Fukuda", "BLABLA", "m_th_gundam.png", "m_img_gundam.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Détective Conan", "", 1994, "Gosho Aoyama", "BLABLA", "a_th_conan.png", "a_img_conan.png", 2);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Bus Gamer", "", 1999, "Kazuya Minekura", "BLABLA", "m_th_bus.png", "m_img_bus.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Kenshin le vagabond", "", 1994, "Nobuhiro Watsuki", "BLABLA", "m_th_kenshin.png", "m_img_kenshin.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Samourai Deeper Kyo", "", 1999, "Akimine Kamijyo", "BLABLA", "m_th_kyo.png", "m_img_kyo.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Pandora Hearts", "", 2006, "Jun Mochizuki", "BLABLA", "m_th_pandora.png", "m_img_pandora.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Vampire Knight", "", 2004, "Matsuri Hino", "BLABLA", "m_th_vampire.png", "m_img_vampire.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Lucky Star", "", 2004, "Kagami Yoshimizu", "BLABLA", "m_th_lucky.png", "m_img_lucky.png", 1);
insert into item(name, sale_date, year, author, description, thumbnails, image, item_type_id) 
	values("Ixion Saga DT", "", 2012, "Shinji Takamatsu", "BLABLA", "m_th_ixion.png", "m_img_ixion.png", 1);

/* LIGHT NOVEL */

/* FILM */
